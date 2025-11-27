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

    /* Background tetap HIJAU lembut */
    body {
      background: linear-gradient(135deg, #0ea295, #0d7c72, #11988b);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    /* Lampu background */
    .light {
      position: absolute;
      width: 260px;
      height: 260px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.24);
      filter: blur(120px);
      animation: float 6s ease-in-out infinite alternate;
    }

    .light:nth-child(1) { top: -80px; left: -60px; }
    .light:nth-child(2) { bottom: -80px; right: -70px; animation-delay: 2s; }

    @keyframes float {
      0% { transform: translateY(0); }
      100% { transform: translateY(32px); }
    }

    /* CARD LOGIN ABU TRANSPARAN (GLASS GRAY) */
    .container {
      width: 950px;
      height: 560px;
      display: flex;
      border-radius: 20px;
      overflow: hidden;

      background: rgba(180, 180, 180, 0.18);  /* ABU transparan */
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.35);

      box-shadow:
        0 10px 35px rgba(0, 0, 0, 0.18),
        inset 0 0 25px rgba(255, 255, 255, 0.1);

      animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* LEFT SIDE */
    .login-section {
      flex: 1;
      padding: 60px 70px;
      color: #ffffff;
    }

    .top-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 25px;
    }

    .top-logo i {
      font-size: 2.1rem;
      color: #ffffff;
      filter: drop-shadow(0 3px 4px rgba(0, 0, 0, 0.22));
    }

    .top-logo span {
      font-size: 1.25rem;
      font-weight: 600;
      color: #f6fffe;
    }

    h2 {
      margin-top: 15px;
      margin-bottom: 10px;
      font-size: 2rem;
    }

    p {
      margin-bottom: 35px;
      font-size: 0.95rem;
      color: #e4fffb;
    }

    /* Form Input */
    .input-box {
      position: relative;
      margin-bottom: 20px;
    }

    .input-box input {
      width: 100%;
      height: 48px;
      border-radius: 12px;
      border: none;
      outline: none;
      padding: 0 48px 0 18px;
      font-size: 0.95rem;

      background: rgba(255, 255, 255, 0.78);
      color: #054843;

      transition: 0.25s;
      box-shadow:
        inset 3px 3px 6px rgba(0, 0, 0, 0.12),
        inset -3px -3px 6px rgba(255, 255, 255, 0.6);
    }

    .input-box input:focus {
      box-shadow: 
        0 0 0 3px rgba(0, 255, 213, 0.35),
        inset 0 0 12px rgba(0, 255, 213, 0.45);
      background: #ffffff;
    }

    .input-box i {
      position: absolute;
      right: 16px;
      top: 14px;
      color: #0e8278;
      font-size: 1.05rem;
      cursor: pointer;
    }

    /* Login Button */
    .login-btn {
      width: 100%;
      height: 50px;
      border-radius: 12px;
      border: none;
      font-size: 1.05rem;
      font-weight: 600;
      color: white;

      background: linear-gradient(135deg, #13c7b5, #0ea58f);
      cursor: pointer;

      box-shadow:
        0 4px 15px rgba(13, 150, 130, 0.35),
        inset 0 0 8px rgba(255, 255, 255, 0.25);

      transition: .3s;
    }

    .login-btn:hover {
      transform: translateY(-2px);
      box-shadow:
        0 7px 18px rgba(13, 150, 130, 0.4),
        inset 0 0 15px rgba(255, 255, 255, 0.3);
    }

    .forgot {
      text-align: right;
      margin-top: 12px;
    }

    .forgot a {
      color: #cafff3;
      font-size: 0.9rem;
      text-decoration: none;
    }

    /* RIGHT SIDE illustration */
    .illustration {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .illustration img {
      width: 360px;
      animation: floatImg 4s infinite ease-in-out alternate;
    }

    @keyframes floatImg {
      from { transform: translateY(0); }
      to { transform: translateY(-18px); }
    }


    /* Responsive */
    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        width: 92%;
        height: auto;
      }

      .illustration img { width: 240px; margin-top: 20px; }
    }
  </style>
</head>

<body>

  <div class="light"></div>
  <div class="light"></div>

  <div class="container">

    <div class="login-section">

      <div class="top-logo">
        <i class="fa-solid fa-shield-halved"></i>
        <span>Legalisir Akta | Disdukcapil Cirebon</span>
      </div>

      <h2>Selamat Datang</h2>
      <p>Masuk untuk mengakses layanan legalisir akta kependudukan.</p>

      <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="input-box">
          <input type="email" name="email" placeholder="Email" required>
          <i class="fa-regular fa-envelope"></i>
        </div>

        <div class="input-box">
          <input type="password" name="password" id="password" placeholder="Password" required>
          <i class="fa-solid fa-eye" id="togglePassword"></i>
        </div>

        <button class="login-btn">Login</button>

        <div class="forgot">
          <a href="#">Lupa password?</a>
        </div>

      </form>
    </div>

    <div class="illustration">
      <img src="{{ asset('gambar/smart_12864048.png') }}" alt="Ilustrasi Login">
    </div>

  </div>

  <script>
    const pass = document.getElementById("password");
    const toggle = document.getElementById("togglePassword");

    toggle.onclick = () => {
      pass.type = pass.type === "password" ? "text" : "password";
      toggle.classList.toggle("fa-eye");
      toggle.classList.toggle("fa-eye-slash");
    };
  </script>

</body>
</html>
