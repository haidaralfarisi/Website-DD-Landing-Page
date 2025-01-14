<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Unit;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan Data Categori
    public function index()
    {
        // $categories = Categories::all();

        $categories = Categories::with(['unit'])->paginate('10');
        $units = Unit::all();

        $categoriesCount = Categories::count();  // Menghitung jumlah slider


        return view('superadmin.category.index', compact('units', 'categories', 'categoriesCount'));
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
        Categories::create($data);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Category berhasil ditambahkan.');
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id', // pastikan unit_id valid
        ]);

        $category = Categories::findOrFail($id);

        $data = [
            'name' => $validated['name'],
            'unit_id' => $validated['unit_id'],
        ];

        $category->update($data);
        $category->update($request->all());
        
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Category berhasil diubah.');
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
