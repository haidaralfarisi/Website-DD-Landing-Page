<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Unit;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::with(['unit'])->paginate('10');
        
        $units = Unit::all();

        $facilitiesCount = Facility::count();  // Menghitung jumlah slider

        return view('superadmin.facility.index', compact('units', 'facilities', 'facilitiesCount'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Nama fasilitas wajib diisi
            'unit_id' => 'required|exists:units,id', // unit_id wajib ada dan valid
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Gambar opsional
        ]);

        // Upload file gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('facilities', 'public'); // Path gambar di folder storage
        } else {
            $imagePath = null;
        }

        // Simpan data ke database
        Facility::create([
            'name' => $validated['name'],
            'unit_id' => $validated['unit_id'], // Hubungkan dengan unit_id
            'image' => $imagePath, // Simpan path gambar atau null
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Facility successfully added.');
    }

    public function update(Request $request, $id)
    {
        // Cari data Facility berdasarkan ID
        $faciliteis = Facility::findOrFail($id);

        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Nama fasilitas wajib diisi
            'unit_id' => 'required|exists:units,id', // unit_id wajib ada dan valid
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar opsional
        ]);

        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('facilities', 'public');
        } else {
            $imagePath = $faciliteis->image;  // Gunakan gambar lama jika tidak ada yang baru
        }

        // Update data facility
        $faciliteis->update([
            'name' => $validated['name'],
            'unit_id' => $validated['unit_id'], // Pastikan unit_id ada
            'image' => $imagePath, // Simpan path gambar baru atau tetap gunakan yang lama
        ]);

        return redirect()->back()->with('success', 'Facilitas successfully updated.');
    }

    public function destroy($id)
     {
         // Cari data kategori berdasarkan ID
         $faciliteis = Facility::findOrFail($id);
 
         // Hapus data
         $faciliteis->delete();
 
         // Redirect dengan pesan sukses
         return redirect()->back()->with('success', 'Data Fasilitas berhasil dihapus.');
     }
}
