<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'mother_full_name' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:Student,Admin,Instructor',
            'status' => 'required|in:Pending,Approved,Rejected',
            'date_of_birth' => 'required|date',
            'nationality' => 'nullable|string|max:50',
            'second_nationality' => 'nullable|string|max:50',
            'country_of_birth' => 'nullable|string|max:50',
            'gender' => 'required|in:Male,Female',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'profile_picture' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'mother_full_name' => $request->mother_full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $request->status,
            'date_of_birth' => $request->date_of_birth,
            'nationality' => $request->nationality,
            'second_nationality' => $request->second_nationality,
            'country_of_birth' => $request->country_of_birth,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'profile_picture' => $request->profile_picture,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
