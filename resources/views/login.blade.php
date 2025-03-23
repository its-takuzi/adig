<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        .container-fluid {
            height: 100vh;
        }

        .login-container {
            height: 100%;
        }

        .left-side {
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .right-side {
            background: #1E58B0;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            padding: 40px;
        }

        .right-side .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
        }

        .login-btn {
            background: #1E58B0;
            color: white;
            font-weight: bold;
        }

        .login-btn:hover {
            background: #164687;
        }
    </style>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="row w-100 align-items-stretch login-container">
            <div class="col-md-8 left-side d-flex">
                <img src="{{ asset('aset/adig.png') }}" alt="Logo" class="img-fluid" style="max-width: 70%;">
            </div>
            <div class="col-md-4 right-side d-flex">
                <div class="card w-100 h-100 mt-5 mb-5">
                    <h3 class="text-center text-primary">Welcome Back!</h3>
                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label text-muted">Email</label>
                            <input type="email" id="email" name="email" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-muted">Password</label>
                            <input type="password" id="password" name="password" required class="form-control">
                        </div>
                        <button type="submit" class="btn login-btn w-100 mt-5">LOGIN</button>
                    </form>
                </div>
                <p class="text-center mt-3" style="color: white">Copyright 2024 - GM Media</p>
            </div>
        </div>
    </div>
</body>

</html>
