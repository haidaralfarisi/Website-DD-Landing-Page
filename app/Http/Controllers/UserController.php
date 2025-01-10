<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        // Ambil semua data pengguna dari tabel users
        $users = User::all();

        // Kirim data pengguna ke view superadmin.user.index
        return view('superadmin.user.index', compact('users'));
    }

       public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nip' => 'required|string|max:20',
            'name_label' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'level' => 'required|in:superadmin,admin',
            'unit' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Persiapkan data untuk disimpan
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'name_label' => $validated['name_label'],
            'level' => $validated['level'],
            'unit' => $validated['unit'],
            'password' => bcrypt($validated['password']),
        ];

        // Cek jika ada avatar yang diupload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath; // Menyimpan path avatar di database
        }

        // Simpan data ke database
        User::create($data);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }



    // Function Untuk Menghapus Data User
    public function destroy($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus user
        $user->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    // Function Untuk Mengedit Data User
    public function edit($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);
        // return response()->json($user); // Kirimkan data user sebagai response JSON


        // Pass data ke view
        return view('admin.users.edit', compact('user'));
    }

    // Function Untuk Mengupdate Data User
    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'nip' => 'required|string|max:20',
            'name_label' => 'nullable|string|max:255',
            'level' => 'required|in:superadmin,admin',
            'unit' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',  // Pastikan konfirmasi password
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Validasi untuk avatar
        ]);

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Persiapkan data untuk update
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'name_label' => $validated['name_label'],
            'level' => $validated['level'],
            'unit' => $validated['unit'],
        ];

        // Update password jika ada
        if ($validated['password']) {
            $data['password'] = bcrypt($validated['password']);
        }

        // Cek jika ada avatar yang diupload
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar)); // Menghapus avatar lama
            }

            // Simpan avatar baru
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath; // Menyimpan path avatar yang baru
        }

        // Update data user
        $user->update($data);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'User berhasil diubah.');
    }
}
