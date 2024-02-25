<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'sucess' => false,
            //     'message' => 'The provided credentials are incorrect.',
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
            return response()->json([
                'error' => true,
                'message' => 'Kredensial yang diberikan salah',
            ], 400);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'error' => false,
            'message' => 'User Berhasil Login',
            'loginResult' => [
                'userId' => strval($user->id),
                'token' => $token,
                'name' => $user->name,
            ],
            // 'tokenType' => 'Bearer'
        ]);
    }

    public function getCurrentUser(Request $request)
    {
        return $request->user();
    }

    public function logout()
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        $user->tokens()->delete();
        return response()->json([
            'error' => false,
            'message' => 'logout success'
        ]);
    }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|max:255|unique:users',
    //         'password' => 'required|string|min:8'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors());
    //     }

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password)
    //     ]);

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'data' => $user,
    //         'access_token' => $token,
    //         'token_type' => 'Bearer'
    //     ]);
    // }
}
