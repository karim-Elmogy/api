<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterfaces;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthRepository implements AuthInterfaces
{
    use ApiResponseTrait;

    public function register($request)
    {
        $validation=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|min:6'
        ]);

        if($validation->fails())
        {
            return $this->apiResponse(400,'Not Found',$validation->fails());
        }

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        return $this->apiResponse(200,'Account Was Created');
    }



    public function login($request)
    {
        $validation=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required|min:6'
        ]);

        if($validation->fails())
        {
            return $this->apiResponse(400,'Not Found',$validation->fails());
        }


        $userData = $request->only('email','password');

        if($token=Auth::attempt($userData))
        {
            return $this->respondWithToken($token);
        }

        return $this->apiResponse(400,'Not Found');

    }






    protected function respondWithToken($token)
    {
        $array = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];

        return $this->apiResponse(200,'login',null,$array);
    }


}
