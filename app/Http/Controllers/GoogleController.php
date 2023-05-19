<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                $authUser = Auth::login($finduser);
                dd($authUser);
                $success['access_token'] = $authUser->createToken($authUser->name, [$authUser->role])->plainTextToken;
                $success['token_type'] = 'Bearer';
                $success['name'] = $authUser->name;
                return $this->sendResponse($success, 'Signed up and signed in');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'role' => 'viewer',
                    'password' => encrypt('Password!'),
                ]);
            $success['access_token'] = $newUser->createToken($newUser->name, [$newUser->role])->plainTextToken;
            $success['token_type'] = 'Bearer';
            $success['name'] = $newUser->name;
            Auth::login($newUser);
            return $this->sendResponse($success, 'Signed up and signed in');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
