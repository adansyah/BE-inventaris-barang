<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function user()
    {
        $user = User::all();

        if ($user) {
            return response()->json([
                'message' => 'User Berhasil Diambil',
                'data' => UserResource::collection($user)
            ], 200);
        }

        return response()->json([
            'message' => 'User Tidak Ditemukan',
            'data' => null
        ], 404);
    }
}
