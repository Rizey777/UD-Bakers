<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PT BAKER'S | Selamat Datang</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(to right, #fdfbfb, #ebedee);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    .container {
      display: flex;
      flex-direction: row;
      align-items: stretch;
      justify-content: center;
      max-width: 1200px;
      width: 100%;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      border-radius: 20px;
      overflow: hidden;
    }

    .left {
    width: 50%;
    padding: 60px 40px 60px 60px;
    background: linear-gradient(to right, #b38b59, #8d6e42); /* ✅ WARNA COKLAT */
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    animation: fadeInUp 1s ease-out forwards;
    }
    .logo {
      width: 130px;
      height: auto;
      margin-bottom: 20px;
      animation: fadeIn 1s ease-in-out;
    }

    h1 {
      font-size: 2.4rem;
      margin-bottom: 10px;
    }

    .animated-text {
      font-size: 2.8rem;
      font-weight: 700;
      background: linear-gradient(to right, #fff, #e0e0e0);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      opacity: 0;
      animation: slideIn 2s ease-out forwards;
    }

    .right {
      width: 50%;
      padding: 40px;
      background-color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 30px;
    }

    video {
      width: 100%;
      height: 600px; /* ✅ Tinggi video ditingkatkan */
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      object-fit: cover;
    }

    .btn-start {
      padding: 14px 40px;
      font-size: 1rem;
      background: linear-gradient(to right, #3b82f6, #60a5fa);
      color: white;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }

    .btn-start:hover {
      background: linear-gradient(to right, #2563eb, #3b82f6);
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .left, .right {
        width: 100%;
        text-align: center;
        padding: 40px 20px;
      }

      .left {
        align-items: center;
      }

      .logo {
        max-width: 100px;
      }

      video {
        height: 280px;
      }

      .animated-text {
        font-size: 2rem;
      }

      h1 {
        font-size: 1.8rem;
      }
    }

    @keyframes slideIn {
      from {
        transform: translateY(50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.9);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <!-- Kiri -->
    <div class="left">
      <img src="{{ asset('images/logo.jpg') }}" alt="Logo PT BAKER'S" class="logo" />
      <h1>Selamat Datang di</h1>
      <div class="animated-text">UD BAKER'S</div>
    </div>

    <!-- Kanan -->
    <div class="right">
      <video controls autoplay muted loop>
        <source src="{{ asset('videos/videopromosi.mp4') }}" type="video/mp4" />
        Browser Anda tidak mendukung video.
      </video>
      <a href="{{ route('register') }}" class="btn-start">Mulai Belanja</a>
    </div>
  </div>

</body>
</html>
