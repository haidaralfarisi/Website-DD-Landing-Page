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
                        <h5 class="fw-bold">Data Slider </h5>
                    </div>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                            Slider +</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Slider</th>
                                <th>Unit</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $slider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->unit->nama_unit ?? 'Tidak Ada Unit' }}</td>
                                    {{-- <td>
                                            @if ($slider->image)
                                                <img src="{{ asset('storage/images/' . $slider->image) }}" alt="slider"
                                                    width="50">
                                            @else
                                                <span>Tidak ada gambar</span>
                                            @endif
                                        </td> --}}

                                    <td>
                                        @if ($slider->image)
                                            <img src="{{ asset('storage/sliders/' . $slider->image) }}" alt="Slider"
                                                width="110" height="80" style="cursor: pointer;"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                data-image="{{ asset('storage/sliders/' . $slider->image) }}">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>

                                    <td>{{ $slider->status }}</td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $slider->id }}">
                                            Edit
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('slider.destroy', $slider->id) }}" method="POST"
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
                                <div class="modal fade" id="editModal{{ $slider->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3 border-0 rounded-4">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editModalLabel">Edit Data Slider</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editSliderForm"
                                                    action="{{ route('slider.update', ['id' => $slider->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Title -->
                                                    <div class="mb-3">
                                                        <label for="title" class="form-label">Title</label>
                                                        <input type="text" class="form-control" id="title"
                                                            name="title" value="{{ old('title', $slider->title) }}"
                                                            required>
                                                    </div>

                                                    <!-- Unit -->
                                                    <div class="mb-3">
                                                        <label for="unit_id" class="form-label">Unit</label>
                                                        <select class="form-select" id="unit_id" name="unit_id" required>
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit->id }}"
                                                                    {{ old('unit_id', $slider->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                                                                    {{ $unit->nama_unit }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Image -->
                                                    <div class="mb-3">
                                                        <label for="image" class="form-label">Image</label>
                                                        <input type="file" class="form-control" id="image"
                                                            name="image" accept="image/*">
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-select" id="status" name="status" required>
                                                            <option value="Active"
                                                                {{ old('status', $slider->status) == 'Active' ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="Inactive"
                                                                {{ old('status', $slider->status) == 'Inactive' ? 'selected' : '' }}>
                                                                Inactive</option>
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
                        </tbody>
                    </table>
                    {{-- {{$sliders->links()}} --}}
                </div>
            </div>

        </div>
    </section>


    <!-- Modal Untuk Create slider-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 border-0 rounded-4">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Tambah Slider</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Slider -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Slider</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Judul Slider" required>
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

                        <!-- Gambar -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
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
