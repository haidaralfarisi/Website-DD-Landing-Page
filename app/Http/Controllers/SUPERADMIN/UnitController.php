<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // Menampilkan Data Dari Unit
    public function index()
    {
        $units = Unit::all();
        return view('superadmin.unit.index', compact('units'));
    }

    // Menyimpan Data Kategori Baru
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

    // Function Edit Data Unit
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

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'unit berhasil diubah.');
    }

    // Menghapus Data Unit
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
