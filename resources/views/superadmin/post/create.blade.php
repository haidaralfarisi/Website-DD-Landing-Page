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
                <button onclick="window.location.href='{{ route('superadmin.posts.index') }}'" class="btn btn-secondary me-2">
                    Kembali
                </button>
                {{-- <div class="me-2">|</div>
                <div class="text-decoration-none me-2 fw-bold">Data Achievement</div> --}}
            </div>

            @include('layouts.alert')


            <div class="p-4 bg-white shadow-sm border rounded-3">
                <h2 class="mb-4">Form Tambah Post</h2>
                <form action="{{ route('superadmin.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title"
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

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description</label>
                        <textarea class="form-control" id="summernote" name="desc" rows="3" placeholder="Description"></textarea>
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

                    <!-- Unit -->
                    <div class="mb-3">
                        <label for="publish_date" class="form-label">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-select">
                            <option value="" disabled selected>Pilih Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Post Category -->
                    <div class="mb-4">
                        <label for="post_category_id" class="form-label">Post Category</label>
                        <select name="post_category_id" id="post_category_id" class="form-select">
                            <option value="" disabled selected>Pilih Post Category</option>
                            @foreach ($postcategories as $postcategory)
                                <option value="{{ $postcategory->id }}">{{ $postcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>

                <!-- After the form is successfully submitted, display the description -->
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {!! session('success') !!}
                    </div>
                    <div>
                        <h4>Deskripsi yang Diformat:</h4>
                        <div>
                            {!! old('desc') !!}
                        </div>
                    </div>
                @endif
            </div>
        @endsection
