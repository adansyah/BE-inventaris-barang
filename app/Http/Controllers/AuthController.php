<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Validasi kredensial
            $credentials = $request->only('email', 'password');

            if (!Auth::guard('web')->attempt($credentials)) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'data'    => null,
                ], 401);
            }

            // Ambil user setelah login
            $user = Auth::user();

            // Generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login Berhasil',
                'data'    => [
                    'token' => $token,
                    'user'  => new UserResource($user),
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password =  Hash::make($data['password']);
            $user->role = $data['role'];
            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            return response()->json([
                'message' => 'Registrasi Berhasil',
                'data' => [
                    'token' => $token,
                    'user' => new UserResource($user)
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function profile()
    {
        try {
            $user = Auth::User();

            return response()->json([
                'message' => 'Profile User Berhasil Diambil',
                'data' => new UserResource($user)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            $user = Auth::User();
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout berhasil',
                'data' => null
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
