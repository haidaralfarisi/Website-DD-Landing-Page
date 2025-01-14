<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Post;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {

        $posts = Post::with(['user', 'category', 'unit'])->get();
        $users = User::all();  // Mengambil semua user untuk dropdown
        $categories = Categories::all();  // Mengambil semua kategori untuk dropdown
        $units = Unit::all();

        $postsCount = Post::count();  // Menghitung jumlah posts


        return view('admin.beranda', compact('posts', 'users', 'categories', 'units', 'postsCount'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'publish_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'unit_id' => 'nullable|exists:units,id', // Optional unit_id
            'user_id' => 'required|exists:users,id', // User ID wajib ada dan harus valid, sesuai dengan ID yang ada di tabel users
            'category_id' => 'required|exists:categories,id', // Category ID wajib ada dan harus valid, sesuai dengan ID yang ada di tabel categories
        ]);

        // Upload file meta_thumbnail
        if ($request->hasFile('meta_thumbnail')) {
            $metaThumbnailPath = $request->file('meta_thumbnail')->store('meta_thumbnails', 'public');
        } else {
            $metaThumbnailPath = null;
        }

        // Upload file image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = null;
        }

        // Simpan data ke database
        Post::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'meta_keyword' => $validated['meta_keyword'],
            'meta_description' => $validated['meta_description'],
            'meta_thumbnail' => $metaThumbnailPath,
            'image' => $imagePath,
            'description' => $validated['description'],
            'publish_date' => $validated['publish_date'],
            'status' => $validated['status'],
            'unit_id' => $validated['unit_id'], // Pastikan unit_id ada, jika tidak null
            'user_id' => $validated['user_id'],
            'category_id' => $validated['category_id'], // Menyimpan category_id
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Post berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'publish_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'unit_id' => 'required|exists:units,id', // pastikan unit_id valid
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Cari post yang akan diupdate
        $post = Post::findOrFail($id);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        if ($request->hasFile('meta_thumbnail')) {
            $metaThumbnailPath = $request->file('meta_thumbnail')->store('thumbnails', 'public');
        }

        // Update data post
        $post->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'meta_keyword' => $validated['meta_keyword'],
            'meta_description' => $validated['meta_description'],
            'meta_thumbnail' => isset($metaThumbnailPath) ? $metaThumbnailPath : $post->meta_thumbnail,
            'image' => isset($imagePath) ? $imagePath : $post->image,
            'description' => $validated['description'],
            'publish_date' => $validated['publish_date'],
            'status' => $validated['status'],
            'unit_id' => $validated['unit_id'],
            'user_id' => $validated['user_id'],
            'category_id' => $validated['category_id'],
        ]);

        // Redirect ke halaman daftar post setelah update
        return redirect()->back()->with('success', 'Post berhasil dihapus.');
    }


    // Function Menghapus Data Post
    public function destroy($id)
    {
        // Cari data Post berdasarkan ID
        $post = Post::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($post->image) {
            Storage::delete('public/' . $post->image);
        }

        // Hapus data
        $post->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Post berhasil dihapus.');
    }
}
