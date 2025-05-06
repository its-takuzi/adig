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
        html {
            height: 100%;
        }

        .login-container {
            height: 100%;
        }

        .left-side {
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right-side {
            background: #1E58B0;
            color: white;
            display: flex;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .right-side .card {
            background: white;
            border-radius: 10px;
            padding: 0;
            max-width: 90%;
            width: 90%;
            max-height: 1000px;
            height: 700px;
            margin-top: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            position: relative;
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
    <div class="container-fluid h-100">
        <div class="row h-100 login-container">

            <!-- Left Side -->
            <div class="col-md-8 left-side">
                <img src="{{ asset('aset/ADIG-1.svg') }}" alt="Logo" class="img-fluid" style="max-width: 100%;">
            </div>

            <!-- Right Side -->
            <div class="col-md-4 right-side">
                <div class="card" style="width: 100%; padding: 2rem; display: flex; justify-content: center;">
                    <!-- Judul -->
                    <h2
                        style="
                     width: 100%;
                                max-width: 322px;
                                height: 64px;
               
                        margin-top: 5rem;
                        margin-bottom: 5.563rem;
                        font-family: Poppins, sans-serif;
                        text-align: center;
                        font-weight: 600;
                        font-size: 2rem;
                        line-height: 100%;
                        background: linear-gradient(91.85deg, #11C1EF 3.67%, #1179EF 94.77%);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                    ">
                        Welcome back!
                    </h2>

                    <!-- Form -->
                    <form action="{{ route('login.process') }}" method="POST"
                        class="w-100 d-flex flex-column align-items-center">
                        @csrf

                        <!-- Input Email -->
                        <div class="position-relative" style="width: 100%; max-width: 322px; height: 4rem;">

                            <img src="{{ asset('aset/email.svg') }}" alt="Email Icon"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; filter: brightness(0.5);">
                            <input type="email" id="email" name="email" required
                                placeholder="youremail@gmail.com"
                                style="width: 100%; height: 100%; padding-left: 45px; padding-right: 15px; border: 1px solid #E3E3E3; border-radius: 10px; outline: none;">
                        </div>

                        <!-- Jarak antara Email ke Password -->
                        <div style="height:17px;"></div>

                        <!-- Input Password -->
                        <div class="position-relative" style="width: 100%; max-width: 322px; height: 4rem;">

                            <img src="{{ asset('aset/password.svg') }}" alt="Password Icon"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; filter: brightness(0.5);">
                            <input type="password" id="password" name="password" required placeholder="Password"
                                style="width: 100%; height: 100%; padding-left: 45px; padding-right: 45px; border: 1px solid #E3E3E3; border-radius: 10px; outline: none;">
                            <img src="{{ asset('aset/eye.svg') }}" alt="Show Password" id="togglePassword"
                                style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; cursor: pointer;">
                        </div>

                        <!-- Jarak antara Password ke Button -->
                        <div style="height:89px;"></div>

                        <!-- Button Login -->
                        <div style="width: 100%; display: flex; justify-content: center;">
                            <div style="width: 100%; max-width: 322px;">
                                <button type="submit"
                                    style="
                                        width: 100%;
                                        padding: 1rem 0;
                                        border-radius: 10px;
                                        background: linear-gradient(91.85deg, #11C1EF 3.67%, #1179EF 94.77%);
                                        color: #FFFFFF;
                                        font-family: Poppins, sans-serif;
                                        font-weight: 600;
                                        font-size: clamp(1rem, 2.5vw, 1.5rem);
                                        border: none;
                                        box-shadow: 0px 8px 20px rgba(17, 121, 239, 0.35);
                                        transition: transform 0.2s ease, box-shadow 0.2s ease;
                                        text-align: center;
                                    "
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0px 12px 24px rgba(17, 121, 239, 0.4)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0px 8px 20px rgba(17, 121, 239, 0.35)';">
                                    LOGIN
                                </button>
                            </div>
                        </div>


                        <!-- Jarak antara Button ke Bawah Card -->
                        <div style="height:266px;"></div>

                    </form>
                </div>

                <!-- Footer -->
                <p class="text-center position-absolute" style="bottom: 20px; color: white; width: 100%;">
                    Copyright 2025 - Qif Media
                </p>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const togglePassword = document.getElementById('togglePassword');
                        const passwordInput = document.getElementById('password');

                        togglePassword.addEventListener('click', function() {
                            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordInput.setAttribute('type', type);

                            // Ganti icon jika perlu (misal: mata terbuka / tertutup)
                            if (type === 'text') {
                                this.src =
                                    "{{ asset('aset/eye.svg') }}"; // Pastikan file eye-off.svg ada di folder aset.
                            } else {
                                this.src = "{{ asset('aset/eye.svg') }}";
                            }
                        });
                    });
                </script>

            </div>
        </div>
    </div>
</body>

</html>
