@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-1 align-items-center">
            <h3 class="m-3">ARSIP</h3>
            <div class="d-flex align-items-center m-3">
                <img src="{{ asset('/storage/profile/' . (Auth::user()->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                    class="rounded-circle" width="40" height="40"
                    style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
                <span class="me-2">{{ auth()->user()->name }}</span>
            </div>
        </div>

        <!-- Kategori -->
        <div class="kategori-container mt-3">
            <a href="{{ route('arsip.index', ['kategori' => 'curas']) }}"
                class="btn btn-category {{ $kategori == 'curas' ? 'btn-primary' : 'btn-secondary' }}">
                <i class="fas fa-archive"></i> CURAS
            </a>

            <a href="{{ route('arsip.index', ['kategori' => 'curat']) }}"
                class="btn btn-category {{ $kategori == 'curat' ? 'btn-primary' : 'btn-secondary' }}">
                <i class="fas fa-archive"></i> CURAT
            </a>

            <a href="{{ route('arsip.index', ['kategori' => 'curanmor']) }}"
                class="btn btn-category {{ $kategori == 'curanmor' ? 'btn-primary' : 'btn-secondary' }}">
                <i class="fas fa-archive"></i> CURANMOR
            </a>

            <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahBerkas">
                <img style="height: 75px ; width:75px" src="{{ asset('aset/add.png') }}" alt="">
            </button>

        </div>


        <div class="row">
            <div class="col-5" style="display: flex">
                <div class="dropdown mt-3 ms-3">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdowntahun"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ request('tahun') ? request('tahun') : 'Semua Tahun' }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdowntahun">
                        <li><a class="dropdown-item" href="{{ route('arsip.index') }}">Semua Tahun</a></li>
                        @foreach ($listTahun as $tahun)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('arsip.index', array_merge(request()->except('page'), ['tahun' => $tahun])) }}">
                                    {{ $tahun }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="col-7 d-flex justify-content-end ">
                <form action="{{ route('arsip.index') }}" method="GET" class="mb-3 me-3">
                    <div class="input-group mt-3 ">
                        <input type="text" name="search" class="form-control px-3 shadow-sm" placeholder="Search..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <img style="height: 17px; width:17px" src="{{ asset('aset/search.png') }}" alt="">
                        </button>
                    </div>
                </form>
            </div>
        </div>



        <!-- Table -->
        <table class="table table-bordered table-striped table-hover ">
            <thead class="">
                <tr>
                    <th>No</th>
                    <th style="width: 350px;">Laporan Polisi (LP)</th>
                    <th> Tgl Laporan
                        <a
                            href="{{ route('arsip.index', [
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
                    <tr style="font-size: 14px">
                        <td>{{ $loop->iteration }}</td>
                        <td style="max-width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
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
                        <td class="text-center">
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
                                onsubmit="return confirm('Yakin ingin menghapus?');" style="display: inline;">
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
                Showing {{ $dokumens->firstItem() }} to {{ $dokumens->lastItem() }} of {{ $dokumens->total() }}
                entries
            </p>
            {{ $dokumens->links() }}
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

    <!-- Modal Input Berkas -->
    <div class="modal fade" id="modalTambahBerkas" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Header Modal -->
                <div class="modal-header" style="background-color: #2751C1; color: white">
                    <h5 class="modal-title" id="modalLabel">Tambah Berkas</h5>
                    <button type="button" class="btn-close btn-close-form" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body Modal -->
                <div class="modal-body">
                    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @php
                            $lastDokumen = \App\Models\Dokumen::orderBy('id', 'desc')->first();
                        @endphp
                        <div class="row">
                            <div class="col-3">
                                <!-- Laporan Polisi -->
                                <div class="mb-3">
                                    <label for="laporan_polisi" class="form-label ">Nomor LP</label>
                                    <input type="string" class="form-control" id="laporan_polisi" name="laporan_polisi"
                                        placeholder="Nomor LP" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <!-- Pelapor -->
                                <div class="mb-3">
                                    <label for="pelapor" class="form-label ">Pelapor</label>
                                    <select class="form-select" id="pelapor" name="pelapor" required>
                                        <option value="" disabled selected>Pilih Pelapor</option>
                                        <option value="tni/polisi">{{ 'A (Polisi/TNI)' }}</option>
                                        <option value="warga">{{ 'B (Warga)' }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Tanggal Laporan -->
                                <div class="mb-3">
                                    <label for="tanggal_laporan" class="form-label ">Tgl Laporan</label>
                                    <input type="date" class="form-control" id="tanggal_laporan"
                                        name="tanggal_laporan" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <!-- Kategori Laporan -->
                                <div class="mb-3">
                                    <label class="form-label ">Jenis Laporan</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori"
                                                id="curas" value="curas" required>
                                            <label class="form-check-label" for="curas">CURAS</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori"
                                                id="curat" value="curat" required>
                                            <label class="form-check-label" for="curat">CURAT</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori"
                                                id="curanmor" value="curanmor" required>
                                            <label class="form-check-label" for="curanmor">CURANMOR</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- jenis surat -->
                                <div class="mb-3">
                                    <label for="jenis_surat" class="form-label">jenis Surat</label>
                                    <select class="form-select" id="jenis_surat" name="jenis_surat" required>
                                        <option value="" disabled selected>Pilih jenis surat</option>
                                        <option value="tahap2">Tahap 2</option>
                                        <option value="sp3">SP3</option>
                                        <option value="rj">RJ</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <!-- Rak Penyimpanan -->
                                @php
                                    $listRak = \App\Models\Rak::all();
                                @endphp

                                <div class="mb-3">
                                    <label for="rak_id" class="form-label">Rak Penyimpanan</label>
                                    <select class="form-select" id="rak_id" name="rak_id" required>
                                        <option value="" disabled selected>Pilih RAK</option>
                                        @foreach ($listRak as $rak)
                                            <option value="{{ $rak->id }}">{{ $rak->nama_rak }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Tanggal Ungkap -->
                                <div class="mb-3">
                                    <label for="tanggal_ungkap" class="form-label">Tgl
                                        Ungkap</label>
                                    <input type="date" class="form-control" id="tanggal_ungkap"
                                        name="tanggal_ungkap">
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Upload File -->
                                <div class="mb-3">
                                    <label for="file" class="form-label ">Pilih File</label>
                                    <input type="file" class="form-control" id="file" name="file" required>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between align-items-center w-100 mt-3">
                            <div class="text-start">
                                <small class="text-muted">
                                    *File harus berformat PDF, DOC, atau XLSX<br>
                                    *Ukuran Maksimal 5 Mb
                                </small>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Preview -->
    <div class="modal fade" id="modalPreview" tabindex="-1" aria-labelledby="previewLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Header Modal -->
                <div class="modal-header" style="background-color: #2751C1; color: white">
                    <h5 class="modal-title" id="previewLabel">Detail dokumen</h5>
                    <button type="button" class="btn-close btn-close-form" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session('previewData'))
                        @php $dokumen = session('previewData'); @endphp
                        <p><strong>{{ $dokumen->laporan_polisi }}</strong></p>
                        <div class="row">
                            <div class="col-6">
                                <p>Jenis Laporan:</p>
                                <p><strong>{{ strtoupper($dokumen->kategori) }}</strong></p>
                            </div>
                            <div class="col-6">
                                <p>Jenis Surat:</p>
                                <p><strong>{{ ucfirst($dokumen->jenis_surat) }}</strong></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>Tgl Laporan:</p>
                                <p> <strong>{{ \Carbon\Carbon::parse($dokumen->tanggal_laporan)->format('d/m/Y') }}</strong>
                                </p>
                            </div>
                            <div class="col-6">
                                <p>Tgl Ungkap:</p>
                                <p>
                                    <strong>
                                        {{ $dokumen->tanggal_ungkap ? \Carbon\Carbon::parse($dokumen->tanggal_ungkap)->format('d/m/Y') : '-' }}</strong>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p> <img style="height: 40px" src="{{ asset('aset/rak.png') }}" class="me-2"
                                        alt=""><i class="bi bi-folder"></i>
                                    {{ strtoupper($dokumen->rak_penyimpanan) }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p>Diunggah oleh:</p>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ 'test' }}&background=random"
                                        class="rounded-circle me-2" width="40" height="40">
                                    <div>
                                        <strong>test</strong><br>
                                        <small>{{ now()->format('d F Y') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-5">
                                    <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank"
                                        class="btn btn-success">View</a>
                                    <a href="#" class="btn btn-success">Edit</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (session('previewData'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('modalPreview'));
                myModal.show();
            });
        </script>
    @endif
@endsection
