<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::guard()->attempt($request->only('email', 'password'))) {

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'data'      => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'created_at' => $user->created_at->diffForHumans(),
                    'updated_at' => $user->updated_at->diffForHumans()
                ],
                'token' => $token,
                'message'   => 'Success'
            ], 200);
        }

        return response()->json([
            'errors'  => 'Incorrect login details',
            'message' => 'Unauthorized'
        ], 403);
    }
}
