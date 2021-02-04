<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);



        if (User::where('email', $request->email)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Пользователь уже существут'
            ]);
        };

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'user_name' => $request->name,
            'token' => $token,
            'message' => 'User was registered successfully'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
        {
            return response()->json([
                'status' => false,
                'message' => 'Введены неправильные данные'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'user_name' => $user->name,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Token was deleted successfully',
        ]);
    }
}
