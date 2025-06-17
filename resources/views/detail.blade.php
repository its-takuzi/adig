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
                <div class="d-flex align-items-center justify-content-between  flex-wrap gap-2"
                    style="margin-top: 35px; padding-left:30px;">
                    <div class="d-flex align-items-center">
                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" width="40" height="40"
                            alt="Uploader">
                        <div>
                            <p class="text-muted mb-0 small">Diupload oleh</p>
                            <p class=" mb-0">
                            <p class=" mb-0">{{ $dokumen->user->name ?? '-' }}</p>
                            </p>
                        </div>
                        <div class="d-flex align-items-center ">
                            <i class="bi bi-upload me-2"></i>
                            <span>18 Juni 2024</span>
                        </div>
                    </div>

                </div>

                <!-- Tombol aksi -->
                <div class="d-flex justify-content-center gap-2 flex-wrap" style="margin-top: 61px">
                    <!-- Tombol edit -->
                    <a href="" class="btn btn-sm" style="padding: 0; margin: 0;" target="_blank">
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
@endsection
