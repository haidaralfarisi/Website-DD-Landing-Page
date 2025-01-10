<?php

namespace App\Http\Controllers\ADMIN;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BerandaAdminController extends Controller
{
    public function index()
    {
        // Anda bisa mengembalikan view yang sesuai untuk beranda admin
        return view('admin.beranda');
    }
}
