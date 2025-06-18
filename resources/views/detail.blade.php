@extends('layouts.app')


@section('content')
    <div id="halaman-detail" hidden></div>

    <div class="d-flex justify-content-between mt-1 align-items-center">
        <h3 class="judul">DETAIL DOKUMEN</h3>
        <div class="photo-profile d-flex align-items-center m-3">
            <img src="{{ asset('/storage/profile/' . (Auth::user()->pp ?? 'default.jpg')) }}" alt="Foto Profil"
                class="rounded-circle" width="40" height="40"
                style="object-fit: cover; aspect-ratio: 1/1; margin-right: 5px">
            <span class="me-2">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="bg-detail">
        <div class="header-detail d-flex">
            <div class="container py-4">
                <div class="d-flex align-items-center justify-content-between text-white">
                    <a href="{{ url()->previous() }}" class="">
                        <img src="{{ asset('/aset/back-button.svg') }}" alt="Kembali">
                    </a>
                    <h6 class="flex-grow-1 text-center m-0">DETAIL DOKUMEN</h6>
                    <div style="width: 1.5rem;"></div> <!-- Placeholder biar teks tetap center -->
                </div>
                <div class="text-white" style="margin-top: 45px">
                    <p class="mb-0 text-center">{{ $dokumen->laporan_polisi }}</p>
                </div>
            </div>
        </div>

        <div class="isi-detail">
            <div class="container" style="font-size:16px; margin-top:33px">
                <div class="row text-md-start" style="padding-left:30px;">
                    <div class="col-6 mb-3">
                        <p class="text-muted mb-1">Jenis Laporan</p>
                        <p class=" mb-0">
                        <p class=" mb-0">{{ $dokumen->kategori }}</p>
                        </p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="text-muted mb-1">Jenis Surat</p>
                        <p class=" mb-0">
                        <p class=" mb-0">{{ $dokumen->jenis_surat }}</p>
                        </p>
                    </div>
                    <div class="col-6 mb-3" style="margin-top: 33px">
                        <p class="text-muted mb-1">Tgl Laporan</p>
                        <p class=" mb-0">
                        <p class=" mb-0">{{ \Carbon\Carbon::parse($dokumen->tanggal_laporan)->format('d/m/Y') }}</p>
                        </p>
                    </div>
                    <div class="col-6 mb-3" style="margin-top: 33px">
                        <p class="text-muted mb-1">Tgl Ungkap</p>
                        <p class=" mb-0">
                        <p class=" mb-0">{{ \Carbon\Carbon::parse($dokumen->tanggal_ungkap)->format('d/m/Y') }}</p>
                        </p>
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="d-flex align-items-center " style="margin-top: 33px; padding-left:30px;">
                    <i class="bi bi-geo-alt fs-5 "></i>
                    <span class="">
                        <p class="preview-rak">{{ $dokumen->rak->nama_rak ?? '-' }}</p>
                    </span>
                </div>

                <!-- Diunggah oleh -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mt-4 ps-4">
                    <div class="d-flex align-items-center">
                        <!-- Foto Uploader -->
                        <img src="{{ $dokumen->user->pp ? asset('storage/profile/' . $dokumen->user->pp) : 'https://via.placeholder.com/40' }}"
                            class="rounded-circle me-3" width="50" height="50" alt="Uploader">

                        <!-- Informasi Uploader -->
                        <div class="me-4 ">
                            <p class="text-muted mb-0 small">Diupload oleh</p>
                            <p class="mb-0 ">{{ $dokumen->user->name ?? '-' }}</p>
                        </div>

                        <!-- Tanggal Upload -->
                        <div class="d-flex align-items-center text-muted">
                            <i class="bi bi-upload me-2"></i>
                            <span>{{ $dokumen->created_at?->format('d M Y') ?? '-' }}</span>

                        </div>
                    </div>
                </div>


                <!-- Tombol aksi -->
                <div class="d-flex justify-content-center gap-2 flex-wrap" style="margin-top: 61px">
                    <!-- Tombol edit -->
                    <a href="#" class="btn-sm btn-edit" data-id="{{ $dokumen->id }}">
                        <img src="{{ asset('aset/editttt.svg') }}" alt="edit" style="display: block; height: 33px;">
                    </a>

                    <!-- Tombol Download -->
                    <a href="{{ asset('storage/' . $dokumen->file) }}" class="btn btn-sm" style="padding: 0; margin: 0;"
                        target="_blank">
                        <img src="{{ asset('aset/dwnsvg.svg') }}" alt="Download" style="display: block; height: 33px;">
                    </a>

                    {{-- tombol share --}}
                    <a href="#" class="btn btn-sm btn-share" style="padding: 0; margin: 0;"
                        data-url="{{ asset('storage/' . $dokumen->file) }}">
                        <img src="{{ asset('aset/sharesvg.svg') }}" alt="Share">
                    </a>
                    <!-- Tombol Hapus -->
                    @if (auth()->user()->role === 'admin')
                        <form action="{{ route('detail.hapus', $dokumen->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm" style="padding: 0; margin: 0;" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-id="{{ $dokumen->id }}"
                                data-name="{{ $dokumen->nama }}" data-route="{{ route('detail.hapus', $dokumen->id) }}">
                                <img src="{{ asset('aset/dltsvg.svg') }}" alt="Hapus"
                                    style="display: block; height: 33px;">
                            </button>
                        </form>
                    @else
                        <span>

                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <footer class="footer-detail d-flex justify-content-center my-5">
        <p class="mb-4" style="color: #2751C1">Copyright 2025 - Qif Media</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shareButtons = document.querySelectorAll('.btn-share');

            shareButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-url');

                    navigator.clipboard.writeText(url).then(() => {
                        // Pakai SweetAlert2
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Link berhasil disalin!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }).catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Ups! Gagal menyalin link.',
                        });
                    });
                });
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
                                <button type="submit" class="btn btn-light border border-dark w-100 py-2 mt-2">
                                    Delete
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6"> <button type="button" class="btn  btn-danger w-100 py-2 mt-2"
                                data-bs-dismiss="modal">Cancel</button></div>
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
                            <!-- Nomor LP: tampil pertama di mobile, tetap kiri di desktop -->
                            <div class="col-12 col-md-3 order-1 order-md-1">
                                <div class="mb-3">
                                    <label for="edit_laporan_polisi" class="form-label">Nomor LP</label>
                                    <input type="text" class="form-control" id="edit_laporan_polisi" readonly
                                        name="laporan_polisi">
                                </div>
                            </div>

                            <!-- Pelapor: tampil kedua di mobile, tengah di desktop -->
                            <div class="col-12 col-md-3 order-2 order-md-2">
                                <div class="mb-3">
                                    <label for="edit_pelapor" class="form-label">Pelapor</label>
                                    <select class="form-select" id="edit_pelapor" name="pelapor" required>
                                        <option value="tni/polisi">A (Polisi/TNI)</option>
                                        <option value="warga">B (Warga)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tgl Laporan: tampil ketiga di mobile, kanan di desktop -->
                            <div class="col-12 col-md-6 order-3 order-md-3">
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
                            <div class="col-12 col-md-6 order-1 order-md-1">
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
                            <div class="col-12 col-md-6 order-2 order-md-2">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                const editBtn = e.target.closest('.btn-edit');
                if (!editBtn) return;

                e.preventDefault();
                const id = editBtn.getAttribute('data-id');

                fetch(`/arsip/${id}/detail`)
                    .then(response => response.json())
                    .then(data => {
                        const modal = new bootstrap.Modal(document.getElementById('modalEditBerkas'));
                        modal.show();

                        // Isi form edit
                        document.getElementById('edit_dokumen_id').value = id;
                        document.getElementById('formEditDokumen').action = `/arsip/${id}`;
                        document.getElementById('edit_laporan_polisi').value = data.laporan_polisi;
                        document.getElementById('edit_pelapor').value = data.laporan_polisi.includes(
                                "/A/") ?
                            'tni/polisi' : 'warga';
                        document.getElementById('edit_tanggal_laporan').value = data.tanggal_laporan;
                        document.getElementById('edit_jenis_surat').value = data.jenis_surat;
                        document.getElementById('edit_tanggal_ungkap').value = data.tanggal_ungkap ||
                            '';

                        // Radio kategori
                        const radioId = `edit_${data.kategori.toLowerCase()}`;
                        const radioInput = document.getElementById(radioId);
                        if (radioInput) radioInput.checked = true;

                        // Rak penyimpanan berdasarkan teks rak
                        const rakSelect = document.getElementById('edit_rak_id');
                        const rakOption = Array.from(rakSelect.options).find(opt => opt.text === data
                            .rak);
                        rakSelect.value = rakOption ? rakOption.value : '';
                    })
                    .catch(err => {
                        console.error('Gagal memuat data edit:', err);
                        alert('Terjadi kesalahan saat memuat data. Coba lagi.');
                    });
            });
        });
    </script>
@endsection
