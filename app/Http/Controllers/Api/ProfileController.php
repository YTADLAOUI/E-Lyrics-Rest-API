<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GeneralTrait;
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
}
//         // $validator = Validator::make($request->all(), [
//         //     'old_password' => 'required',
//         //     'password' => 'required|string|min:6',
//         // ]);
//         // return $validator;
//         // if ($validator->fails()) {
//         // return response()->json([
//         //     'message' => 'validation fails',
//         //     'errors' => 'wq3'
//         // ], 422);
//         // }
//         // $user = $request->user();
//         // if (Hash::check($request->old_password, $user->password)) {
//         //     $user->update([
//                 $pas=> Hash::make($request->password)
//             // ]);
//             return response()->json([
//                 'message' => 'password succefully updated'
//             ], 200);
//         } else {
//             return response()->json([
//                 'message' => 'old password does not matche'
//             ], 400);
//         }
//     }
// }
