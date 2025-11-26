<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Qashier</title>
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
      background: #fff;
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
    p {
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
      border-color: #007bff;
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
      background-color: #006ee6;
    }
    .register {
      margin-top: 18px;
      font-size: 14px;
      color: #666;
    }
    .register a {
      color: #007bff;
      text-decoration: none;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Qashier</h1>
    <p>Masuk ke akun Anda</p>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <input type="text" name="username" class="form-control" placeholder="Username">
<input type="password" name="password" class="form-control" placeholder="Password">

      <button type="submit"> <a href="/dashboard">Masuk</a></button>
    </form>

   
  </div>
</body>
</html>
