<?php

namespace App\Http\Controllers;

use App\User;
use App\Contract;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\ConfirmationMember;
use App\Http\Requests\Register;
use Lang;
use Validator;
use App\Notifications\RegisterActivate;

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

        if ($this->attemptLogin($request)) {
            $this->clearLoginAttempts($request);

            /** @var User $user */
            $user = $this->guard()->user();

            return ['user' => $user, 'access_token' => $user->makeApiToken()];
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
    public function register(Register $request)
    {
        //$this->validator($request->all())->validate();
        $me = $request->user()->id;
        event(new Registered($user = $this->create($me, $request->except('agreement'))));

        $contract = new Contract;
        $contract->contractor = $request->user()->id;
        $contract->user_id = $request->user()->id;
        $contract->hired = $user->id;
        $contract->status = 0;
        $contract->agreement = $request->agreement;

        $contract->save();

        $user->notify(new RegisterActivate($user));

        return ['user' => $user, 'access_token' => $user->makeApiToken(), 'all' => $request->all()];
    }

    protected function getRole($me)
    {
        $user = User::where('id', $me)->first();
        switch ($user->role) {
            case 'admin':
                {
                    $role = 'manager';
                    break;
                }
            case 'manager':
                {
                    $role = 'reseller';
                    break;
                }
            case 'reseller':
                {
                    $role = 'seller';
                    break;
                }
        }
        return $role;
    }

    public function registerActivate($token)
    {
        $user = User::where('activation_token', 'gHelzGsr072AYjaC45sQENRLatWWvAwv5gM56p3MBEIeMXoJmEjabL62erW3')->first();
        // if (!$user) {
        //     return response()->json(['message' => 'El token de activación es inválido '.$token], 404);
        // }

        return ['user' => $user, 'token'=> $token];
    }

    public function registerFinish(ConfirmationMember $request, $id)
    {
        $user = User::where('id', $id)->first();

        $user->active = true;
        $user->activation_token = '';
        $user->name = $request->get('name');
        $user->password = bcrypt($request->get('password'));
        $user->save();
        // redirect to login page
//        return redirect('register/finish'.$user->id );
        return ['user' => $user];


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
        $new_user = User::create([
            'name' => $this->getRole($id),
            'email' => $data['email'],
            'role' => 'admin',
            'password' => bcrypt('cunagua'),
            'activation_token' => str_random(60),
        ]);

        return $new_user;
    }
}
