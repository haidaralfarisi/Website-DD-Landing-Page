<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return view('superadmin.unit.index', compact('units'));
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
            'name' => 'required|string|max:255',
        ]);

        // Persiapkan data untuk disimpan
        $data = [
            'name' => $validated['name'],
        ];

        // Simpan data ke database
        Unit::create($data);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Unit berhasil ditambahkan.');
    }


    // Menampilkan form untuk mengedit kategori
    // public function edit(Unit $unit)
    // {
    //     return view('superadmin.unit.edit', compact('unit'));
    // }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $unit = Unit::findOrFail($id);

        $data = [
            'name' => $validated['name'],
        ];

        $unit->update($data);


        $unit->update($request->all());
        return redirect()->back()->with('success', 'unit berhasil diubah.');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        // Cari data kategori berdasarkan ID
        $unit = Unit::findOrFail($id);

        // Hapus data
        $unit->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Unit berhasil dihapus.');
    }
}
