<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Slider;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{

    // Menampilkan Data Dari Slider
    public function index()
    {
        // $sliders = Slider::all();

        $sliders = Slider::with(['unit'])
        ->latest()
        ->get();
        $units = Unit::all();

        $slidersCount = Slider::count();  // Menghitung jumlah posts

        return view('superadmin.slider.index', compact('units', 'sliders', 'slidersCount'));
    }
    // Function Menyimpan Data Slider
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'unit_id' => 'required|exists:units,id', // Unit ID wajib ada dan valid
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'status' => 'required|in:Active,Inactive', // Status wajib 'Active' atau 'Inactive'
        ]);

        // Handle upload file image
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Ambil data unit untuk digunakan dalam nama file

            // Buat nama file: unit_<hash>.extensi
            $file = $request->file('image');
            $imageName = 'slider_' . md5(file_get_contents($file)) . '.' . $file->getClientOriginalExtension();

            // Simpan file ke direktori storage
            $file->storeAs('public/sliders', $imageName);

            // Simpan nama file untuk disimpan di database
            $imagePath = $imageName;
        }

        // Simpan data ke database
        Slider::create([
            'title' => $validated['title'], // Nullable title
            'unit_id' => $validated['unit_id'], // Unit ID dari dropdown
            'image' => $imagePath, // Path gambar yang disimpan
            'status' => $validated['status'], // Status Active/Inactive
        ]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Slider berhasil ditambahkan.');
    }


    // Function Edit Data Slider
    public function update(Request $request, $id)
    {
        $sliders = Slider::findOrFail($id);

        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        // Menyimpan gambar jika ada
        $imageName = $sliders->image; // Gunakan nama file lama
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada di storage
            if ($sliders->image && Storage::exists('public/sliders/' . $sliders->image)) {
                Storage::delete('public/sliders/' . $sliders->image); // Hapus file lama
            }
    
            // Format nama file baru menggunakan MD5
            $file = $request->file('image');
            $imageName = 'slider_' . md5(file_get_contents($file)) . '.' . $file->getClientOriginalExtension();
    
            // Simpan file ke storage
            $file->storeAs('public/sliders', $imageName);
        }

        // Update data video
        $sliders->update([
            'title' => $validated['title'],
            'unit_id' => $validated['unit_id'], // Pastikan unit_id ada, jika tidak null
            'image' => $imageName,
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Slider berhasil diperbarui.');
    }

    // Function Delete Data Slider
    public function destroy($id)
    {
        // Cari data kategori berdasarkan ID
        $sliders = Slider::findOrFail($id);

         // Hapus file image jika ada
         if ($sliders->image && Storage::exists('public/sliders/' . $sliders->image)) {
            Storage::delete('public/sliders/' . $sliders->image);
        }

        // Hapus data
        $sliders->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Sliders berhasil dihapus.');
    }
}
