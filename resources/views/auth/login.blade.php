<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $loginSettings = \App\Models\Setting::first();
    @endphp
    <title>Login Admin - {{ $loginSettings->school_name ?? 'SMK Yapisda Cisoka' }}</title>
    <!-- Favicon -->
    @if ($loginSettings)
        <link rel="icon" type="image/x-icon" href="{{ $loginSettings->school_logo_url }}">
    @else
        <link rel="icon" type="image/x-icon"
            href="https://ui-avatars.com/api/?name={{ urlencode($loginSettings->school_name ?? 'SMK Yapisda') }}&background=1e3a8a&color=fff&size=100">
    @endif
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f8f7fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.25rem 1.125rem 0 rgba(75, 70, 92, 0.1);
            background-color: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
        }
        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #7367f0;
            text-align: center;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-primary {
            background-color: #7367f0;
            border-color: #7367f0;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(115, 103, 240, 0.4);
            padding: 0.6rem;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #5f52ea;
            border-color: #5f52ea;
        }
        .form-control:focus {
            border-color: #7367f0;
            box-shadow: 0 0 0 0.2rem rgba(115, 103, 240, 0.25);
        }
        .text-primary {
            color: #7367f0 !important;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-logo">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>{{ $loginSettings->school_name ?? 'YAPISDA' }}</span>
        </div>
        <h4 class="mb-2 text-dark font-weight-bold">Selamat Datang! 👋</h4>
        <p class="mb-4 text-muted" style="font-size: 0.875rem;">Silakan masuk ke akun Anda untuk mengelola portal website {{ $loginSettings->school_name ?? 'SMK Yapisda Cisoka' }}.</p>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 0.825rem;">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="admin@yapisda.sch.id" required autofocus>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <label for="password" class="form-label m-0" style="font-size: 0.85rem; font-weight: 500;">Password</label>
                </div>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fa-solid fa-eye" id="passwordIcon"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember" style="font-size: 0.85rem;">Ingat Saya</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-2">Masuk</button>
        </form>

        <div class="text-center mt-4">
            <a href="/" class="text-decoration-none text-primary" style="font-size: 0.875rem;">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const passwordIcon = document.querySelector('#passwordIcon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
