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
                        <h5 class="fw-bold">Data Achievement </h5>
                    </div>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                            Achievement +</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Achievement</th>
                                <th>Unit</th>
                                <th>Image</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Tgl Achievement</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($achievements as $achievement)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $achievement->title }}</td>
                                    <td>{{ $achievement->unit->nama_unit ?? 'Tidak Ada Unit' }}</td>
                                    <td>
                                        @if ($achievement->image)
                                            <img src="{{ asset('storage/' . $achievement->image) }}" alt="Video Image"
                                                width="50" height="50">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    <td>{{ $achievement->desc }}</td>
                                    <td>{{ $achievement->status }}</td>
                                    <td>{{ $achievement->achievement_date }}</td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $achievement->id }}">
                                            Edit
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('achievement.destroy', $achievement->id) }}" method="POST"
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
                                <div class="modal fade" id="editModal{{ $achievement->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3 border-0 rounded-4">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editModalLabel">Edit Data Achievement</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editAchievementForm"
                                                    action="{{ route('achievement.update', ['id' => $achievement->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Title -->
                                                    <div class="mb-3">
                                                        <label for="title" class="form-label">Title</label>
                                                        <input type="text" class="form-control" id="title"
                                                            name="title" value="{{ old('title', $achievement->title) }}"
                                                            required>
                                                    </div>

                                                    <!-- Unit -->
                                                    <div class="mb-3">
                                                        <label for="unit_id" class="form-label">Unit</label>
                                                        <select class="form-select" id="unit_id" name="unit_id" required>
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit->id }}"
                                                                    {{ old('unit_id', $achievement->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
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

                                                    <!-- Description -->
                                                    <div class="mb-3">
                                                        <label for="desc" class="form-label">Description</label>
                                                        <textarea class="form-control" id="desc" name="desc" rows="5" required>
                                                            {{ old('desc', $achievement->desc) }}
                                                    </textarea>
                                                    </div>


                                                    <!-- Status -->
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-select" id="status" name="status" required>
                                                            <option value="active"
                                                                {{ old('status', $achievement->status) == 'active' ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="inactive"
                                                                {{ old('status', $achievement->status) == 'inactive' ? 'selected' : '' }}>
                                                                Inactive</option>
                                                        </select>
                                                    </div>

                                                    <!-- Achievement Date -->
                                                    <div class="mb-3">
                                                        <label for="achievement_date" class="form-label">Achievement
                                                            Date</label>
                                                        <input type="date" class="form-control" id="achievement_date"
                                                            name="achievement_date"
                                                            value="{{ old('achievement_date', $achievement->achievement_date) }}"
                                                            required>
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
                    {{ $achievements->links() }}
                </div>
            </div>

        </div>
    </section>


    <!-- Modal Untuk Create Unit-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 border-0 rounded-4">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Tambah Achievement</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('achievement.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama achievement -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Achievement</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Judul Achievement" required>
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

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <!-- Deskripsi Achievement -->
                        <div class="mb-3">
                            <label for="desc" class="form-label">Deskripsi Achievement</label>
                            <textarea class="form-control" id="desc" name="desc" placeholder="Deskripsi Achievement" rows="5"
                                required></textarea>
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

                        <!-- Tanggal Pencapaian -->
                        <div class="mb-3">
                            <label for="achievement_date" class="form-label">Tanggal Pencapaian</label>
                            <input type="date" class="form-control" id="achievement_date" name="achievement_date"
                                placeholder="Tanggal pencapaian" required>
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
