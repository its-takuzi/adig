<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

        .sidebar.hide {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 250px;
            width: 100%;
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

        .sidebar a.active,
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
    </style>
</head>

<body>

    <button class="btn btn-primary d-lg-none sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar d-md-block" id="sidebar">
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

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
            sidebar.classList.toggle('hide');
        }

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


    @php
        $lastDokumen = \App\Models\Dokumen::orderBy('id', 'desc')->first();
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>
