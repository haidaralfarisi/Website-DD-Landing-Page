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
                        <h5 class="fw-bold">Data User </h5>
                    </div>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                            User +</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIP</th>
                                <th>Nama Label</th>
                                <th>Avatar</th>
                                <th>Unit</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nip }}</td>
                                    <td>{{ $user->name_label }}</td>
                                    <td>
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" width="50"
                                                height="50" class="rounded-circle">
                                        @else
                                            <span>No Avatar</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->unit }}</td>
                                    <td>{{ $user->level }}</td>
                                    <td>

                                        {{-- ketika ingin memanggil id, di letakkan di *editModal --}}
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $user->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
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
                                <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3 border-0 rounded-4">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editModalLabel">Edit User</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editUserForm"
                                                    action="{{ route('users.update', ['id' => $user->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Nama -->
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ old('name', $user->name) }}" required>
                                                    </div>
                                                    <!-- Email -->
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email"
                                                            name="email" value="{{ old('email', $user->email) }}"
                                                            required>
                                                    </div>
                                                    <!-- NIP -->
                                                    <div class="mb-3">
                                                        <label for="nip" class="form-label">NIP</label>
                                                        <input type="text" class="form-control" id="nip"
                                                            name="nip" value="{{ old('nip', $user->nip) }}" required>
                                                    </div>
                                                    <!-- Name Label -->
                                                    <div class="mb-3">
                                                        <label for="name_label" class="form-label">Label Nama</label>
                                                        <input type="text" class="form-control" id="name_label"
                                                            name="name_label"
                                                            value="{{ old('name_label', $user->name_label) }}">
                                                    </div>
                                                    <!-- Avatar -->
                                                    <div class="mb-3">
                                                        <label for="avatar" class="form-label">Avatar</label>
                                                        <input type="file" class="form-control" id="avatar"
                                                            name="avatar" accept="image/*">
                                                    </div>
                                                    <!-- Level -->
                                                    <div class="mb-3">
                                                        <label for="level" class="form-label">Level</label>
                                                        <select class="form-select" id="level" name="level" required>
                                                            <option value="superadmin"
                                                                {{ $user->level == 'superadmin' ? 'selected' : '' }}>
                                                                Superadmin
                                                            </option>
                                                            <option value="admin"
                                                                {{ $user->level == 'admin' ? 'selected' : '' }}>Admin
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <!-- Unit -->
                                                    <div class="mb-3">
                                                        <label for="unit" class="form-label">Unit</label>
                                                        <input type="text" class="form-control" id="unit"
                                                            name="unit" value="{{ old('unit', $user->unit) }}"
                                                            required>
                                                    </div>
                                                    <!-- Password -->
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" id="password"
                                                            name="password"
                                                            placeholder="Kosongkan jika tidak ingin mengubah password">
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


    <!-- Modal Untuk Create User-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 border-0 rounded-4">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Tambah User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="name_label" class="form-label">Label Nama</label>
                            <input type="text" class="form-control" id="name_label" name="name_label"
                                placeholder="Label Nama">
                        </div>
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-select" id="level" name="level" required>
                                <option value="superadmin">Superadmin</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control" id="unit" name="unit" placeholder="Unit"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
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
