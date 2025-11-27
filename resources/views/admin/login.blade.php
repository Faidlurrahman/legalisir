<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Disdukcapil</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(180deg, #0b4d3b, #083f31, #052a21);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      color: #fff;
    }

    .login-container {
      width: 420px;
      background: rgba(255, 255, 255, 0.05);
      padding: 40px 38px;
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.35);
      text-align: center;
      animation: fadeIn 1s ease;
      backdrop-filter: blur(12px);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(40px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      margin-bottom: 6px;
      font-size: 1.9rem;
      font-weight: 600;
      color: #fefefe;
    }

    .subtitle {
      font-size: 0.9rem;
      color: #c7d4de;
      margin-bottom: 30px;
    }

    .input-box {
      margin-bottom: 18px;
      text-align: left;
      position: relative;
    }

    .input-box input {
      width: 100%;
      height: 46px;
      border-radius: 8px;
      border: none;
      background: rgba(255, 255, 255, 0.12);
      color: #e9eef3;
      padding: 0 45px 0 16px;
      font-size: 0.9rem;
      outline: none;
      letter-spacing: 0.3px;
      transition: .25s;
    }

    .input-box input:focus {
      background: rgba(255, 255, 255, 0.18);
      border: 0.5px solid rgba(255, 255, 255, 0.28);
    }

    .input-label {
      font-size: 0.85rem;
      color: #cfd9e3;
      margin-bottom: 5px;
      display: block;
    }

    /* Eye Icon */
    .toggle-password {
      position: absolute;
      right: 16px;
      top: 38px;
      font-size: 18px;
      color: #d5f7df;
      cursor: pointer;
      transition: .2s;
    }

    .toggle-password:hover {
      color: #8affbc;
    }

    /* tombol */
    .login-btn {
      width: 100%;
      height: 48px;
      background: #1abe63;
      border-radius: 8px;
      border: none;
      margin-top: 25px;
      font-size: 1rem;
      font-weight: 600;
      color: #034b24;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(41, 255, 107, 0.35);
      transition: .3s;
    }

    .login-btn:hover {
      box-shadow: 0 7px 18px rgba(41, 255, 107, 0.45);
      transform: translateY(-2px);
    }

    .waves {
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 100%;
      opacity: 0.25;
    }

    .stars {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      background-image: radial-gradient(#ffffff33 1px, transparent 1px);
      background-size: 24px 24px;
      pointer-events: none;
      opacity: 0.22;
    }
  </style>
</head>

<body>

  <div class="stars"></div>

  <svg class="waves" viewBox="0 0 1440 320">
    <path fill="#ffffff"
      d="M0,256L80,240C160,224,320,192,480,197.3C640,203,800,245,960,256C1120,267,1280,245,1360,234.7L1440,224L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
    </path>
  </svg>

  <div class="login-container">

    <h2>Log In</h2>
    <p class="subtitle">Masuk untuk mengelola layanan legalisir akta.</p>

    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf

      <div class="input-box">
        <label class="input-label">Email</label>
        <input type="email" name="email" placeholder="Masukkan email..." required>
      </div>

      <div class="input-box">
        <label class="input-label">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password..." required>
        <i class="fa-solid fa-eye toggle-password" onclick="togglePassword()"></i>
      </div>

      <button class="login-btn">Log In</button>

    </form>

  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById("password");
      const icon = document.querySelector(".toggle-password");

      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>

</body>

</html>
