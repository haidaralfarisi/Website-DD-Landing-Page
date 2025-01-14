@extends('layouts.layout')

{{-- layout = admin --}}
@section('layout')
    <section id="header-nav">
        <div class="container col-xxl-9">
            <div>
                <p class="mb-1 text-dark">Selamat datang di</p>
                <h4 class="font-inter text-dark fw-bold">Dashboard Website Dian Didaktika</h4>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container col-xxl-9">

            @include('layouts.menu_superadmin')

            @include('layouts.alert')

            <div class="p-4 bg-white shadow-sm border rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold">Data Post </h5>
                    </div>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                            Post +</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Post</th>
                                <th>Slug</th>
                                <th>Meta Keyword</th>
                                <th>Meta Deskripsi</th>
                                <th>Meta Thumbnail</th>
                                <th>Image</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Publish</th>
                                <th>Status</th>
                                <th>Unit</th>
                                <th>User Id</th>
                                <th>Category Id</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->slug }}</td>
                                    <td>{{ $post->meta_keyword }}</td>
                                    <td>{{ $post->meta_description }}</td>

                                    <td>
                                        @if ($post->meta_thumbnail)
                                            <img src="{{ asset('storage/' . $post->meta_thumbnail) }}" alt="Meta Thumbnail"
                                                width="50" height="50">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                                width="50" height="50">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>

                                    <td>{{ $post->description }}</td>
                                    <td>{{ $post->publish_date }}</td>
                                    <td>{{ $post->status }}</td>
                                    <td>{{ $post->unit->name ?? 'No Unit' }}</td> <!-- Menampilkan nama unit -->
                                    <td>{{ $post->user->name ?? 'Unknown User' }}</td> <!-- Mengambil nama user -->
                                    <td>{{ $post->category->name ?? 'No Category' }}</td> <!-- Mengambil nama kategori -->
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $post->id }}">
                                            Edit
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('superadmin.posts.destroy', $post->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin mau dihapus?')"
                                                class="btn btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Untuk Edit User-->
                                {{-- Modal harus di dalam foreach dan harus meletakkan {{ $user->id }} agar bisa di panggil sesuai id yang
                                di inginkan --}}
                                <div class="modal fade" id="editModal{{ $post->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3 border-0 rounded-4">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editModalLabel">Edit Data Post</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('superadmin.posts.update', ['id' => $post->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Title -->
                                                    <div class="mb-3">
                                                        <label for="title" class="form-label">Title</label>
                                                        <input type="text" class="form-control" id="title"
                                                            name="title" value="{{ old('title', $post->title) }}"
                                                            required>
                                                    </div>

                                                    <!-- Slug -->
                                                    <div class="mb-3">
                                                        <label for="slug" class="form-label">Slug</label>
                                                        <input type="text" class="form-control" id="slug"
                                                            name="slug" value="{{ old('slug', $post->slug) }}" required>
                                                    </div>

                                                    <!-- Meta Keyword -->
                                                    <div class="mb-3">
                                                        <label for="meta_keyword" class="form-label">Meta Keyword</label>
                                                        <input type="text" class="form-control" id="meta_keyword"
                                                            name="meta_keyword"
                                                            value="{{ old('meta_keyword', $post->meta_keyword) }}">
                                                    </div>

                                                    <!-- Meta Description -->
                                                    <div class="mb-3">
                                                        <label for="meta_description" class="form-label">Meta
                                                            Description</label>
                                                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $post->meta_description) }}</textarea>
                                                    </div>

                                                    <!-- Meta Thumbnail -->
                                                    <div class="mb-3">
                                                        <label for="meta_thumbnail" class="form-label">Meta
                                                            Thumbnail</label>
                                                        <input type="file" class="form-control" id="meta_thumbnail"
                                                            name="meta_thumbnail" accept="image/*">
                                                    </div>

                                                    <!-- Image -->
                                                    <div class="mb-3">
                                                        <label for="image" class="form-label">Image</label>
                                                        <input type="file" class="form-control" id="image"
                                                            name="image" accept="image/*">
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $post->description) }}</textarea>
                                                    </div>

                                                    <!-- Publish Date -->
                                                    <div class="mb-3">
                                                        <label for="publish_date" class="form-label">Publish Date</label>
                                                        <input type="date" class="form-control" id="publish_date"
                                                            name="publish_date"
                                                            value="{{ old('publish_date', $post->publish_date) }}"
                                                            required>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-select" id="status" name="status"
                                                            required>
                                                            <option value="active"
                                                                {{ old('status', $post->status) == 'active' ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="inactive"
                                                                {{ old('status', $post->status) == 'inactive' ? 'selected' : '' }}>
                                                                Inactive</option>
                                                        </select>
                                                    </div>

                                                    <!-- Unit -->
                                                    <div class="mb-3">
                                                        <label for="unit_id" class="form-label">Unit</label>
                                                        <select class="form-select" id="unit_id" name="unit_id"
                                                            required>
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit->id }}"
                                                                    {{ old('unit_id', $post->unit_id) == $unit->id ? 'selected' : '' }}>
                                                                    {{ $unit->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- User ID -->
                                                    <div class="mb-3">
                                                        <label for="user_id" class="form-label">User</label>
                                                        <select class="form-select" id="user_id" name="user_id"
                                                            required>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Category ID -->
                                                    <div class="mb-3">
                                                        <label for="category_id" class="form-label">Category</label>
                                                        <select class="form-select" id="category_id" name="category_id"
                                                            required>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal Untuk Create Unit-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 border-0 rounded-4">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Tambah Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Title" required>
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug"
                                required>
                        </div>

                        <!-- Meta Keyword -->
                        <div class="mb-3">
                            <label for="meta_keyword" class="form-label">Meta Keyword</label>
                            <input type="text" class="form-control" id="meta_keyword" name="meta_keyword"
                                placeholder="Meta Keyword">
                        </div>

                        <!-- Meta Description -->
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                                placeholder="Meta Description"></textarea>
                        </div>

                        <!-- Meta Thumbnail -->
                        <div class="mb-3">
                            <label for="meta_thumbnail" class="form-label">Meta Thumbnail</label>
                            <input type="file" class="form-control" id="meta_thumbnail" name="meta_thumbnail"
                                placeholder="Meta Thumbnail">
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Description"></textarea>
                        </div>

                        <!-- Publish Date -->
                        <div class="mb-3">
                            <label for="publish_date" class="form-label">Publish Date</label>
                            <input type="date" class="form-control" id="publish_date" name="publish_date" required>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Unit -->
                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Unit</label>
                            <select name="unit_id" id="unit_id" class="form-select">
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- User ID -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User</label>
                            <select class="form-select" id="user_id" name="user_id">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Category ID -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
