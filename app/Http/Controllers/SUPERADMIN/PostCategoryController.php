<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\PostCategories;
use App\Models\Unit;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    // Menampilkan Data Categori
    public function index()
    {

        $postcategories = PostCategories::with(['units'])->paginate('10');

        $units = Unit::all();

        $postcategoriesCount = PostCategories::count();  // Menghitung jumlah slider


        return view('superadmin.postcategory.index', compact('units', 'postcategories', 'postcategoriesCount'));
    }

    // Menyimpan Data kategori baru
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        // Persiapkan data untuk disimpan
        $data = [
            'name' => $validated['name'],
            'unit_id' => $validated['unit_id'], // Pastikan unit_id ada, jika tidak null
        ];

        // Simpan data ke database
        PostCategories::create($data);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Post Category berhasil ditambahkan.');
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id', // pastikan unit_id valid
        ]);

        $postcategories = PostCategories::findOrFail($id);

        $postcategories->update($validated);

        // $postcategories->update($data);
        // $postcategories->update($request->all());
        
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Post Category berhasil diubah.');
    }

    // Menghapus Data kategori
    public function destroy($id)
    {
        // Cari data kategori berdasarkan ID
        $postcategories = PostCategories::findOrFail($id);

        // Hapus data
        $postcategories->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Post Category berhasil dihapus.');
    }
}
