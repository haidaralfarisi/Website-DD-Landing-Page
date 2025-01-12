<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    // Menampilkan Data Dari Post
    public function index()
    {
        $posts = Post::all();
        return view('superadmin.post.index', compact('posts'));
    }

    // Function Menyimpan Data Post
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'publish_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'unit' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
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
            'unit' => $validated['unit'],
            'user_id' => $validated['user_id'],
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Post berhasil ditambahkan.');
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
