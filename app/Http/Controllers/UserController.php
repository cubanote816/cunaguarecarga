<?php

namespace App\Http\Controllers;

use App\User;
use App\Contract;
use Illuminate\Http\Request;
use App\Http\Resources\Users as UserResource;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @resource User
 */
class UserController extends Controller
{
    /**
     * Сurrent authenticated user
     *
     * Return current authenticated user data
     *
     * @param Request $request
     * @return mixed
     */
    public function me(Request $request)
    {
        // return $request->user();
        $user = new UserResource($request->user());
        return ['user' => $user];
    }

    /**
     * Users list
     *
     * Display a listing of users
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $this->authorize('index', User::class);

        $users = (new User)->latest();

        if ($request->get('query')) {
            $users->where('name', 'like', '%' . $request->get('query') . '%')
                ->orWhere('email', 'like', '%' . $request->get('query') . '%');
        }

        return ['users' => $users->paginate()];
    }

    /**
     * Show user
     *
     * Display the specified user.
     *
     * @param User $user
     * @return array
     */
    public function show(User $user)
    {
        $this->authorize($user);

        return ['user' => $user];
    }

    /**
     * Update user
     *
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User                      $user
     * @return array
     */
    public function update(Request $request, User $user)
    {
        $this->authorize($user);

        // $this->validate($request, [
        //     'name' => 'required|max:255',
        //     'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        //     'password' => 'min:6|confirmed',
        // ]);

        $user->fill($request->only('name'));
        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Update user role only for admin
        if ($request->get('role') && $request->get('role') !== $user->role) {
            if (! auth()->user()->isAdmin()) abort(401, 'Unathorized to edit user role.');

            if (auth()->id() === $user->id) abort(401, 'You can not revoke your own admin role.');
            $user->role = $request->get('role');
        }

        $user->save();

        return ['user' => $user];
    }

    private function getSellers($id)
      {
        $sellers = Contract::with('hired')
          ->where('contractor', $id)
          ->whereHas("hired", function($q){
            $q->where("deleted_at","=",null);
          })
          ->get();

    // $sellers = new SellerIdCollection($result);
        return $sellers;
      }
    /**
     * Delete user
     *
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return array
     */
    public function destroy(User $user)
    {
        $this->authorize($user);

        // $user->delete();

        // search the users that be seller or reseller of this user
        $ids = array();
        $user_seller = $this->getSellers($user->id);

        switch ($user->role) {
      
          case 'manager': {
            array_push($ids, $user->id);

            foreach($user_seller as $reseller){
              array_push($ids, $reseller->hired);
              $sellersUser= $this->getSellers($reseller->hired);
              foreach($sellersUser as $sellerUser){
                array_push($ids, $sellerUser->hired);
              }
            } 

            foreach ($ids as $id) {
                $user_to_delete = User::findOrFail($id);

                $user_to_delete->delete();
            }
            return ['message' => 'Success'];
            break;
          }
          case 'reseller': {
            array_push($ids, $user->id);

            foreach($user_seller as $sellerUser){
              array_push($ids, $sellerUser->hired);
            }
            foreach ($ids as $id) {
                $user_to_delete = User::findOrFail($id);

                $user_to_delete->delete();
            }
            
            return ['message' => 'Success'];
            break;
          }
          case 'seller': {
                $user->delete();
            // return ['reports' => $report];
            return ['message' => 'Success'];
            break;
          }
    }
    }

/**
     * Status user
     *
     * Status the specified user in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User                      $user
     * @return array
     */
    public function status(Request $request)
    {
        // $this->authorize($user);

        
        // Update user role only for admin
        // if ($request->get('role') && $request->get('role') !== $user->role) {
        //     if (auth()->user()->isSeller()) abort(401, 'Usted no esta autorizado ha modificar el estado de un vendedor');

            $user= User::findOrFail($request->id);
            $user->active = $request->active;
            $user->update();
        // }

    return ['user' => $user];
    }


}
