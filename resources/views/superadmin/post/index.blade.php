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

            {{-- @include('layouts.menu_superadmin') --}}

            <div class="d-flex align-items-center mb-4">
                <button onclick="window.location.href='{{ route('beranda') }}'" class="btn btn-secondary me-2">
                    Kembali
                </button>
                {{-- <div class="me-2">|</div>
                <div class="text-decoration-none me-2 fw-bold">Data Achievement</div> --}}
            </div>

            @include('layouts.alert')

            <div class="p-4 bg-white shadow-sm border rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold">Data Post </h5>
                    </div>
                    <div>
                        <a href="{{ route('superadmin.posts.create') }}" class="btn btn-primary">Tambah Post +</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                {{-- <th>Slug</th> --}}
                                {{-- <th>Meta Keyword</th> --}}
                                {{-- <th>Meta Deskripsi</th> --}}
                                {{-- <th>Meta Thumbnail</th> --}}
                                <th>Image</th>
                                {{-- <th>Deskripsi</th> --}}
                                <th>Date</th>
                                <th>Viewers</th>
                                <th>Status</th>
                                <th>Unit</th>
                                {{-- <th>Post Category</th> --}}
                                {{-- <th>User Id</th> --}}
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="max-width: 300px">{{ $post->title }}</td>
                                    {{-- <td>{{ $post->slug }}</td> --}}
                                    {{-- <td>{{ $post->meta_keyword }}</td> --}}
                                    {{-- <td>{{ $post->meta_description }}</td> --}}

                                    {{-- <td>
                                        @if ($post->meta_thumbnail)
                                            <img src="{{ asset('storage/' . $post->meta_thumbnail) }}" alt="Meta Thumbnail"
                                                width="50" height="50">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td> --}}

                                    <td>
                                        @if ($post->image)
                                            <img src="{{ asset('storage/images/' . $post->image) }}" alt="Post Image"
                                                width="110" height="80" style="cursor: pointer;"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                data-image="{{ asset('storage/images/' . $post->image) }}">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>

                                    {{-- <td>{{ $post->desc }}</td> --}}
                                    <td>{{ date('d/m/Y', strtotime($post->publish_date)) }}</td>
                                    <td>{{ $post->viewers }}</td>
                                    <td>{{ $post->status }}</td>
                                    <td>{{ $post->unit->nama_unit ?? 'No Unit' }}</td> <!-- Menampilkan nama unit -->
                                    {{-- <td>{{ $post->postcategory->name ?? 'No Category' }}</td> --}}
                                    <!-- Mengambil nama kategori -->
                                    {{-- <td>{{ $post->user->name ?? 'Unknown User' }}</td> --}}
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('superadmin.posts.edit', $post->id) }}"
                                            class="btn btn-outline-primary">
                                            Edit
                                        </a>

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
                                {{-- <div class="modal fade" id="editModal{{ $post->id }}" tabindex="-1"
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

                                                    <!-- Publish Date -->
                                                    <div class="mb-3">
                                                        <label for="publish_date" class="form-label">Publish Date</label>
                                                        <input type="date" class="form-control" id="publish_date"
                                                            name="publish_date"
                                                            value="{{ old('publish_date', $post->publish_date) }}"
                                                            required>
                                                    </div>

                                                    <!-- Viewers -->
                                                    <div class="mb-3">
                                                        <label for="viewers" class="form-label">Viewers</label>
                                                        <input type="viewers" class="form-control" id="viewers"
                                                            name="viewers" value="{{ old('title', $post->viewers) }}"
                                                            required>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-select" id="status" name="status"
                                                            required>
                                                            <option value="Active"
                                                                {{ old('status', $post->status) == 'Active' ? 'selected' : '' }}>
                                                                Active
                                                            </option>
                                                            <option value="Inactive"
                                                                {{ old('status', $post->status) == 'Inactive' ? 'selected' : '' }}>
                                                                Inactive
                                                            </option>
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
                                                                    {{ $unit->nama_unit }}</option>
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

                                                    <!-- Post Category -->
                                                    <div class="mb-3">
                                                        <label for="post_category_id" class="form-label">Post
                                                            Category</label>
                                                        <select class="form-select" id="post_category_id"
                                                            name="post_category_id" required>
                                                            @foreach ($postcategories as $postcategory)
                                                                <option value="{{ $postcategory->id }}"
                                                                    {{ old('post_category_id', $post->post_category_id) == $postcategory->id ? 'selected' : '' }}>
                                                                    {{ $postcategory->name }}</option>
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
                                </div> --}}
                            @endforeach

                        </tbody>
                    </table>

                    <!-- Modal Bootstrap Untuk Pop Up Gambar -->
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Post Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="modalImage" src="" alt="Image" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Script untuk menangani klik pada gambar
                        document.addEventListener('DOMContentLoaded', function() {
                            const imageModal = document.getElementById('imageModal');
                            const modalImage = document.getElementById('modalImage');

                            imageModal.addEventListener('show.bs.modal', function(event) {
                                const trigger = event.relatedTarget; // Element yang memicu modal
                                const imageUrl = trigger.getAttribute('data-image');
                                modalImage.src = imageUrl; // Set gambar pada modal
                            });
                        });
                    </script>
                    {{-- {{ $posts->links() }} --}}
                </div>
            </div>
        </div>
    </section>


    {{-- <!-- Modal Untuk Create Unit-->
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

                        <!-- Publish Date -->
                        <div class="mb-3">
                            <label for="publish_date" class="form-label">Publish Date</label>
                            <input type="date" class="form-control" id="publish_date" name="publish_date" required>
                        </div>

                        <!-- Viewers -->
                        <div class="mb-3">
                            <label for="viewers" class="form-label">Viewers</label>
                            <input type="text" class="form-control" id="viewers" name="viewers"
                                placeholder="Viewers" required>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Unit -->
                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Unit</label>
                            <select name="unit_id" id="unit_id" class="form-select">
                                <option value="" disabled selected>Pilih Nama Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- User ID -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User</label>
                            <select class="form-select" id="user_id" name="user_id">
                                <option value="" disabled selected>Pilih Nama User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Post Category -->
                        <div class="mb-3">
                            <label for="post_category_id" class="form-label">Post Category</label>
                            <select name="post_category_id" id="post_category_id" class="form-select">
                                <option value="" disabled selected>Pilih Post Category</option>

                                @foreach ($postcategories as $postcategory)
                                    <option value="{{ $postcategory->id }}">{{ $postcategory->name }}</option>
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
    </div> --}}
@endsection
