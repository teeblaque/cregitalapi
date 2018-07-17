<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['email'] = $user->email;
            $success['status'] = $this->successStatus;
            return response()->json([ 'success' => $success ], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

//    public function logoutApi()
//    {
//        if (Auth::check())
//        {
//            Auth::user()->AauthAccessToken()->delete();
//        }
//    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        $json = [
            'success' => true,
            'code' => 200,
            'message' => 'You are Logged out',
        ];
        return response()->json($json, '200');
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
