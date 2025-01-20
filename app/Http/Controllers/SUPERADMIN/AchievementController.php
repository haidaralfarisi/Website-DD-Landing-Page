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
        $achievements = Achievement::with(['unit'])->paginate('10');
        $units = Unit::all();

        $achievementsCount = Achievement::count();  // Menghitung jumlah slider


        return view('superadmin.achievement.index', compact('units', 'achievements', 'achievementsCount'));

        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'desc' => 'nullable|string', // Validasi untuk kolom longtext
            'status' => 'required|in:Active,Inactive',
            'achievement_date' => 'required|date', // Pastikan tanggal pencapaian valid
        ]);

        // Upload file image jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('achievements', 'public');
        } else {
            $imagePath = null;
        }

        // Simpan data ke database
        Achievement::create([
            'title' => $validated['title'],
            'unit_id' => $validated['unit_id'], // Pastikan unit_id ada, jika tidak null
            'image' => $imagePath,
            'desc' => $validated['desc'],
            'status' => $validated['status'],
            'achievement_date' => $validated['achievement_date'], // Simpan tanggal pencapaian
        ]);

        return redirect()->back()->with('success', 'Slider berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $achievements = Achievement::findOrFail($id);

        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'desc' => 'nullable|string', // Validasi untuk kolom longtext
            'status' => 'required|in:Active,Inactive',
            'achievement_date' => 'nullable|date',

        ]);

        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $achievements->image;  // Gunakan gambar lama jika tidak ada yang baru
        }

        // Update data video
        $achievements->update([
            'title' => $validated['title'],
            'unit_id' => $validated['unit_id'], // Pastikan unit_id ada, jika tidak null
            'image' => $imagePath,
            'desc' => $validated['desc'],
            'status' => $validated['status'],
            'achievement_date' => $validated['achievement_date'], // Simpan tanggal pencapaian
        ]);

        return redirect()->back()->with('success', 'Achievement berhasil diperbarui.');
    }

     // Menghapus Data kategori
     public function destroy($id)
     {
         // Cari data kategori berdasarkan ID
         $achievements = Achievement::findOrFail($id);
 
         // Hapus data
         $achievements->delete();
 
         // Redirect dengan pesan sukses
         return redirect()->back()->with('success', 'Data Achievement berhasil dihapus.');
     }
}
