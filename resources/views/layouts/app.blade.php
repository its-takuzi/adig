<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
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
            background: #007bff;
            color: white;
        }

        .btn-category {
            width: 120px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
            <img src="{{ asset('aset/adig.png') }}" alt="Logo">
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
            @yield('content')
        </div>
    </div>


</body>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var deleteModal = document.getElementById('deleteModal');

        deleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var fileId = button.getAttribute('data-id');
            var fileName = button.getAttribute('data-name');
            document.getElementById("fileName").textContent = fileName;

            var form = document.getElementById("deleteForm");
            form.action = "/dokumen/" + fileId;
        });
    });
</script>
@php
    $lastDokumen = \App\Models\Dokumen::orderBy('id', 'desc')->first();
@endphp




</html>
