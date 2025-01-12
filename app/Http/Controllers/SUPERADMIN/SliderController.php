<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{

    // Menampilkan Data Dari Slider
    public function index()
    {
        $sliders = Slider::all();
        return view('superadmin.slider.index', compact('sliders'));
    }
    // Function Menyimpan Data Slider
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Upload file image jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sliders', 'public');
        } else {
            $imagePath = null;
        }

        // Simpan data ke database
        Slider::create([
            'title' => $validated['title'],
            'unit' => $validated['unit'],
            'image' => $imagePath,
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Slider berhasil ditambahkan.');
    }

    // Function Edit Data Slider
    public function update(Request $request, $id)
    {
        $sliders = Slider::findOrFail($id);

        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $sliders->image;  // Gunakan gambar lama jika tidak ada yang baru
        }

        // Update data video
        $sliders->update([
            'title' => $validated['title'],
            'unit' => $validated['unit'],
            'image' => $imagePath,
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Slider berhasil diperbarui.');
    }

    // Function Delete Data Slider
    public function destroy($id)
    {
        // Cari data kategori berdasarkan ID
        $sliders = Slider::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($sliders->image) {
            Storage::delete('public/' . $sliders->image);
        }

        // Hapus data
        $sliders->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Sliders berhasil dihapus.');
    }
}
