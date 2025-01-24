@extends('layouts.layout')

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
        <div class="container col-xxl-9 p-4 bg-white shadow-sm border rounded-3">
            <div class="d-flex align-items-center mb-4">
                <button onclick="window.location.href='{{ route('superadmin.posts.index') }}'"
                    class="btn btn-secondary me-2">Kembali</button>
            </div>

            @include('layouts.alert')

            <h2 class="mb-4">Form Edit Post</h2>
            <form action="{{ route('superadmin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}"
                        required>
                </div>

                {{-- <!-- Slug -->
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $post->slug }}"
                        required>
                </div> --}}

                <!-- Meta Keyword -->
                <div class="mb-3">
                    <label for="meta_keyword" class="form-label">Meta Keyword</label>
                    <input type="text" class="form-control" id="meta_keyword" name="meta_keyword"
                        value="{{ $post->meta_keyword }}">
                </div>

                <!-- Meta Description -->
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ $post->meta_description }}</textarea>
                </div>

                {{-- <!-- Meta Thumbnail -->
                <div class="mb-3">
                    <label for="meta_thumbnail" class="form-label">Meta Thumbnail</label>
                    <input type="file" class="form-control" id="meta_thumbnail" name="meta_thumbnail">
                </div> --}}

                <!-- Description (Summernote) -->
                <div class="mb-3">
                    <label for="desc" class="form-label">Description</label>
                    <textarea class="form-control" id="summernote" name="desc" rows="3">{{ old('desc', $post->desc) }}</textarea>
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <!-- Publish Date -->
                <div class="mb-3">
                    <label for="publish_date" class="form-label">Publish Date</label>
                    <input type="date" class="form-control" id="publish_date" name="publish_date"
                        value="{{ $post->publish_date }}" required>
                </div>

                <!-- Unit -->
                <div class="mb-4">
                    <label for="unit_id" class="form-label">Unit</label>
                    <select name="unit_id" id="unit_id" class="form-select">
                        <option value="" disabled selected>Pilih Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}"
                                {{ $post->unit_id == $unit->id ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                {{-- <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" {{ $post->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $post->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div> --}}

                <!-- Unit -->
                {{-- <div class="mb-3">
                    <label for="unit_id" class="form-label">Unit</label>
                    <select name="unit_id" id="unit_id" class="form-select">
                        <option value="" disabled selected>Pilih Nama Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" {{ $post->unit_id == $unit->id ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <!-- User ID -->
                {{-- <div class="mb-3">
                    <label for="user_id" class="form-label">User</label>
                    <select class="form-select" id="user_id" name="user_id">
                        <option value="" disabled selected>Pilih Nama User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $post->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <!-- Post Category -->
                <div class="mb-4">
                    <label for="post_category_id" class="form-label">Post Category</label>
                    <select name="post_category_id" id="post_category_id" class="form-select">
                        <option value="" disabled selected>Pilih Post Category</option>
                        @foreach ($postcategories as $postcategory)
                            <option value="{{ $postcategory->id }}"
                                {{ $post->post_category_id == $postcategory->id ? 'selected' : '' }}>
                                {{ $postcategory->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </section>
@endsection
