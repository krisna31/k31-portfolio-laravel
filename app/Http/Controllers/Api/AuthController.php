<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
                'success' => false,
                'message' => 'Kredensial yang diberikan salah',
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User Berhasil Login',
            'token' => $token,
            'tokenType' => 'Bearer'
        ]);
    }

    public function getCurrentUser() {
        return $request->user();
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
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
