<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/farus.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            background: white;
            padding: 15px;
            height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1040;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.sidebar-hidden {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 250px;
            width: 100%;
        }

        /* Desktop: always visible */
        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(0) !important;
            }
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                flex-direction: column;
                flex-wrap: wrap;
            }

            .sidebar-toggle {
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1050;
            }
        }

        .sidebar a {
            text-decoration: none;
            color: black;
            padding: 10px;
            display: block;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background: #8BA8F5;
            color: white;
        }

        .sidebar-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            margin-bottom: 15px
        }

        [class^="sidebar-"]::before {
            display: inline-block;
            width: 24px;
            height: 24px;
            vertical-align: middle;
            margin-right: 8px;
        }

        .sidebar-home::before {
            content: url('aset/home.svg');
        }

        .sidebar-rak::before {
            content: url('aset/rak.svg');
        }

        .sidebar-arsip::before {
            content: url('aset/document-filled.svg');
        }

        .sidebar-history::before {
            content: url('aset/list-right.svg');
        }

        .sidebar-user::before {
            content: url('aset/user-1.svg');
        }

        .sidebar-setting::before {
            content: url('aset/settings.svg');
        }

        .sidebar-logout::before {
            content: url('aset/logout.svg');
        }

        .nav-link.active .sidebar-home::before {
            content: url('aset/h-white.svg');
        }

        .nav-link.active .sidebar-rak::before {
            content: url('aset/r-white.svg');
        }

        .nav-link.active .sidebar-arsip::before {
            content: url('aset/d-white.svg');
        }

        .nav-link.active .sidebar-history::before {
            content: url('aset/h-white.svg');
        }

        .nav-link.active .sidebar-user::before {
            content: url('aset/u-white.svg');
        }

        .nav-link.active .sidebar-setting::before {
            content: url('aset/s-white.svg');
        }

        .nav-link:hover .sidebar-home::before {
            content: url('aset/h-white.svg');
        }

        .nav-link:hover .sidebar-rak::before {
            content: url('aset/r-white.svg');
        }

        .nav-link:hover .sidebar-arsip::before {
            content: url('aset/d-white.svg');
        }

        .nav-link:hover .sidebar-history::before {
            content: url('aset/h-white.svg');
        }

        .nav-link:hover .sidebar-user::before {
            content: url('aset/u-white.svg');
        }

        .nav-link:hover .sidebar-setting::before {
            content: url('aset/s-white.svg');
        }

        .datepicker table tr td.day:hover,
        .datepicker table tr td.focused {
            background: #8BA8F5;
            color: #fff;
        }

        .datepicker .datepicker-days .datepicker-switch,
        .datepicker .datepicker-months .datepicker-switch,
        .datepicker .datepicker-years .datepicker-switch,
        .datepicker .datepicker-decades .datepicker-switch,
        .datepicker .datepicker-centuries .datepicker-switch {
            background-color: #2751C1;
            color: white;
            border-radius: 0;
        }

        .datepicker .prev,
        .datepicker .next {
            background-color: #2751C1;
            color: white;
        }

        .datepicker .prev:hover,
        .datepicker .next:hover {
            background-color: #8BA8F5;
            color: white;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- Tombol toggle sidebar -->
    <button class="btn btn-primary d-lg-none sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>


    <div class="d-flex">
        <nav class="sidebar d-block d-md-block sidebar-hidden" id="sidebar">
            <img src="{{ asset('aset/adig.png') }}" alt="Logo" class="img-fluid mb-4">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="sidebar-home" alt=""></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('arsip.index') }}" class="nav-link {{ Request::is('arsip*') ? 'active' : '' }}">
                        <i class="sidebar-arsip" alt=""></i> Arsip
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rak.index') }}" class="nav-link {{ Request::is('rak*') ? 'active' : '' }}">
                        <i class="sidebar-rak" alt=""></i> Rak
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('histori.index') }}"
                        class="nav-link {{ Request::is('histori*') ? 'active' : '' }}">
                        <i class="sidebar-history" alt=""></i> History
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('user*') ? 'active' : '' }}">
                        <i class="sidebar-user" alt=""></i> User
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.edit') }}"
                        class="nav-link {{ Request::is('settings*') ? 'active' : '' }}">
                        <i class="sidebar-setting" alt=""></i> Settings
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link">
                            <i class="sidebar-logout" alt=""></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- code untuk akses detail dimobile --}}
    <script>
        function updateLaporanLinkAccess() {
            const links = document.querySelectorAll('.laporan-link');
            const isMobile = window.innerWidth <= 992;

            links.forEach(link => {
                if (isMobile) {
                    // Aktifkan link
                    link.setAttribute('href', link.dataset.href);
                    link.style.pointerEvents = 'auto';
                    link.style.color = 'inherit';
                } else {
                    // Nonaktifkan link di desktop
                    link.removeAttribute('href');
                    link.style.pointerEvents = 'none';
                    link.style.color = '#000'; // tetap bisa atur warna kalau perlu
                }
            });
        }

        window.addEventListener('DOMContentLoaded', updateLaporanLinkAccess);
        window.addEventListener('resize', updateLaporanLinkAccess);
    </script>

    {{-- delete modal --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var fileId = button.getAttribute('data-id');
                    var fileName = button.getAttribute('data-name');
                    document.getElementById("fileName").textContent = fileName;

                    var form = document.getElementById("deleteForm");
                    form.action = "/dokumen/" + fileId;
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var fileId = button.getAttribute('data-id');
                    var fileName = button.getAttribute('data-name');
                    var route = button.getAttribute('data-route');

                    document.getElementById("fileName").textContent = fileName;

                    var form = document.getElementById("deleteForm");
                    form.action = route;
                });
            }
        });
    </script>


    <script>
        const currentRoute = "{{ Route::currentRouteName() }}";

        if (currentRoute === "detail.show") { // sesuaikan nama route detail dokumen
            const deleteModalBerhasil = document.getElementById('deleteModalberhasil');

            if (deleteModalBerhasil) {
                deleteModalBerhasil.addEventListener('shown.bs.modal', function() {
                    setTimeout(() => {
                        window.location.href = "{{ route('dashboard.index') }}";
                    }, 2000);
                });
            }
        }
    </script>

    {{-- fungsi share --}}
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

    {{-- validasi tanggal ungkap tidak kurang atau sama dengan tangal upload --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalLaporan = document.getElementById('tanggal_laporan');
            const tanggalUngkap = document.getElementById('tanggal_ungkap');

            tanggalLaporan.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                selectedDate.setDate(selectedDate.getDate() + 1); // +1 hari

                const minDate = selectedDate.toISOString().split('T')[0];
                tanggalUngkap.min = minDate;

                // Reset kalau nilai sebelumnya salah
                if (tanggalUngkap.value && tanggalUngkap.value < minDate) {
                    tanggalUngkap.value = '';
                }
            });
        });
    </script>


    {{-- validasi ukuran file melebihi 5mb --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const maxSize = 5 * 1024 * 1024; // 5MB
            const warning = document.createElement('div');
            warning.className = 'text-danger mt-1';
            warning.style.fontSize = '14px';

            fileInput.parentNode.appendChild(warning);

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.size > maxSize) {
                    warning.textContent = "Ukuran file melebihi 5MB.";
                    this.value = ''; // kosongkan input
                } else {
                    warning.textContent = '';
                }
            });
        });
    </script>



    @php
        $lastDokumen = \App\Models\Dokumen::orderBy('id', 'desc')->first();
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        });
    </script>

    <script>
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target) && window.innerWidth < 768) {
                sidebar.classList.add('sidebar-hidden');
            }
        });
    </script>

    {{-- fungsi drag ukuran kolom --}}
    <script src="https://cdn.jsdelivr.net/gh/alvaro-prieto/colResizable/colResizable-1.6.min.js"></script>
    <script>
        $(document).ready(function() {
            $("table").colResizable({
                liveDrag: true,
                gripInnerHtml: "<div class='grip'></div>",
                draggingClass: "dragging"
            });
        });
    </script>

</body>

<script>
    $(document).ready(function() {
        $('#tanggal_laporan').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            clearBtn: true,
            todayHighlight: true,
            startView: 2,
            maxViewMode: 2
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#edit_tanggal_laporan').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            clearBtn: true,
            todayHighlight: true,
            startView: 2,
            maxViewMode: 2
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#tanggal_ungkap').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            clearBtn: true,
            todayHighlight: true,
            startView: 2,
            maxViewMode: 2
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#edit_tanggal_ungkap').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            clearBtn: true,
            todayHighlight: true,
            startView: 2,
            maxViewMode: 2
        });
    });
</script>

</html>
