<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $finduser = User::where('provider_id', $user->id)->first();
            if ($finduser) {
                $authUser = Auth::login($finduser);
                $success['access_token'] = $finduser->createToken($finduser->name, [$finduser->role])->plainTextToken;
                $success['token_type'] = 'Bearer';
                $success['name'] = $finduser->name;

                return $this->sendResponse($success, 'Login by '.$provider.' Successfully.');
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider_id' => $user->id,
                    'provider' => $provider,
                    'role' => 'viewer',
                    'password' => encrypt($user->email),
                ]);
                $success['access_token'] = $newUser->createToken($newUser->name, [$newUser->role])->plainTextToken;
                $success['token_type'] = 'Bearer';
                $success['name'] = $newUser->name;
                Auth::login($newUser);

                return $this->sendResponse($success, 'Login by '.$provider.' Successfully.');
            }
        } catch (Exception $e) {
            return $this->sendError('Error', $e);
        }
    }
}
