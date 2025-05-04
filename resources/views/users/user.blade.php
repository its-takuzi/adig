@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mt-1 align-items-center">
        <h3 class="judul">USER</h3>
        <div class="d-flex align-items-center m-3">
            <img src="{{ asset('/storage/profile/' . (Auth::user()->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                class="rounded-circle" width="40" height="40"
                style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
            <span class="me-2">{{ auth()->user()->name }}</span>
        </div>
    </div>
    <div class="container-fluid bg-history">
        <div class="card-user">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead style="background-color: #d0efff;">
                        <tr>
                            <th class="text-center align-middle" style="width: 50px;"><input type="checkbox"></th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            @if (auth()->user()->role === 'admin')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center align-middle" style="width: 3.125rem;"><input type="checkbox"></td>
                                <td>
                                    <img src="{{ asset('storage/profile/' . ($user->pp ?? 'default.jpg')) }}"
                                        alt="Foto Profil" class="rounded-circle" width="40" height="40">
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>

                                @if (auth()->user()->role === 'admin')
                                    <td class="gap-1">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="d-inline-flex align-items-center justify-content-center p-1 rounded"
                                            style="background-color: #007bff; width: 2.313rem; height: 2.313rem;">
                                            <img src="{{ asset('aset/edit.png') }}" alt="Edit" width="25"
                                                height="25" style="object-fit: contain;">
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus user ini?')"
                                                class="d-inline-flex align-items-center justify-content-center p-1 rounded border-0"
                                                style="background-color: #dc3545; width: 2.313rem; height: 2.313rem;">
                                                <img src="{{ asset('aset/hapus.png') }}" alt="Hapus" width="25"
                                                    height="25" style="object-fit: contain;">
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (auth()->user()->role === 'admin')
                    <!-- ini  jas -->
                    <div class="d-flex">
                        <button class="btn ms-auto mt-4 p-0 border-0 bg-transparent shadow-none" data-bs-toggle="modal"
                            data-bs-target="#addUserModal">
                            <img style="height: 3.125rem ; width:3.125rem" src="{{ asset('aset/add.png') }}"
                                alt="">
                        </button>
                    </div>
                @endif <!-- ini  jas -->
                @if (auth()->user()->role === 'admin')
                    <!-- ini  jas -->
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
                                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"
                                        class="d-flex flex-column align-items-center">
                                        @csrf

                                        <!-- Foto Profil -->
                                        <div class="mb-3" style="width: 100%; max-width: 20.125rem;">
                                            <label for="pp" class="form-label">Foto Profil</label>
                                            <input type="file" class="form-control" id="pp" name="pp">
                                        </div>

                                        <!-- Nama Lengkap -->
                                        <div class="mb-3 position-relative"
                                            style="width: 100%; max-width: 20.125rem; height: 4rem;">
                                            <img src="{{ asset('aset/username.svg') }}" alt="Nama Icon"
                                                style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 1.25rem; height: 1.25rem; filter: brightness(0.5);">
                                            <input type="text" id="name" name="name" required
                                                placeholder="Nama Lengkap"
                                                style="width: 100%; height: 100%; padding-left: 2.813rem; padding-right: 0.938rem; border: 0.063rem solid #E3E3E3; border-radius: 0.625rem; outline: none;">
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-3 position-relative"
                                            style="width: 100%; max-width: 20.125rem; height: 4rem;">
                                            <img src="{{ asset('aset/email.svg') }}" alt="Email Icon"
                                                style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 1.25rem; height: 1.25rem; filter: brightness(0.5);">
                                            <input type="email" id="email" name="email" required
                                                placeholder="youremail@gmail.com"
                                                style="width: 100%; height: 100%; padding-left: 2.813rem; padding-right: 0.938rem; border: 0.063rem solid #E3E3E3; border-radius: 0.625rem; outline: none;">
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3 position-relative"
                                            style="width: 100%; max-width: 20.125rem; height: 4rem;">
                                            <img src="{{ asset('aset/password.svg') }}" alt="Password Icon"
                                                style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 1.25rem; height: 1.25rem; filter: brightness(0.5);">
                                            <input type="password" id="password" name="password" required
                                                placeholder="Min 8 Karakter"
                                                style="width: 100%; height: 100%; padding-left: 2.813rem; padding-right: 2.813rem; border: 0.063rem solid #E3E3E3; border-radius: 0.625rem; outline: none;">
                                            <img src="{{ asset('aset/eye.svg') }}" alt="Show Password"
                                                id="togglePassword"
                                                style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); width: 1.25rem; height: 1.25rem; cursor: pointer;">
                                        </div>

                                        <!-- Role -->
                                        <div class="mb-3" style="width: 100%; max-width: 20.125rem;">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-select" id="role" name="role" required>
                                                <option value="admin">Admin</option>
                                                <option value="staff">Staff</option>
                                            </select>
                                        </div>

                                        <!-- Tombol Submit -->
                                        <button type="submit" class="btn btn-primary mt-2">Tambah User</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif <!-- ini  jas -->
            </div>
        </div>
        <footer class="footer">
            <p class="">Copyright 2025 - Qif Media</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Ganti icon jika perlu (misal: mata terbuka / tertutup)
                if (type === 'text') {
                    this.src =
                        "{{ asset('aset/eye-off.svg') }}"; // Pastikan file eye-off.svg ada di folder aset.
                } else {
                    this.src = "{{ asset('aset/eye.svg') }}";
                }
            });
        });
    </script>
@endsection
