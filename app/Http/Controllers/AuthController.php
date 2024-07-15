<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);
        Auth::login($user);
        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Debug: Check if the user is authenticated after login
            if (Auth::check()) {
                // $token = JWTAuth::attempt($credentials);
                $user = Auth::user();
                $token = JWTAuth::fromUser($user);
                return response()->json(compact('token'));
            } else {
                return response()->json(['error' => 'User authenticate failed!'], 401);
            }
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            if (Auth::check()) {
                Auth::logout(); // For session-based logout
                return redirect('/?logout=true');
            } elseif (JWTAuth::parseToken()->authenticate()) {
                JWTAuth::invalidate(JWTAuth::getToken()); // For JWT authentication logout
                return response()->json(['message' => 'Successfully logged out']);            
            } else {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
        } catch (\Exception $e) {
            \Log::error('Logout exception: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken(JwtAuth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }
}
