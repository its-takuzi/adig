@extends('layouts.app')

@section('content')
    <!-- Desktop Header -->
    <div class="d-flex justify-content-between mt-1 align-items-center d-none d-md-flex">
        <h3 class="m-3">Settings</h3>
        <div class="d-flex align-items-center m-3">
            <img src="{{ asset('storage/profile/' . ($user->profile_photo ?? 'default.jpg')) }}" alt="Foto Profil"
                class="rounded-circle" width="40" height="40"
                style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
            <span class="me-2">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="container bg-history">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Bagian Foto Profil -->
                    <div class="col-md-4 profile-center-mobile">
                        <label>Foto Profil</label>
                        <p>
                            <img src="{{ asset('storage/profile/' . ($user->profile_photo ?? 'default.jpg')) }}"
                                alt="Foto Profil" class="rounded-circle" width="100" height="100"
                                style="object-fit: cover; aspect-ratio: 1/1;">
                        </p>
                        <form action="{{ route('settings.updatePhoto') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_photo" required class="form-control">
                            <button type="submit" class="btn btn-primary mt-2">Upload Foto</button>
                        </form>
                    </div>

                    <!-- Bagian Form Input -->
                    <div class="col-md-8 form-input-center mt-4 mt-md-0">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf

                            <!-- input nama -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" name="name" value="{{ $user->name }}"
                                    class="form-control">
                            </div>

                            <!-- input email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}"
                                    class="form-control">
                            </div>

                            <!-- input password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>

                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p class="p-3">Copyright 2024 - Qif Media</p>
    </footer>
@endsection
