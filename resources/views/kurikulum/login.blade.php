<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Admin - SMKN 1 Subang</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href="{{ asset('css/kurikulum.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,600,800');

        .login-area {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 120px);
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(37, 99, 235, 0.15);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .login-card .logo img {
            width: 80px;
            height: auto;
            margin-bottom: 16px;
        }

        .login-card h1 {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .login-card .subtitle {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 28px;
        }

        .error-msg {
            background: #fee2e2;
            color: #dc2626;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 16px;
            text-align: left;
        }

        .input-group {
            position: relative;
            margin-bottom: 16px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }

        .input-group .icon {
            position: absolute;
            left: 14px;
            top: 38px;
            color: #94a3b8;
            font-size: 14px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.2s;
            outline: none;
            background: #f8fafc;
        }

        .input-group input:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #1d4ed8, #3b82f6);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: linear-gradient(to right, #1e40af, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .school-info {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content">
    <div class="login-area">
        <div class="login-card">
            <div class="logo">
                <img src="{{ asset('kurikulum/assets/images/logo_smkn1.png') }}" alt="SMKN 1 Subang">
            </div>
            <h1>Admin Login</h1>
            <p class="subtitle">Sistem Informasi Kurikulum SMKN 1 Subang</p>

            @if($error)
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i> {{ $error }}
            </div>
            @endif

            <form method="POST" action="{{ route('kurikulum.login.post') }}">
                @csrf
                <div class="input-group">
                    <label>Username</label>
                    <i class="fas fa-user icon"></i>
                    <input type="text" name="username" placeholder="Masukkan username" required />
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <i class="fas fa-lock icon"></i>
                    <input type="password" name="password" placeholder="Masukkan password" required />
                </div>
                <button class="btn-login" type="submit">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <div class="school-info">
                <i class="fas fa-shield-alt"></i> Hanya admin yang dapat mengakses halaman ini
            </div>
        </div>
    </div>
</div>

@include('kurikulum.partials.footer')
</body>
</html>