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
                    <div class="col-3">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            <div>
                                <label>Nama:</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}">
                            </div>
                            <div>
                                <label>Email:</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}">
                            </div>
                            <div>
                                <label>Password (kosongkan jika tidak ingin mengubah):</label>
                                <input type="password" name="password">
                            </div>
                            <button type="submit">Simpan Perubahan</button>
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
