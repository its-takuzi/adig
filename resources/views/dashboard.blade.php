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
                                                <a href="#" class="open-modal" data-id="{{ $dokumen->id }}">
                                                    {{ basename($dokumen->file) }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-center lebar">
                                            <!-- Tombol Download -->
                                            <a href="{{ asset('storage/' . $dokumen->file) }}" class="btn btn-sm "
                                                target="_blank">
                                                <img src="{{ asset('aset/dwn.png') }}" alt="Download">
                                            </a>

                                            {{-- tombol share --}}
                                            <a href="#" class="btn btn-sm btn-share"
                                                data-url="{{ asset('storage/' . $dokumen->file) }}">
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
        <p class="p-3">Copyright 2025 - Qif Media</p>
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
                <div class="modal-body">
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
                        <p class="preview-rak"><i class="bi bi-geo-alt-fill me-1"></i><span id="lokasi"></span></p>
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
        <div class="modal-dialog modal-lg">
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
                                    <input type="date" class="form-control" id="edit_tanggal_laporan"
                                        name="tanggal_laporan" required>
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
                                    <input type="date" class="form-control" id="edit_tanggal_ungkap"
                                        name="tanggal_ungkap">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_file" class="form-label">Upload File (jika ingin mengganti)</label>
                                    <input type="file" class="form-control" id="edit_file" name="file"
                                        accept=".pdf,.xlsx,.docx">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <small class="text-muted">*Kosongkan file jika tidak ingin mengganti</small>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

    <script src="{{ $chart->cdn() }}"></script>
    {!! $chart->script() !!}
@endsection
