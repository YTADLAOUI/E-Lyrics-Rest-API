<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // trait to generate Error and success message
    use GeneralTrait;

    // login
    public function login(Request $request){


        // validation
        try{
        $rules=[

            'email'=>'required',
            'password'=>'required'
        ];
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }

   //login
   $credentiel= $request->only(['email','password']);

   $token = Auth::attempt($credentiel);
        if(!$token)
            return $this->returnError('E001','email and password not correct');

     //get admin with token
     $user = Auth::user();
     $user->remember_token=$token;
//return token jwt
      return $this->returnData('user',$user,'succes');

    }catch(Exception $e){
        return $this->returnError($e->getCode(),$e->getMessage());
    }


    }

    // register
    public function register(Request $request)
    {

            // validation
     try{
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


      return $this->returnData('user',$user,'register Successfully');


    }
    catch(Exception $e){
        return $this->returnError($e->getCode(),$e->getMessage());
    }



}
}
