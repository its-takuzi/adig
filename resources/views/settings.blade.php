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
                <div class="row">
                    <div class="col-4">
                        <div>
                            <label>Foto Profil</label>
                            <p>
                                <img src="{{ asset('storage/profile/' . ($user->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                                    class="rounded-circle" width="100" height="100"
                                    style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
                            </p>
                            <!-- Form Upload Foto Profil -->
                            <form action="{{ route('settings.updatePhoto') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="pp" required>
                                <button type="submit" class="btn btn-primary mt-2">Upload Foto</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-8">
                        <!-- Form Update Nama, Email, dan Password -->
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('POST')

                            <label>Nama:</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}"
                                class="form-control mb-2" required>

                            <label>Email:</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}"
                                class="form-control mb-2" required>

                            <label>Password (kosongkan jika tidak ingin mengubah):</label>
                            <input type="password" name="password" class="form-control mb-2">

                            <button type="submit" class="btn btn-success mt-2">Simpan Perubahan</button>
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
