<?php

namespace App\Http\Controllers;

use App\User;
use App\Contract;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\ConfirmationMember;
use App\Http\Requests\RegisterRequest;
use Lang;
use Validator;
use App\Notifications\RegisterActivate;
use App\Http\Resources\Users as UserResource;
use App\Http\Resources\UsersCollection;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers
 * @resource Authentication
 */
class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Login
     *
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Auth\Authenticatable|array
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $seconds = $this->limiter()->availableIn($this->throttleKey($request));

            abort(429, Lang::get('auth.throttle', ['seconds' => $seconds]));
        }

        $check_email = \App\User::where('email', '=', $request->email)
                          ->get();

        if ($check_email->isEmpty()) {
            // The user is doesnt exist
            abort(401, Lang::get('auth.email_empty'));

            // return redirect("/login")
            //     ->withInput($request->only('email', 'remember'))
            //     ->withWarning('Your account is not registered');
        }

        $check_delete = \App\User::where('deleted_at', '=', null)
                          ->get();

        if ($check_delete->isEmpty()) {
            // The user is doesnt exist
            abort(401, Lang::get('auth.account_delete'));

            // return redirect("/login")
            //     ->withInput($request->only('email', 'remember'))
            //     ->withWarning('Your account is not registered');
        }

        $check_active = \App\User::where('email', '=', $request->email)
                          ->where('active', '=', 1)
                          ->get();
        if ($check_active->isEmpty()) {
            // The user is exist but inactive
            // return redirect()->route('auth.login')
            //     ->withInput($request->only('email', 'remember'))
            //     ->withWarning('Your account is inactive or not verified');
            abort(401, Lang::get('auth.inactive'));

        }
// finish checkout
        if ($this->attemptLogin($request)) {
            $this->clearLoginAttempts($request);

            /** @var User $user */
            $user = $this->guard()->user();
            $user_full = new UserResource($user);
            
            return ['user' => $user_full, 'access_token' => $user->makeApiToken(), 'email' => $check_active];
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        abort(401, Lang::get('auth.failed'));
    }

    /**
     * Registration
     *
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function register(Request $request)
    {
        //$this->validator($request->all())->validate();
        $me = $request->user()->id;
        $user = $this->create($me, $request->except('agreement'));

        $contract = new Contract;
        $contract->contractor = $request->user()->id;
        $contract->user_id = $request->user()->id;
        $contract->hired = $user->id;
        $contract->status = 0;
        $contract->agreement = $request->agreement;

        $contract->save();

        $user->notify(new RegisterActivate($user));

        return ['user' => $user];
    }

    public function registerActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return redirect("/login")->with('message', 'El token de activación es inválido '.$token);
            // return response()->json(['message' => 'El token de activación es inválido '.$token], 404);
        }

        return ['user' => $user, 'token'=> $token];
    }

    public function registerFinish(Request $request, $id)
    {
        event(new Registered($user = $this->update($id, $request->all())));
        $user_ready= new UserResource($user);

      return ['user' => $user_ready, 'access_token' => $user->makeApiToken()];
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'email' => 'required|email|max:255|unique:users',
//            'agreement' => 'required|min:2',
//        ]);
//    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create($id, array $data)
    {
        if ($data['role'])
        $role = $data['role'] ;
        else {
          $role = 'seller';
        }
        $new_user = User::create([
            'name' => '',
            'email' => $data['email'],
            'role' => $role,
            'password' => bcrypt('cunagua'),
            'activation_token' => str_random(60),
        ]);

        return $new_user;
    }

    /**
     * Finish a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
      private function update($id, array $data){
        $user = User::where('activation_token', $id)->first();

        $user->active = true;
        $user->activation_token = '';
        $user->name = $data['name'];
        $user->password = bcrypt($data['password']);
        $user->save();
       return $user;
      }
}
