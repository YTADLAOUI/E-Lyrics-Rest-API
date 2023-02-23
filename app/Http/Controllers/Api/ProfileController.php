<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Validators\Validator;


class ProfileController extends Controller
{
    use GeneralTrait;
    //
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function change_password(Request $request)
    {

        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return $this->returnError('E404', 'user not found');
        } else {
            $user->password = bcrypt($request->newPassword);
            $user->save();
            return $this->returnSuccessMessage('reset password succefuly ');
        }
    }


    public function profile_edit($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|min:5',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ],
            [
                'name.required' => 'the fill of the name it must be done',
                'email.required' => 'the fill of the name it must be done',
                'password.required' => ' fill password required',
                'name.min' => 'the character must be over 5'
            ]
        );

        $user = User::find($id);




        if (!$user) {
            return $this->returnError('E001', 'User not found.');
        } else {
            $user->name = $request->name;
            $user->password = $request->password;
            $user->email = $request->email;
            $user->save();

            $data = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'status' => 200,
            ];
            return $this->returnData('name', $data, 'success', ' ');
        }
    }
}
