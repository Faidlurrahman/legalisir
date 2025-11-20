<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Disdukcapil</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f6fcfb;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .bg-circle1,
    .bg-circle2 {
      position: absolute;
      border-radius: 50%;
      z-index: 0;
    }

    .bg-circle1 {
      width: 600px;
      height: 600px;
      background: rgba(19, 128, 125, 0.15);
      bottom: -200px;
      right: -200px;
    }

    .bg-circle2 {
      width: 400px;
      height: 400px;
      background: rgba(19, 128, 125, 0.1);
      top: -150px;
      left: -150px;
    }

    .container {
      width: 950px;
      height: 520px;
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      display: flex;
      overflow: hidden;
      position: relative;
      z-index: 1;
    }

    /* LOGIN SECTION */
    .login-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 0 70px;
      padding-top: 80px;
      position: relative;
    }

    /* LOGO POJOK KIRI ATAS – DIPERKECIL & DIKECILKAN JARAKNYA */
    .top-logo {
      position: absolute;
      top: 22px;
      left: 30px;
      /* LEBIH KE KIRI */
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .top-logo img {
      width: 32px;
      height: 32px;
    }

    .top-logo span {
      font-size: 1.15rem;
      font-weight: 700;
      color: #0b5b57;
      text-transform: capitalize;
    }

    /* Atribusi Flaticon */
    .credit {
      position: absolute;
      top: 60px;
      left: 30px;
      font-size: 0.7rem;
      color: #7fa39f;
    }

    .credit a {
      color: #0b5b57;
      text-decoration: none;
    }

    .credit a:hover {
      text-decoration: underline;
    }

    .login-section h2 {
      color: #0b5b57;
      font-size: 1.6rem;
      font-weight: 600;
      margin-bottom: 10px;
      margin-top: 45px;
    }

    .login-section p {
      color: #6b9c98;
      font-size: 0.9rem;
      margin-bottom: 35px;
    }

    .input-box {
      position: relative;
      margin-bottom: 18px;
    }

    .input-box input {
      width: 100%;
      height: 42px;
      border-radius: 8px;
      border: 1.8px solid #bcd9d7;
      padding: 0 40px 0 15px;
      outline: none;
      font-size: 0.95rem;
      color: #0b5b57;
      transition: 0.3s;
    }

    .input-box input:focus {
      border-color: #0b5b57;
      box-shadow: 0 0 6px rgba(11, 91, 87, 0.15);
    }

    .input-box i {
      position: absolute;
      right: 12px;
      top: 12px;
      color: #7ba7a4;
    }

    .login-btn {
      width: 100%;
      height: 42px;
      background-color: #1aa897;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.3s;
    }

    .login-btn:hover {
      background-color: #149384;
    }

    .forgot {
      text-align: right;
      margin-top: 10px;
    }

    .forgot a {
      color: #0b5b57;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .forgot a:hover {
      text-decoration: underline;
    }

    .illustration {
      flex: 1;
      background: linear-gradient(135deg, #e3f4f2 0%, #bde6e2 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .illustration img {
      width: 340px;
      max-width: 90%;
      z-index: 2;
    }
    .form{
      margin-bottom: 100px;
    }
    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        width: 90%;
        height: auto;
      }

      .login-section {
        padding: 40px 40px;
      }

      .top-logo,
      .credit {
        left: 40px;
      }

      .illustration {
        padding: 40px;
      }

      .illustration img {
        width: 250px;
      }
    }
  </style>
</head>

<body>

  <div class="bg-circle1"></div>
  <div class="bg-circle2"></div>

  <div class="container">

    <!-- LOGO + ATRIBUSI -->
    <div class="login-section">

      <!-- Logo -->
      <div class="top-logo">
        <img src="{{ asset('gambar/file.png') }}" alt="Icon">
        <span>Legalisir Akta || Disdukcapil Kota Cirebon</span>
      </div>

      <div class="form">
        <h2>Login</h2>
        <p>Masuk ke Legalisir Akta Kependudukan Disdukcapil</p>

        <form method="POST" action="{{ route('admin.login.submit') }}">
          @csrf

          <div class="input-box">
            <input type="email" name="email" placeholder="Email Address" required>
            <i class="fa-regular fa-envelope"></i>
          </div>

          <div class="input-box">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fa-regular fa-eye" id="togglePassword" style="cursor:pointer;"></i>
          </div>

          <button type="submit" class="login-btn">Login</button>

          <div class="forgot">
            <a href="#">Forgot your password?</a>
          </div>
        </form>
      </div>
    </div>

    <div class="illustration">
      <img src="{{ asset('gambar/smart_12864048.png') }}" alt="Ilustrasi Login Disdukcapil">
    </div>

  </div>

  <script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function() {
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>

</body>

</html>