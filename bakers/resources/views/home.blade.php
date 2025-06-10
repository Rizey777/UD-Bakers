<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT BAKER'S | Selamat Datang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(to right, #f1f5f9, #e2e8f0);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
            animation: fadeIn 1.5s ease-in-out;
        }

        h1 {
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-out forwards;
        }

        .animated-text {
            font-size: 3rem;
            font-weight: 700;
            color: #1e3a8a;
            animation: slideIn 2s ease-out forwards;
            opacity: 0;
        }

        @keyframes slideIn {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }
            100% {
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

        .btn-start {
            margin-top: 40px;
            padding: 14px 30px;
            font-size: 1rem;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .btn-start:hover {
            background-color: #2563eb;
        }

        @media (max-width: 600px) {
            .animated-text {
                font-size: 2rem;
            }

            h1 {
                font-size: 2rem;
            }

            .logo {
                width: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- Logo -->
    <img src="{{ asset('storage/logo.jpg') }}" alt="Logo PT BAKER'S" class="logo">

    <!-- Judul -->
    <h1>Selamat Datang di</h1>
    <div class="animated-text">UD BAKER'S</div>

    <!-- Tombol -->
    <a href="{{ route('register') }}" class="btn-start">Mulai Belanja</a>
</body>
</html>
