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
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // trait to generate Error and success message
    use GeneralTrait;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
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

    // generate Auth

     $user = Auth::user();
     $user->remember_token=$token;
//return token jwt
    return $this->returnData('user',$user,'succes',$token);

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

        // generate Auth

        $token = Auth::login($user);
        
      return $this->returnData('user',$user,'register Successfully',$token);


    }
    catch(Exception $e){
        return $this->returnError($e->getCode(),$e->getMessage());
    }
}
// logout
public function logout()
    {

            Auth::logout();
            return $this->returnSuccessMessage("Logout has been success!","S002");

}


}
