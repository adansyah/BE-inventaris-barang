<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $search = $request->query('search');

        $users = User::query();

        if ($search) {
            $users->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('role', 'LIKE', '%' . $search . '%');
        }

        $users = $users->latest()->get();

        if ($users->isNotEmpty()) {
            return response()->json([
                'message' => 'Data User Berhasil Diambil',
                'data' => UserResource::collection($users)
            ], 200);
        }

        return response()->json([
            'message' => 'User Tidak Ditemukan',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:kelurahan,admin',
        ]);

        // 2. Simpan User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // Wajib hash password sebelum disimpan
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // 3. Respon Sukses (201 Created)
        return response()->json([
            'message' => 'Pengguna berhasil ditambahkan',
            // Hanya kirim kembali data yang aman (tanpa password)
            'data' => $user->only(['id', 'name', 'email', 'role'])
        ], 201);
    }

    public function show($id)
    {

        $user = User::findOrFail($id);
        // READ: Detail user
        return response()->json([
            'message' => 'Detail pengguna berhasil diambil',
            'data' => $user
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            // Email harus unik, tapi boleh sama dengan email user saat ini
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            // Password tidak wajib diisi, tapi jika diisi harus minimal 6 karakter
            'password' => 'nullable|string|min:6',
            'role' => 'sometimes|required|string|in:kelurahan,admin',
        ]);

        // 2. Persiapkan Data Update
        $data = [
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
            'role' => $validated['role'] ?? $user->role,
        ];

        // Hanya hash dan tambahkan password jika ada
        if (isset($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        // 3. Perbarui Database
        $user->update($data);

        // 4. Respon Sukses
        return response()->json([
            'message' => 'Pengguna berhasil diperbarui',
            'data' => $user->only(['id', 'name', 'email', 'role'])
        ], 200);
    }

    public function destroy($id)
    {
        // 1. Hapus dari Database
        $user = User::findOrFail($id);
        $user->delete();

        // 2. Respon Sukses (204 No Content)
        return response()->json([
            'message' => 'Pengguna berhasil dihapus'
        ], 204);
    }
}
