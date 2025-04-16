<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        .gradient-we {
            background: linear-gradient(to right, #93c5fd, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-outline {
            border: 1px solid transparent;
            background-image: linear-gradient(#fff, #fff), linear-gradient(to right, rgba(128, 128, 128, 0.4), rgba(128, 128, 128, 0.8));
            background-origin: border-box;
            background-clip: padding-box, border-box;
        }

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
            padding-right: 40px;
            padding-left: 40px;
        }

        .right-side .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
        }

        .login-btn {
            background: linear-gradient(to right, #11C1EF, #1179EF);
            color: white;
            font-weight: bold;
        }

        .login-btn:hover {
            background: #8BA8F5;
            color: white;
        }

        .gradient-text {
            background: linear-gradient(to right, #11C1EF, #1179EF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="row w-100 align-items-stretch login-container">
            <div class="col-md-8 left-side d-flex ">
                <img src="{{ asset('aset/ADIG-1.svg') }}" alt="Logo" class="img-fluid" style="max-width: 100%;">
            </div>
            <div class="col-md-4 right-side d-flex justify-content-center align-items-center">
                <div class="card h-100 mt-5 mb-5">
                    <h2 class="text-2xl font-bold text-center">
                        <span class="gradient-we">We</span><span class="text-blue-600">lcome back!</span>
                    </h2>
                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf
                        <div class="relative mt-5">
                            <img src="{{ asset('aset/email.svg') }}" alt="Email Icon"
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 brightness-50">
                            <input type="email" id="email" name="email" required
                                placeholder="youremail@gmail.com"
                                class="w-full pl-10 pr-4 py-2 rounded-lg gradient-outline focus:outline-none focus:ring focus:ring-blue-200">
                        </div>
                        <div class="relative mt-4">
                            <img src="{{ asset('aset/password.svg') }}" alt="Password Icon"
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 brightness-50">
                            <input type="password" id="password" name="password" required placeholder="Password"
                                class="w-full pl-10 pr-10 py-2 rounded-lg gradient-outline focus:outline-none focus:ring focus:ring-blue-200">
                            <img src="{{ asset('aset/eye.svg') }}" alt="Show Password" id="togglePassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 cursor-pointer">
                        </div>
                        <button type="submit"
                            class="w-full px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg 
                            transition-all duration-300
                            hover:bg-gradient-to-r hover:from-blue-300 hover:to-blue-700"
                            style="box-shadow: 10px 0 20px -10px rgba(59, 130, 246, 0.2), 20px 0 30px -10px rgba(59, 130, 246, 0.4); margin-top:80px">
                            Login
                        </button>
                </div>
                <p class="text-center mt-3 mb-3" style="color: white">Copyright 2025 - Qif Media</p>
            </div>
        </div>
    </div>
</body>

</html>
