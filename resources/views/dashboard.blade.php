@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mt-1 align-items-center">
        <h3 class="m-3">DASHBOARD</h3>
        <div class="d-flex align-items-center m-3">
            <img src="{{ asset('/storage/profile/' . (Auth::user()->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                class="rounded-circle" width="40" height="40"
                style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
            <span class="me-2">{{ auth()->user()->name }}</span>
        </div>
    </div>
    <div class="container-fluid bg-dashboard">
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-12 p-3 justify-content-center">
                        <div class="card-item">
                            <div>
                                <div class="text" style="font-size: 21px; color: #8898AA">Total Dokumen</div>
                                <div class="number" style="font-size: 30px; color:black">{{ $totalDokumen }}</div>
                            </div>
                            <div class="icon">
                                <img src="{{ asset('aset/total_dokumen.png') }}" alt="Dokumen Icon">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 p-3 justify-content-center">
                        <div class="card-item">
                            <div>
                                <div class="text"style="font-size: 21px; color: #8898AA">Total Size</div>
                                <div class="number"style="font-size: 30px; color:black">{{ number_format($totalSize, 2) }}
                                    MB</div>
                            </div>
                            <div class="icon">
                                <img src="{{ asset('aset/total_size.png') }}" alt="Dokumen size">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 p-3 justify-content-center">
                <div class="card-item ">
                    <div class="d-flex justify-content-center">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 p-3 justify-content-center">
                <div class="card-table w-100 " style="font-size: 14px">
                    <div class="row">
                        <div class="col-5" style="display: flex">
                            <div class="dropdown mt-3 ms-3">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    id="dropdownkategori" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $kategori ? ucfirst($kategori) : 'Semua' }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownkategori">
                                    <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">Semua</a></li>
                                    @foreach ($listKategori as $item)
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboard.index', ['kategori' => $item]) }}">{{ ucfirst($item) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-7 d-flex justify-content-end ">
                            <form action="{{ route('dashboard.index') }}" method="GET" class="mb-3 me-3">
                                <div class="input-group mt-3 ">
                                    <input type="text" name="search" class="form-control px-3 shadow-sm"
                                        placeholder="Search..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <img style="height: 17px; width:17px" src="{{ asset('aset/search.png') }}"
                                            alt="">
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive p-2">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th style="width: 350px;">Laporan Polisi (LP)</th>
                                    <th> Tgl Laporan
                                        <a
                                            href="{{ route('dashboard.index', [
                                                'sort' => 'tanggal_laporan',
                                                'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                                                'kategori' => request('kategori'),
                                            ]) }}">

                                            @if (request('sort') === 'tanggal_laporan' && request('direction') === 'desc')
                                                <img style="height: 14px; width:21px" src="{{ asset('aset/sort_up.png') }}"
                                                    alt="Sort Desc">
                                            @else
                                                <img style="height: 14px; width:21px"
                                                    src="{{ asset('aset/sort_down.png') }}"alt="Sort Asc">
                                            @endif
                                        </a>
                                    </th>
                                    <th style="width: 350px;">File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumens as $dokumen)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td
                                            style="max-width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $dokumen->laporan_polisi }}</td>
                                        <td>{{ $dokumen->tanggal_laporan }}</td>
                                        <td>
                                            @php
                                                $ext = pathinfo($dokumen->file, PATHINFO_EXTENSION);
                                                $icon = '';

                                                switch (strtolower($ext)) {
                                                    case 'pdf':
                                                        $icon = asset('aset/pdf.png'); // ganti sesuai nama file ikonmu
                                                        break;
                                                    case 'doc':
                                                    case 'docx':
                                                        $icon = asset('aset/doc.png');
                                                        break;
                                                    case 'xls':
                                                    case 'xlsx':
                                                        $icon = asset('aset/exl.png');
                                                        break;
                                                }
                                            @endphp

                                            <div class="file-display">
                                                <img src="{{ $icon }}" alt="{{ $ext }} icon">
                                                <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank">
                                                    {{ basename($dokumen->file) }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-center lebar">
                                            <!-- Tombol Download -->
                                            <a href="{{ asset('storage/' . $dokumen->file) }}" class="btn btn-sm ">
                                                <img src="{{ asset('aset/dwn.png') }}" alt="Download">
                                            </a>

                                            <!-- Tombol Share -->
                                            <a href="#" class="btn btn-sm ">
                                                <img src="{{ asset('aset/share.png') }}" alt="Share">
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus?');"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm " data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-id="{{ $dokumen->id }}"
                                                    data-name="{{ $dokumen->nama }}">
                                                    <img src="{{ asset('aset/delete.png') }}" alt="Hapus">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data</td>
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
    </div>



    <footer class="footer">
        <p class="p-3">Copyright 2024 - Qif Media</p>
    </footer>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4" style="font-size: 18px">
                <div class="modal-body">
                    <img class="mt-3" style="height: 107px; width: 107px" src="{{ asset('aset/deleted.png') }}"
                        alt="deleted">
                    <strong class="mt-3 d-block">Deleted File</strong>
                    <p class="mt-3">Kamu yakin ingin menghapus <strong id="fileName"></strong>?</p>

                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 py-2 mt-3" data-bs-toggle="modal"
                            data-bs-target="#deleteModalberhasil">Delete</button>
                    </form>
                    <button type="button" class="btn btn-light w-100 py-2 mt-2" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal berhasil dihapus --}}
    <div class="modal fade" id="deleteModalberhasil" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-body">
                    <img src="{{ asset('aset/deleted.png') }}" alt="delete berhasil">
                    <p class="mt-3" style="font-size: 18px">Berhasil dihapus</p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ $chart->cdn() }}"></script>
    {!! $chart->script() !!}
@endsection
