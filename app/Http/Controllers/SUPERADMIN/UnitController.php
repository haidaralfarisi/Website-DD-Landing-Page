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
        $units = Unit::paginate(10);

        $unitsCount = Unit::count();  // Menghitung jumlah slider

        return view('superadmin.unit.index', compact('units', 'unitsCount'));
    }

    // Menyimpan Data Kategori Baru
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_unit' => 'required|string|max:255',
        ]);

        // Persiapkan data untuk disimpan
        $data = [
            'nama_unit' => $validated['nama_unit'],
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
            'nama_unit' => 'required|string|max:255',
        ]);

        $unit = Unit::findOrFail($id);

        $data = [
            'nama_unit' => $validated['nama_unit'],
        ];

        $unit->update($data);

        $unit->update($request->all());

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Unit berhasil diubah.');
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
