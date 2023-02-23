<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    use GeneralTrait;


    public function change_password(Request $request)
    {

        $email = $request->email;
        $user = User::where('email', $email)->first();
        dd($user);
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


        $user = User::find($id);



        if (!$user) {
            return $this->returnError('E001', 'User not found.');
        } else {
            $user->name = $request->name;
            $user->password =  Hash::make($request->password);
            $user->email = $request->email;
            $user->save();
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:5',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'status' => 200,
            ];
            return response()->json($data)->returnSuccessMessage('reset password succefuly ');
        }
    }
}
