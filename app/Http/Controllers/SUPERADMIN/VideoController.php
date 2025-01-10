<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view('superadmin.video.index', compact('videos'));
    }

    // public function create()
    // {
    //     return view('superadmin.unit.create');
    // }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',  // Unit bersifat optional
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi file image
            'status' => 'required|in:active,inactive',  // Status harus salah satu dari active atau inactive
            'url' => 'required|url',  // URL video harus valid
        ]);

        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            // Menyimpan gambar ke direktori 'public/images'
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = null;  // Jika tidak ada gambar, set null
        }

        // Persiapkan data untuk disimpan
        $data = [
            'title' => $validated['title'],
            'unit' => $validated['unit'],
            'image' => $imagePath,  // Menyimpan path gambar jika ada
            'status' => $validated['status'],
            'url' => $validated['url'],
        ];

        // Simpan data video ke database
        Video::create($data);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Video berhasil ditambahkan.');
    }


    // Menampilkan form untuk mengedit kategori
    // public function edit(Unit $unit)
    // {
    //     return view('superadmin.unit.edit', compact('unit'));
    // }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'url' => 'required|url',
        ]);

        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $video->image;  // Gunakan gambar lama jika tidak ada yang baru
        }

        // Update data video
        $video->update([
            'title' => $validated['title'],
            'unit' => $validated['unit'],
            'image' => $imagePath,
            'status' => $validated['status'],
            'url' => $validated['url'],
        ]);

        return redirect()->back()->with('success', 'Video berhasil diperbarui.');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        // Cari data kategori berdasarkan ID
        $videos = Video::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($videos->image) {
            Storage::delete('public/' . $videos->image);
        }

        // Hapus data
        $videos->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Video berhasil dihapus.');
    }
}
