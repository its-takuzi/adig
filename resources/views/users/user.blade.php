@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mt-1 align-items-center">
        <h3 class="m-3">Users</h3>
        <div class="d-flex align-items-center m-3">
            <img src="{{ asset('/storage/profile/' . (Auth::user()->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                class="rounded-circle" width="40" height="40"
                style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
            <span class="me-2">{{ auth()->user()->name }}</span>
        </div>
    </div>
    <div class="container bg-history">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead style="background-color: #d0efff;">
                        <tr>
                            <th class="text-center align-middle" style="width: 50px;"><input type="checkbox"></th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center align-middle" style="width: 50px;"><input type="checkbox"></td>
                                <td>
                                    <img src="{{ asset('storage/profile/' . ($user->pp ?? 'default.jpg')) }}"
                                        alt="Foto Profil" class="rounded-circle" width="40" height="40">
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td class="gap-1">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="d-inline-flex align-items-center justify-content-center p-1 rounded"
                                        style="background-color: #007bff; width: 37px; height: 37px;">
                                        <img src="{{ asset('aset/edit.png') }}" alt="Edit" width="25" height="25"
                                            style="object-fit: contain;">
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus user ini?')"
                                            class="d-inline-flex align-items-center justify-content-center p-1 rounded border-0"
                                            style="background-color: #dc3545; width: 37px; height: 37px;">
                                            <img src="{{ asset('aset/hapus.png') }}" alt="Hapus" width="25"
                                                height="25" style="object-fit: contain;">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex">
                    <button class="btn ms-auto" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <img style="height: 50px ; width:50px" src="{{ asset('aset/add.png') }}" alt="">
                    </button>
                </div>

                <!-- Modal Tambah User -->
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="pp" class="form-label">Foto Profil</label>
                                        <input type="file" class="form-control" id="pp" name="pp">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" id="role" name="role" required>
                                            <option value="admin">Admin</option>
                                            <option value="staff">Staff</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Tambah User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <footer class="footer">
        <p class="p-3">Copyright 2025 - Qif Media</p>
    </footer>
@endsection
