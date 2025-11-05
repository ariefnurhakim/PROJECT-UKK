<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Qashier</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9fafb;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .card {
      background: white;
      padding: 35px 40px;
      border-radius: 18px;
      width: 360px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
      text-align: center;
    }
    h1 {
      font-size: 34px;
      color: #111;
      margin-bottom: 10px;
      font-weight: 700;
    }
    p.subtitle {
      color: #666;
      font-size: 14px;
      margin-bottom: 25px;
    }
    input {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 14px;
      transition: border 0.2s;
    }
    input:focus {
      outline: none;
      border-color: #00AEEF;
    }
    button {
      width: 100%;
      background-color: #007bff;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 10px;
    }
    button:hover {
      background-color: #006fe6;
    }
    .login {
      margin-top: 18px;
      font-size: 14px;
      color: #666;
    }
    .login a {
      color: #007bff;
      text-decoration: none;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Qashier</h1>
    <p class="subtitle">Buat akun baru Anda</p>

    <form method="POST" action="{{ route('register') }}">

      @csrf
      <input type="text" name="nama" placeholder="Nama Lengkap" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Kata Sandi" required>
      <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
      <button type="submit">Daftar</button>
    </form>

    <div class="login">
      Sudah punya akun? <a href="{{ route('login') }}">Login Sekarang</a>
    </div>
  </div>
</body>
</html>
