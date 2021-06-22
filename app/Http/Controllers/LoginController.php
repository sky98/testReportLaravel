<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        $user = User::where('nit', $request->nit)->first();
        if(empty($user)){
            return response()->json([
                'status'        => 'error',
                'response_code' =>  404,
                'data'          =>  null,
                'message'       =>  'The given data was invalid.',
            ]);
        }
        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                'status'        => 'error',
                'response_code' =>  400,
                'data'          =>  null,
                'message'       =>  'The provided credentials are incorrect.',
            ]);
        }
        $response = [
            'nit'   =>  $user->nit,
            'token' =>  $user->createToken($request->device_name)->plainTextToken,
        ];   
        return response()->json([
            'status'        => 'success',
            'response_code' =>  200,
            'data'          =>  $response,
            'message'       =>  null,
        ]);
    }
    
}
