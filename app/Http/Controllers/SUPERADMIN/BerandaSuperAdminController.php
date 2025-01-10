<?php

namespace App\Http\Controllers\SUPERADMIN;
use App\Http\Controllers\Controller;
use App\Models\User; // Import model User


use Illuminate\Http\Request;

class BerandaSuperAdminController extends Controller
{
    public function index()
    {
        // Anda bisa mengembalikan view yang sesuai untuk beranda superadmin
        $users = User::all();

        // Kirim data ke view
        return view('superadmin.beranda', compact('users'));
    }
}
