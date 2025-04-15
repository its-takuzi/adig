@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mt-1 align-items-center">
        <h3 class="m-3">Rak</h3>
        <div class="d-flex align-items-center m-3">
            <img src="{{ asset('/storage/profile/' . (Auth::user()->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                class="rounded-circle" width="40" height="40"
                style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
            <span class="me-2">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="container-fluid bg-dashboard">
        <div class="row">
            <div class="col-12 p-3 justify-content-center">
                <div class="card-table w-100 " style="font-size: 14px">
                    <div class="col-5" style="display: flex">
                        <div class="dropdown mt-3 ms-3">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownrak"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ request('nama_rak') ? request('nama_rak') : 'Semua Rak' }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownrak">
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('rak.index', request()->except('nama_rak', 'page')) }}">
                                        Semua Rak
                                    </a>
                                </li>
                                @foreach ($listRak as $rak)
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('rak.index', array_merge(request()->except('page'), ['nama_rak' => $rak])) }}">
                                            {{ $rak }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                    <div class="col-12 mt-4">
                        <div class="card-header m-2">Daftar Dokumen</div>
                        <div class="table-responsive p-2">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th style="width: 350px;">Nomor LP</th>
                                        <th>Kategori</th>
                                        <th>Tanggal</th>
                                        <th>Rak Penyimpanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dokumens as $dokumen)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td
                                                style="max-width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $dokumen->laporan_polisi }}</td>
                                            <td>{{ $dokumen->kategori }}</td>
                                            <td>{{ $dokumen->tanggal_laporan }}</td>
                                            <td>{{ $dokumen->rak->nama_rak ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada dokumen</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="">
                                    Showing {{ $dokumens->firstItem() }} to {{ $dokumens->lastItem() }} of
                                    {{ $dokumens->total() }}
                                    entries
                                </p>
                                {{ $dokumens->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Tambah Rak --}}
            <div class="d-flex">
                <button class="btn ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambahRak">
                    <img style="height: 50px ; width:50px" src="{{ asset('aset/add.png') }}" alt="">
                </button>
            </div>

            <!-- Modal Tambah Rak -->
            <div class="modal fade" id="modalTambahRak" tabindex="-1" aria-labelledby="modalTambahRakLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('rak.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahRakLabel">Tambah Rak Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_rak" class="form-label">Nama Rak</label>
                                    <input type="text" class="form-control" id="nama_rak" name="nama_rak" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
