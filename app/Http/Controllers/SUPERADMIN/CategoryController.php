<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan Data Categori
    public function index()
    {
        $categories = Categories::all();
        return view('superadmin.category.index', compact('categories'));
    }

    // Menyimpan Data kategori baru
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string',
        ]);

        // Persiapkan data untuk disimpan
        $data = [
            'name' => $validated['name'],
            'unit' => $validated['unit'] ?? null, // Default ke null jika tidak diisi
        ];

        // Simpan data ke database
        Categories::create($data);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Category berhasil ditambahkan.');
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string',
        ]);

        $category = Categories::findOrFail($id);

        $data = [
            'name' => $validated['name'],
            'unit' => $validated['unit'],
        ];

        $category->update($data);
        $category->update($request->all());
        
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'User berhasil diubah.');
    }

    // Menghapus Data kategori
    public function destroy($id)
    {
        // Cari data kategori berdasarkan ID
        $category = Categories::findOrFail($id);

        // Hapus data
        $category->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Category berhasil dihapus.');
    }
}
