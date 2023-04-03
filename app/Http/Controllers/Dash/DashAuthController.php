<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashAuthController extends Controller
{
    public function adminRegister(Request $request)
    {
        $re = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => 'required|same:password',
        ]);
        if ($re->fails()) {
            $error = $re->errors();

            return response()->json($error, 401);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['message' => 'This email is taken by another account'], 200);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => 2
            ]);

            $token = $user->createToken('APPLICATION')->accessToken;
            return response()->json(['token' => $token, 'message' => 'success', 'data' => $user], 200);
        }
    }

    public function adminLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'type' => 2
        ];
        if (auth::attempt($credentials)) {

            $token = auth::user()->createToken('APPLICATION')->accessToken;
            $data = auth::user();
            return response()->json(['token' => $token, 'message' => 'you are login now', 'data' => $data], 200);

        } else {
            return response()->json(['message' => 'Password or Email  incorrect', 'data' => null], 200);

        }
    }

    public function adminUpdate(Request $request, $id)
    {
        $user = Auth::user();
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['message' => 'success', 'data' => $user], 200);
    }

    public function testAuth(){
        return Auth::user();
    }
}
