<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
   
    public function userRegister(Request $requests){
       $data=$requests->all();
       $validation = Validator::make($data, [
             'first_name' => 'required | string | max:255',
             'username' => 'required | string | max:255 | unique:users',
             'email' => 'required | email | max:255 | unique:users',
             'password' => 'required | string | min:6 | max:50',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],422);
        }
        try {
            $user = new User();
            $user->first_name=$data['first_name'];
            $user->last_name=$data['last_name'];
            $user->username=$data['username'];
            $user->email=$data['email'];
            $user->phone=$data['phone'];
            $user->password=Hash::make($data['password']);
            $user->save();

         return response()->json(['message'=>'Registration Successfully','data'=>$user,'mode'=>'success'], 200);

       
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
        
       
    }

   
    public function userLogin(Request $requests){
        $data=$requests->all();
            $validation = Validator::make($data, [
                'email' => 'required',
                'password' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],422);
        }
        try {
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                $user = Auth::user();

                $token = $user->createToken('My App')->accessToken;

                return response()->json(['token'=>$token], 200);
            }
        } catch (\Throwable $th) {
            return response()->json($th);
        }
         
    }

    public function getUserProfile(){
        $user = Auth::guard('api')->user();

        return response()->json(['data'=>$user], 200);
    }

    public function userLogout(){
        $user = Auth::guard('api')->user();

        return response()->json(['data'=>$user], 200);
    }

   
}
