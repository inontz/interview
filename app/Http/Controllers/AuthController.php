<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            $success['access_token'] =  $authUser->createToken(env('SECRET_KEY'), ['products:viewer'])->plainTextToken;
            $success['token_type'] =  'Bearer';
            $success['name'] =  $authUser->name;

            return $this->sendResponse($success, 'User signed in');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['access_token'] =  $user->createToken(env('SECRET_KEY'), ['products:viewer'])->plainTextToken;
        $success['token_type'] =  'Bearer';
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User created successfully.');
    }

}
