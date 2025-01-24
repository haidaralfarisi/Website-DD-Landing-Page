<?php

namespace App\Http\Controllers\SUPERADMIN;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\PostCategories;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;

class PostController extends Controller
{
    // Menampilkan Data Dari Post
    public function index()
    {
        $posts = Post::with(['user', 'postcategory', 'unit'])
            ->latest()
            ->get();
        $users = User::all();  // Mengambil semua user untuk dropdown
        $postcategories = PostCategories::all();  // Mengambil semua kategori untuk dropdown
        $units = Unit::all();

        return view('superadmin.post.index', compact('posts', 'users', 'units', 'postcategories'));
    }

    public function create()
    {

        $units = Unit::all();
        $users = User::all();
        $postcategories = PostCategories::all();

        return view('superadmin.post.create', compact('users', 'postcategories', 'units'));
    }


    // Function Menyimpan Data Post
    // Function Menyimpan Data Post
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'string|max:255|unique:posts,slug',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            // 'meta_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'desc' => 'nullable|string',
            'publish_date' => 'nullable|date',
            // 'status' => 'required|in:active,inactive',
            'unit_id' => 'nullable|exists:units,id',
            'post_category_id' => 'required|exists:post_categories,id', // Post Category ID wajib ada dan harus valid sesuai dengan tabel post_categories
            'desc' => 'nullable|string',  // Tambahkan validasi untuk desc

        ]);


        //Menyimpan gambar untuk field meta_thumnail dan image
        $metaImage = null;
        $postImage = null;
        if ($request->hasFile('image')) {
            $unit  = Unit::where('id', $request->unit_id)->first();
            $metaImage = 'meta_' . md5($request->image) . '.' . $request->image->extension();
            // Untuk kompres dan simpan image
            Image::read($request->file('image'))->resize(null, null, function($constraint){
                $constraint->aspectRatio();
            })->save("storage/post_meta_thumbnail/".$metaImage);

            $postImage = $unit->nama_unit . '_' . md5($request->image) . '.' . $request->image->extension();
            $request->file('image')->storeAs('public/post_images', $postImage);
        }

        // Simpan data ke database
        Post::create([
            'title' => $validated['title'],
            'slug' => Str::slug($request->title),
            'meta_keyword' => $validated['meta_keyword'],
            'meta_description' => $validated['meta_description'],
            'meta_thumbnail' => $metaImage,
            'image' => $postImage,
            // 'desc' => $validated['desc'],
            'publish_date' => $validated['publish_date'],
            'status' => 'Inactive',
            'unit_id' => Auth::user()->unit_id,
            'user_id' => Auth::user()->id,
            'post_category_id' => $validated['post_category_id'], // Menyimpan post_category_id
            'desc' => $validated['desc'], // Menyimpan konten HTML dari Summernote

        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('superadmin.posts.index')->with('success', 'Post berhasil ditambahkan.');
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

    public function edit(Post $post)
    {
        $units = Unit::all();
        $users = User::all();
        $postcategories = PostCategories::all();

        return view('superadmin.post.edit', compact('post', 'units', 'users', 'postcategories'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'string|max:255|unique:posts,slug,' . $id,
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'publish_date' => 'nullable|date',
            'unit_id' => 'nullable|exists:units,id',
            'post_category_id' => 'required|exists:post_categories,id',
            'desc' => 'nullable|string',
        ]);

        // Cari post yang akan diupdate
        $post = Post::findOrFail($id);

        // Gambar meta_thumbnail dan image
        $metaImage = $post->meta_thumbnail; // Default ke gambar lama
        $postImage = $post->image; // Default ke gambar lama

        // Cek jika ada file image baru
        if ($request->hasFile('image')) {
            $unit = Unit::where('id', $request->unit_id)->first();

            // Hapus gambar lama jika ada
            if ($post->meta_thumbnail) {
                Storage::delete('public/post_meta_thumbnail/' . $post->meta_thumbnail);
            }
            if ($post->image) {
                Storage::delete('public/post_images/' . $post->image);
            }

            // Simpan gambar baru untuk meta_thumbnail
            $metaImage = 'meta_' . md5($request->image) . '.' . $request->image->extension();
            // Pastikan file gambar bisa dibaca dan diproses oleh Intervention Image
            Image::read($request->file('image'))->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save('storage/post_meta_thumbnail/' . $metaImage);

            // Simpan gambar baru untuk image
            $postImage = $unit->nama_unit . '_' . md5($request->image) . '.' . $request->image->extension();
            $request->file('image')->storeAs('public/post_images', $postImage);
        }


        // Update data post
        $post->update([
            'title' => $validated['title'],
            'slug' => Str::slug($request->title),
            'meta_keyword' => $validated['meta_keyword'],
            'meta_description' => $validated['meta_description'],
            'meta_thumbnail' => $metaImage, // Simpan hanya nama file meta_thumbnail
            'image' => $postImage, // Simpan hanya nama file image
            'publish_date' => $validated['publish_date'],
            'status' => 'Inactive',
            'unit_id' => Auth::user()->unit_id,
            'user_id' => Auth::user()->id,
            'post_category_id' => $validated['post_category_id'],
            'desc' => $validated['desc'],
        ]);

        // Redirect ke halaman daftar post setelah update
        return redirect()->back()->with('success', 'Post berhasil diubah.');
    }


    // Function Menghapus Data Post
    public function destroy($id)
    {
        // Cari data Post berdasarkan ID
        $post = Post::findOrFail($id);

        // Hapus file meta_thumbnail jika ada
        if ($post->meta_thumbnail && Storage::exists('public/post_meta_thumbnail/' . $post->meta_thumbnail)) {
            Storage::delete('public/post_meta_thumbnail/' . $post->meta_thumbnail);
        }

        // Hapus file image jika ada
        if ($post->image && Storage::exists('public/post_images/' . $post->image)) {
            Storage::delete('public/post_images/' . $post->image);
        }

        // Hapus data dari database
        $post->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Post berhasil dihapus.');
    }
}
