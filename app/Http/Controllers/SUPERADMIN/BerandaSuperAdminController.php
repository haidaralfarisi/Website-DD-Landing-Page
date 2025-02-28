<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Categories;
use App\Models\Facility;
use App\Models\Post;
use App\Models\PostCategories;
use App\Models\Slider;
use App\Models\Unit;
use App\Models\User; // Import model User
use App\Models\Video;
use Illuminate\Http\Request;

class BerandaSuperAdminController extends Controller
{
    public function index()
    {
        // Ambil semua data users
        $users = User::all();

        // Hitung jumlah data users
        $usersCount = User::count();

        // Hitung jumlah data categories
        $postcategoriesCount = PostCategories::count();

        $unitsCount = Unit::count();

        // Hitung jumlah data categories
        $postsCount = Post::count();

        // Hitung jumlah data categories
        $slidersCount = Slider::count();

        // Hitung jumlah data categories
        $videosCount = Video::count();

        $achievementsCount = Achievement::count();

        $facilitiesCount = Facility::count();



        // Kirim data ke view
        return view('superadmin.beranda', compact(
            'users',
            'usersCount',
            'unitsCount',
            'postcategoriesCount',
            'postsCount',
            'slidersCount',
            'videosCount',
            'achievementsCount',
            'facilitiesCount',
        ));
    }
}
