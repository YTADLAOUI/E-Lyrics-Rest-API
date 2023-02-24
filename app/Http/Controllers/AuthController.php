<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthController extends Controller
{
    // trait to generate Error and success message
    use GeneralTrait;

    // login
    public function login(Request $request)
    {
        // validation
        try {
            $rules = [

                'email' => 'required|email',
                'password' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->returnError('E004', 'email or password not Exist');
            }

            //login
            $email_password = $request->only(['email', 'password']);

            $token = JWTAuth::attempt($email_password);
            if (!$token)
                return $this->returnError('E001', 'email and password not correct');

            // generate Auth
            $user = JWTAuth::user();
            // $user->remember_token = $token;
            //return token jwt
            return $this->returnData('user', $user, 'success', $token);
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    // register
    public function register(Request $request)
    {


        // validation
        try {


            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {

                return $this->returnError('E003', 'Some inputs Not correct!');
            }


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // generate Auth

            $token = JWTAuth::fromUser($user);

            return $this->returnData('user', $user, 'register Successfully', $token);
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }
    // logout
    public function logout()
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return  $this->returnError('E404', 'user_not_found!');
            }
        } catch (TokenExpiredException $e) {

            return  $this->returnError('E404', 'token_expired!');
        } catch (TokenInvalidException $e) {

            return  $this->returnError('E404', 'token_invalid!');
        } catch (JWTException $e) {
            return  $this->returnError('E404', 'token_absent!');
        }

        Auth::logout();
        return $this->returnSuccessMessage("Logout has been success!", "S002");
    }
    // show profil
    public function profil()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {

                return  $this->returnError('E404', 'user_not_found!');
            }
        } catch (TokenExpiredException $e) {

            return  $this->returnError('E404', 'token_expired!');
        } catch (TokenInvalidException $e) {

            return  $this->returnError('E404', 'token_invalid!');
        } catch (JWTException $e) {
            return  $this->returnError('E404', 'token_absent!');
        }


        return $this->returnData('user-profil', $user, "success", "");
    }
}
