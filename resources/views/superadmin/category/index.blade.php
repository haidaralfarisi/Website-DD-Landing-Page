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
                        <h5 class="fw-bold">Data Category </h5>
                    </div>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                            Category +</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Category</th>
                                <th>Unit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->unit->name ?? 'Tidak Ada Unit' }}</td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $category->id }}">
                                            Edit
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
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
                                <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3 border-0 rounded-4">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editModalLabel">Edit Category</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editCategoryForm"
                                                    action="{{ route('categories.update', ['id' => $category->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Nama -->
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ old('name', $category->name) }}"
                                                            required>
                                                    </div>

                                                    {{-- <!-- Unit -->
                                                    <div class="mb-3">
                                                        <label for="unit" class="form-label">Unit</label>
                                                        <input type="unit" class="form-control" id="unit"
                                                            name="unit" value="{{ old('unit', $category->unit) }}"
                                                            required>
                                                    </div> --}}

                                                    <div class="mb-3">
                                                        <label for="unit_id" class="form-label">Unit</label>
                                                        <select class="form-select" id="unit_id" name="unit_id" required>
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit->id }}"
                                                                    {{ old('unit_id', $category->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                                                                    {{ $unit->name }}
                                                                </option>
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
                    {{ $categories->links() }}
                </div>
            </div>

        </div>
    </section>


    <!-- Modal Untuk Create Category-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 border-0 rounded-4">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Tambah Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Category</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Category" required>
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
