<?php


namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Unit;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::with(['unit'])->get();
        $units = Unit::all();

        return view('superadmin.achievements.index', compact('units'));
    }
}
