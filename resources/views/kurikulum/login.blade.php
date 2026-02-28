<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Admin</title>
    <link rel="stylesheet" href="{{ asset('kurikulum/assets/css/style.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">
    <div class="card" style="max-width:480px;margin:40px auto">
        <h2>Admin Login</h2>
        @if($error)
        <p style="color:red">{{ $error }}</p>
        @endif
        <form method="POST" action="{{ route('kurikulum.login.post') }}">
            @csrf
            <label>Username</label><br>
            <input name="username" required style="width:100%;margin:8px 0;padding:10px"><br>
            <label>Password</label><br>
            <input name="password" type="password" required style="width:100%;margin:8px 0;padding:10px"><br>
            <button class="btn" type="submit">Masuk</button>
        </form>
        <p style="margin-top:12px;color:#6b7280">Only admin can edit. user: admin password: NESAS_CEREN</p>
    </div>
</div>

@include('kurikulum.partials.footer')
</body>
</html>
