@extends('layouts.app')

@section('content')
    <!-- Desktop Header -->
    <div class="d-flex justify-content-between mt-1 align-items-center d-none d-md-flex">
        <h3 class="judul">SETTING</h3>
        <div class=" photo-profile d-flex align-items-center m-3">
            <img src="{{ asset('storage/profile/' . ($user->pp ?? 'default.jpg')) }}" alt="Foto Profil" class="rounded-circle"
                width="40" height="40" style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
            <span class="me-2">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="container-fluid bg-arsip" style=" padding-left: 3.125rem;
    padding-top: 3.125rem;">
        <div class="card-setting">
            <div class="card-body">
                <div class="row gx-3">
                    <!-- Bagian Foto Profil -->
                    <div class="col-md-3 d-flex flex-column align-items-start ps-2">
                        <form id="photoForm" action="{{ route('settings.updatePhoto') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <p class="mb-2">
                                <img id="profilePreview"
                                    src="{{ asset('storage/profile/' . ($user->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                                    class="rounded-circle" width="98" height="98"
                                    style="object-fit: cover; aspect-ratio: 1/1;">
                            </p>
                            <div class="text-center w-100">
                                <button type="button" class="btn mt-1" style="background-color: #e0f0ff; color: #007bff;"
                                    onclick="document.getElementById('pp').click()">Change</button>
                            </div>
                            <input type="file" name="pp" id="pp" class="d-none"
                                onchange="document.getElementById('photoForm').submit()">
                        </form>
                    </div>

                    <!-- Bagian Form Input -->
                    <div class="col-md-6 mt-3 mt-md-0 position-relative d-flex flex-column justify-content-center">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            <!-- input nama -->
                            <div class="mb-1">
                                <label for="name" class="form-label" style="font-size: 15px;">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ $user->name }}"
                                    class="form-control" style="max-width: 100%;">
                            </div>

                            <!-- input email -->
                            <div class="mb-1">
                                <label for="email" class="form-label" style="font-size: 15px;">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}"
                                    class="form-control" style="max-width: 100%;">
                            </div>

                            <!-- input password -->
                            <div class="mb-1 position-relative">
                                <label for="password" class="form-label" style="font-size: 0.938rem;">Password</label>
                                <input type="password" id="password" name="password" class="form-control pe-5"
                                    style="max-width: 100%;" placeholder="">

                                <img src="{{ asset('aset/eye.svg') }}" alt="Toggle Password" id="togglePassword"
                                    style="position: absolute; top: 75%; right: 0.938rem; transform: translateY(-50%); width: 20px; height: 20px; cursor: pointer;">
                            </div>


                            <!-- Tombol Save & Cancel -->
                            <div class="mt-3" style="max-width: 90%; margin-left: auto;">
                                <div class="d-flex justify-content-end tombol-wrapper">
                                    <button type="submit" class="btn me-2"
                                        style="background-color: #dc3545; color: white; 
                                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 100px;">
                                        Save
                                    </button>
                                    <button type="button" class="btn"
                                        style="background-color: white; color: #6c757d; 
                                            border: 1px solid #ced4da; width: 100px;">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
