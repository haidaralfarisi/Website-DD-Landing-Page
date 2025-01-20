<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Post;
use App\Models\PostCategories;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {

        $posts = Post::with(['user', 'postcategory', 'unit'])->where('unit_id', Auth::user()->unit_id)
            ->latest()
            ->get();

        $users = User::all();  // Mengambil semua user untuk dropdown
        $postcategories = PostCategories::all();  // Mengambil semua kategori untuk dropdown
        $units = Unit::all();
        $postsCount = Post::count();  // Menghitung jumlah posts


        return view('admin.beranda', compact('posts', 'users', 'units', 'postsCount', 'postcategories'));
    }

    public function create()
    {

        $units = Unit::all();
        $users = User::all();
        $postcategories = PostCategories::all();

        return view('admin.create', compact('users', 'postcategories', 'units'));
    }

    public function edit(Post $post)
    {
        $units = Unit::all();
        $users = User::all();
        $postcategories = PostCategories::all();

        return view('admin.edit', compact('post', 'units', 'users', 'postcategories'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'string|max:255|unique:posts,slug',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'desc' => 'nullable|string',
            'publish_date' => 'nullable|date',
            // 'status' => 'required|in:active,inactive',
            // 'unit_id' => 'nullable|exists:units,id', 
            'post_category_id' => 'required|exists:post_categories,id', // Post Category ID wajib ada dan harus valid sesuai dengan tabel post_categories
            'desc' => 'nullable|string',  // Tambahkan validasi untuk desc

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
            'slug' => Str::slug($request->title),
            'meta_keyword' => $validated['meta_keyword'],
            'meta_description' => $validated['meta_description'],
            'meta_thumbnail' => $metaThumbnailPath,
            'image' => $imagePath,
            // 'desc' => $validated['desc'],
            'publish_date' => $validated['publish_date'],
            'status' => 'Inactive',
            'unit_id' => Auth::user()->unit_id,
            'user_id' => Auth::user()->id,
            'post_category_id' => $validated['post_category_id'], // Menyimpan post_category_id
            'desc' => $validated['desc'], // Menyimpan konten HTML dari Summernote
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Post berhasil ditambahkan.');
    }

    public function uploadImage(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Simpan gambar di storage/public dan dapatkan URL-nya
        $imagePath = $request->file('image')->store('content_artikel', 'public');

        // Mengirimkan URL gambar yang baru diupload
        return response()->json(['url' => Storage::url($imagePath)]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'string|max:255|unique:posts,slug',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'desc' => 'nullable|string',
            'publish_date' => 'nullable|date',
            // 'status' => 'required|in:active,inactive',
            // 'unit_id' => 'nullable|exists:units,id', 
            'post_category_id' => 'required|exists:post_categories,id', // Post Category ID wajib ada dan harus valid sesuai dengan tabel post_categories
            'desc' => 'nullable|string',  // Tambahkan validasi untuk desc

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
            'slug' => Str::slug($request->title),
            'meta_keyword' => $validated['meta_keyword'],
            'meta_description' => $validated['meta_description'],
            'meta_thumbnail' => $metaThumbnailPath,
            'image' => $imagePath,
            // 'desc' => $validated['desc'],
            'publish_date' => $validated['publish_date'],
            'status' => 'Inactive',
            'unit_id' => Auth::user()->unit_id,
            'user_id' => Auth::user()->id,
            'post_category_id' => $validated['post_category_id'], // Menyimpan post_category_id
            'desc' => $validated['desc'], // Menyimpan konten HTML dari Summernote

        ]);

        // Redirect ke halaman daftar post setelah update
        return view('admin.beranda')->with('success', 'Post berhasil diupdate.');
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
