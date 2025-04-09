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
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('arsip.index') }}" class="nav-link {{ Request::is('arsip*') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i> Arsip
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rak.index') }}" class="nav-link {{ Request::is('rak*') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i> Rak
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('histori.index') }}"
                        class="nav-link {{ Request::is('histori*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> History
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('user*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i> User
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.edit') }}"
                        class="nav-link {{ Request::is('settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
                <li class="nav-item mt-auto">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            {{-- ALERT MESSAGE --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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


    @php
        $lastDokumen = \App\Models\Dokumen::orderBy('id', 'desc')->first();
    @endphp

</body>

</html>
