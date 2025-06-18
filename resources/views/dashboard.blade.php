@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mt-1 align-items-center">
        <h3 class="judul">DASHBOARD</h3>
        <div class=" photo-profile d-flex align-items-center m-3">
            <img src="{{ asset('/storage/profile/' . (Auth::user()->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                class="rounded-circle" width="40" height="40"
                style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
            <span class="me-2">{{ auth()->user()->name }}</span>
        </div>
    </div>
    <div class="container-fluid bg-dashboard">
        {{-- isi bagian card bagian atas --}}
        <div class="dashboard-container">
            <div class="d-flex flex-column custom-responsive-row gap-4">
                <div class="card-item">
                    <div>
                        <div class="text tulisan_dokumen">Total Dokumen</div>
                        <div class="number tulisan_number">
                            {{ $totalDokumen }}
                        </div>
                    </div>
                    <div class="icon">
                        <img class="icon_dashboard" src="{{ asset('aset/svgdokumen.svg') }}" alt="Dokumen Icon">
                    </div>
                </div>

                <div class="card-item">
                    <div>
                        <div class="text tulisan_dokumen">Total Size</div>
                        <div class="number tulisan_number">
                            {{ number_format($totalSize, 2) }} MB
                        </div>
                    </div>
                    <div class="icon">
                        <img class="icon_dashboard" src="{{ asset('aset/svgsize.svg') }}" alt="Dokumen size">
                    </div>
                </div>
            </div>

            {{-- Chart Card --}}
            <div class="">
                <div class="card-item-grafik p-4 position-relative">
                    {{-- Dropdown Tahun di kanan atas dalam card --}}
                    <div class="dropdown position-absolute" style="top: 0; right: 0; z-index: 10;">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle me-2 mt-2" type="button"
                            id="dropdownTahun" data-bs-toggle="dropdown" aria-expanded="false"
                            style="font-size: 13px; font-weight: 400;">
                            @if (count($tahunFilter) > 0)
                                {{ implode(' - ', [min($tahunFilter->toArray()), max($tahunFilter->toArray())]) }}
                            @else
                                Pilih Tahun
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownTahun">
                            @foreach ($groupedTahun as $group)
                                @php
                                    $params = http_build_query(['tahun' => $group->toArray()]);
                                    $url = route('dashboard.index') . '?' . $params;
                                @endphp
                                <li>
                                    <a class="dropdown-item" href="{{ $url }}">
                                        {{ $group->max() }} - {{ $group->min() }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Chart --}}
                    <canvas id="chartDokumen" class="w-100"></canvas>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-12 p-3 justify-content-center">
                <div class="card-table w-100 h-100" style="font-size: 14px">
                    <div class="row flex-wrap mb-3">
                        {{-- Dropdown Kategori --}}
                        <div class="col-md-5 col-12 d-flex justify-content-start">
                            <div class="dropdown mt-3 ms-md-2 ms-0 w-100">
                                <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button"
                                    id="dropdownjenisSurat" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="font-size: 14px; font-weight: 400; color:black">
                                    {{ $jenis_surat ? ucfirst($jenis_surat) : 'Semua' }}
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownjenisSurat">
                                    <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">Semua</a></li>
                                    @foreach ($listJenisSurat as $item)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('dashboard.index', ['jenis_surat' => $item]) }}">
                                                {{ ucfirst($item) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="col-md-7 col-12 d-flex justify-content-md-end justify-content-start">
                            <form action="{{ route('dashboard.index') }}" method="GET" class="mt-3 w-100 d-flex"
                                style="max-width: 100%; margin-left: auto;">
                                <div class="input-group shadow-sm d-flex flex-wrap">
                                    <input type="text" name="search" class="form-control px-3 flex-grow-1"
                                        placeholder="Search..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <img style="height: 17px; width:17px" src="{{ asset('aset/searchsvg.svg') }}"
                                            alt="">
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive d-none d-lg-block p-2">
                        <table class="table table-bordered table-striped table-hover"
                            style="table-layout: fixed; width: 100%;">
                            <thead class="" style="font-weight: 600 ">
                                <tr>
                                    <th class="nomor-tabel" style=" width:3.438rem">No</th>
                                    <th class="lapor-polisi-tabel  judul-laporan-polisi" style="width:21rem">Laporan Polisi
                                        (LP)</th>
                                    <th class="tgl-laporan-tabel" style="width:11.875rem"> Tgl Laporan
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
                                    <th class="file-tabel" style="width:15.688rem">File</th>
                                    <th class="action-tabel" style="width:8.438rem">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumens as $dokumen)
                                    <tr>
                                        <td class="nomor-tabel">{{ $loop->iteration }}</td>
                                        <td class="lapor-polisi-tabel"
                                            style="max-width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <a href="{{ route('dokumen.show', $dokumen->id) }}"
                                                class="text-decoration-none d-inline-block laporan-link"
                                                data-href="{{ route('dokumen.show', $dokumen->id) }}"
                                                style="color: inherit;">
                                                {{ $dokumen->laporan_polisi }}
                                            </a>
                                        </td>
                                        <td class="tgl-laporan-tabel">{{ $dokumen->tanggal_laporan }}</td>
                                        <td class="file-tabel">
                                            @php
                                                $ext = pathinfo($dokumen->file, PATHINFO_EXTENSION);
                                                $icon = '';

                                                switch (strtolower($ext)) {
                                                    case 'pdf':
                                                        $icon = asset('aset/svgpdf.svg'); // ganti sesuai nama file ikonmu
                                                        break;
                                                    case 'doc':
                                                    case 'docx':
                                                        $icon = asset('aset/scgdoc.svg');
                                                        break;
                                                    case 'xls':
                                                    case 'xlsx':
                                                        $icon = asset('aset/scgexl.svg');
                                                        break;
                                                }
                                            @endphp

                                            <div class="file-display">
                                                <img src="{{ $icon }}" alt="{{ $ext }} icon">
                                                <a href="#" class="open-modal" data-id="{{ $dokumen->id }}">
                                                    {{ basename($dokumen->file) }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="action-tabel"
                                            style="padding: 0; text-align: center; vertical-align: middle;">
                                            <div
                                                style="display: flex; gap: 4px; justify-content: center; align-items: center; height: 100%;">
                                                <!-- Tombol Download -->
                                                <a href="{{ asset('storage/' . $dokumen->file) }}" class="btn btn-sm"
                                                    style="padding: 0; margin: 0;" target="_blank">
                                                    <img src="{{ asset('aset/dwnsvg.svg') }}" alt="Download"
                                                        style="display: block; height: 33px;">
                                                </a>

                                                {{-- tombol share --}}
                                                <a href="#" class="btn btn-sm btn-share"
                                                    data-url="{{ asset('storage/' . $dokumen->file) }}">
                                                    <img src="{{ asset('aset/sharesvg.svg') }}" alt="Share">
                                                </a>

                                                <!-- Tombol Hapus -->
                                                @if (auth()->user()->role === 'admin')
                                                    <form action="{{ route('dokumen.destroy', $dokumen->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus?');"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm"
                                                            style="padding: 0; margin: 0;" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal" data-id="{{ $dokumen->id }}"
                                                            data-name="{{ $dokumen->nama }}"
                                                            data-route="{{ route('dokumen.destroy', $dokumen->id) }}">
                                                            <img src="{{ asset('aset/dltsvg.svg') }}" alt="Hapus"
                                                                style="display: block; height: 33px;">
                                                        </button>
                                                    </form>
                                                @else
                                                    <span>

                                                    </span>
                                                @endif
                                            </div>
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
                            <p class="" style="font-size: 14px">
                                Showing {{ $dokumens->firstItem() }} to {{ $dokumens->lastItem() }}
                                <span style="color: #B0B2B4;">
                                    of {{ $dokumens->total() }} entries
                                </span>
                            </p>
                            {{ $dokumens->links() }}
                        </div>
                    </div>

                    {{-- tampilan mobile --}}
                    <div class="d-block d-lg-none p-2">
                        @forelse($dokumens as $dokumen)
                            <a href="{{ route('dokumen.show', $dokumen->id) }}" class="text-decoration-none">
                                <div class="mb-3 rounded-3 mobile-card" style="background-color: #F3F6FF">
                                    <div class=" p-2 d-flex justify-content-between align-items-center">
                                        <div class="fw-medium" style="font-size: 0.95rem; color:black">
                                            {{ Str::limit($dokumen->laporan_polisi, 35, '...') }}
                                        </div>
                                        <div style="color: #7B7FFD; font-size: 1.2rem;">
                                            <img src="{{ asset('aset/forward.svg') }}"
                                                style="z-index: 100; margin-top :20px">
                                        </div>
                                    </div>
                                    <div class="text-muted" style="font-size: 0.85rem; padding-left:0.5rem">
                                        {{ \Carbon\Carbon::parse($dokumen->tanggal_laporan)->format('d-m-Y') }}
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center text-muted">Tidak ada data</div>
                        @endforelse

                        <div class="d-flex justify-content-center mt-3">
                            {{ $dokumens->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <footer class="footer">
            <p class="">Copyright 2025 - Qif Media</p>
        </footer>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4" style="font-size: 18px">
                <div class="modal-body">
                    <img class="mt-3" style="height: 107px; width: 107px" src="{{ asset('aset/deleted.png') }}"
                        alt="deleted">
                    <strong class="mt-3 d-block">Deleted File</strong>
                    <p class="mt-3">Kamu yakin ingin menghapus <strong id="fileName"></strong>?</p>

                    <div class="row">
                        <div class="col-md-6">
                            <form id="deleteForm" method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light border border-dark w-100 py-2 mt-2"
                                    data-bs-toggle="modal" data-bs-target="#deleteModalberhasil">Delete</button>
                            </form>
                        </div>
                        <div class="col-md-6"> <button type="button" class="btn  btn-danger w-100 py-2 mt-2"
                                data-bs-dismiss="modal">Cancel</button></div>
                    </div>
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

    {{-- modal preview data --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered " style=" width: 497px">
            <div class="modal-content rounded-5 shadow ">
                <div class="modal-header rounded-top-5 text-white"
                    style="background-color: #2751C1;height: 47px; width: 497px">
                    <p class="modal-title ms-3" style="font-size: 18px; color:#FFFFFF">Detail Dokumen</p>
                    <button type="button" class="btn-close btn-close-form me-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body ms-3 me-3">
                    <div id="loading">Memuat data...</div>
                    <div id="modalContent" style="display: none;">
                        <h6 id="noSurat" style="font-size: 16px" class="mb-3 text-uppercase"></h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="preview-judul">Jenis Laporan</label>
                                <p class="preview-isi" id="jenisLaporan"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="preview-judul">Jenis Surat</label>
                                <p class="preview-isi" id="jenisSurat"></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="preview-judul">Tgl Laporan</label>
                                <p class="preview-isi" id="tglLapor"></p>
                            </div>

                            <div class="col-md-6">
                                <label class="preview-judul">Tgl Ungkap</label>
                                <p class="preview-isi" id="tglUngkap"></p>
                            </div>
                        </div>
                        <p class="preview-rak"><i class="bi bi-geo-alt-fill me-1"></i><span id="lokasi"></span>
                        </p>
                        <br>
                        <div class="row">
                            <label class="preview-judul">Diupload oleh</label>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <img id="fotoUploader" class="rounded-circle me-3" width="48" height="48">
                                    <div>
                                        <strong id="namaUploader"></strong><br>
                                        <i class="bi bi-calendar3 me-1"></i><span id="uploadedAt"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mt-4 d-flex justify-content-end gap-2">
                                    <a href="#" id="viewBtn" class="btn btn-preview btn-sm">View</a>
                                    <a href="#" id="editBtn" class="btn btn-preview btn-sm">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Berkas -->
    <div class="modal fade" id="modalEditBerkas" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!-- Header Modal -->
                <div class="modal-header" style="background-color: #2751C1; color: white">
                    <h5 class="modal-title" id="modalEditLabel">Edit Berkas</h5>
                    <button type="button" class="btn-close btn-close-form" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body Modal -->
                <div class="modal-body">
                    <form id="formEditDokumen" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" id="edit_dokumen_id" name="dokumen_id">

                        <div class="row">
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="edit_laporan_polisi" class="form-label">Nomor LP</label>
                                    <input type="text" class="form-control" id="edit_laporan_polisi" readonly
                                        name="laporan_polisi">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="edit_pelapor" class="form-label">Pelapor</label>
                                    <select class="form-select" id="edit_pelapor" name="pelapor" required>
                                        <option value="tni/polisi">A (Polisi/TNI)</option>
                                        <option value="warga">B (Warga)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_tanggal_laporan" class="form-label">Tgl Laporan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="edit_tanggal_laporan"
                                            name="tanggal_laporan" placeholder="dd/mm/yyyy" required>
                                        <img src="{{ asset('aset/pickdate.svg') }}" alt="calendar"
                                            style="height: 40px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Jenis Laporan</label>
                                <div class="d-flex gap-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kategori" id="edit_curas"
                                            value="curas">
                                        <label class="form-check-label" for="edit_curas">CURAS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kategori" id="edit_curat"
                                            value="curat">
                                        <label class="form-check-label" for="edit_curat">CURAT</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kategori"
                                            id="edit_curanmor" value="curanmor">
                                        <label class="form-check-label" for="edit_curanmor">CURANMOR</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_jenis_surat" class="form-label">Jenis Surat</label>
                                    <select class="form-select" id="edit_jenis_surat" name="jenis_surat" required>
                                        <option value="" disabled selected>Pilih jenis surat</option>
                                        <option value="tahap2">Tahap 2</option>
                                        <option value="sp3">Sp3</option>
                                        <option value="RJ">RJ</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_rak_id" class="form-label">Rak Penyimpanan</label>
                                    <select class="form-select" id="edit_rak_id" name="rak_id" required>
                                        @foreach ($listRak as $rak)
                                            <option value="{{ $rak->id }}">{{ $rak->nama_rak }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_tanggal_ungkap" class="form-label">Tgl Ungkap</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="edit_tanggal_ungkap"
                                            name="tanggal_ungkap" placeholder="dd/mm/yyyy">
                                        <img src="{{ asset('aset/pickdate.svg') }}" alt="calendar"
                                            style="height: 40px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_file" class="form-label">Upload File (jika ingin
                                        mengganti)</label>
                                    <input type="file" class="form-control" id="edit_file" name="file"
                                        accept=".pdf,.xlsx,.docx">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <small class="text-muted">*Kosongkan file jika tidak ingin mengganti</small>
                            <button type="submit" class="btn "
                                style="background-color: #08B123; color:white">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- script untuk modal preview data --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.open-modal');
            const userRole = "{{ Auth::user()->role }}";

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const id = this.getAttribute('data-id');
                    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                    modal.show();

                    // Reset isi & tampilkan loading
                    document.getElementById('loading').style.display = 'block';
                    document.getElementById('modalContent').style.display = 'none';

                    fetch(`/arsip/${id}/detail`)
                        .then(response => response.json())
                        .then(data => {
                            if (userRole !== 'admin') {
                                document.getElementById('editBtn').style.display = 'none';
                            } else {
                                document.getElementById('editBtn').style.display =
                                    'inline-block';
                            }
                            document.getElementById('noSurat').textContent = data
                                .laporan_polisi;
                            document.getElementById('jenisLaporan').textContent = data.kategori;
                            document.getElementById('jenisSurat').textContent = data
                                .jenis_surat;
                            document.getElementById('tglLapor').textContent = data
                                .tanggal_laporan;
                            document.getElementById('tglUngkap').textContent = data
                                .tanggal_ungkap;
                            document.getElementById('lokasi').textContent = data.rak;
                            document.getElementById('namaUploader').textContent = data.uploader
                                .nama;
                            document.getElementById('uploadedAt').textContent = data
                                .uploaded_at;
                            document.getElementById('fotoUploader').src = data.uploader
                                .foto_url;

                            document.getElementById('viewBtn').href = `/storage/${data.file}`;
                            document.getElementById('viewBtn').setAttribute('target', '_blank');

                            document.getElementById('editBtn').setAttribute('data-id', id);

                            document.getElementById('loading').style.display = 'none';
                            document.getElementById('modalContent').style.display = 'block';
                        })
                        .catch(err => {
                            document.getElementById('loading').textContent =
                                'Gagal memuat data.';
                            console.error(err);
                        });

                });
            });
        });
        document.getElementById('editBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');

            fetch(`/arsip/${id}/detail`)
                .then(response => response.json())
                .then(data => {
                    const modal = new bootstrap.Modal(document.getElementById('modalEditBerkas'));
                    modal.show();

                    document.getElementById('edit_dokumen_id').value = id;
                    document.getElementById('formEditDokumen').action = `/arsip/${id}`;
                    document.getElementById('edit_laporan_polisi').value = data.laporan_polisi;
                    document.getElementById('edit_pelapor').value = data.laporan_polisi.includes("/A/") ?
                        'tni/polisi' : 'warga';
                    document.getElementById('edit_tanggal_laporan').value = data.tanggal_laporan;
                    document.getElementById('edit_jenis_surat').value = data.jenis_surat;
                    document.getElementById('edit_tanggal_ungkap').value = data.tanggal_ungkap || '';

                    document.getElementById(`edit_${data.kategori.toLowerCase()}`).checked = true;

                    document.getElementById('edit_rak_id').value = Array.from(document.getElementById(
                        'edit_rak_id').options).find(
                        opt => opt.text === data.rak
                    )?.value || '';
                });
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true,
                    position: 'top-end',
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chartDokumen').getContext('2d');
        const chartDokumen = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($categories),
                datasets: [{
                        label: 'CURAS',
                        data: @json($curasData),
                        backgroundColor: '#FFC107'

                    },
                    {
                        label: 'CURAT',
                        data: @json($curatData),
                        backgroundColor: '#DC3545'
                    },
                    {
                        label: 'CURANMOR',
                        data: @json($curanmorData),
                        backgroundColor: '#28A745'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 20
                        }
                    },
                    title: {
                        display: true,
                        text: 'Grafik Jumlah Dokumen'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@endsection
