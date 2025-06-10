@extends('layouts.app')

@section('title', 'Selamat Datang | PT BAKER\'S')

@section('content')
<style>
  body {
    background: linear-gradient(to right, #fdfbfb, #ebedee);
  }

  .home-container {
    display: flex;
    flex-direction: row;
    align-items: stretch;
    justify-content: center;
    max-width: 1200px;
    width: 100%;
    margin: 40px auto;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    background-color: white;
  }

  .left-side {
    width: 50%;
    padding: 60px 40px;
    background: linear-gradient(to right, #b38b59, #8d6e42);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    animation: fadeInUp 1s ease-out forwards;
  }

  .left-side .logo {
    width: 130px;
    margin-bottom: 20px;
    animation: fadeIn 1s ease-in-out;
  }

  .left-side h1 {
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

  .right-side {
    width: 50%;
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 30px;
  }

  .right-side video {
    width: 100%;
    max-height: 500px;
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

  @media (max-width: 992px) {
    .home-container {
      flex-direction: column;
    }

    .left-side, .right-side {
      width: 100%;
      text-align: center;
      padding: 40px 20px;
      align-items: center;
    }

    .left-side h1 {
      font-size: 1.8rem;
    }

    .animated-text {
      font-size: 2rem;
    }

    .right-side video {
      max-height: 300px;
    }

    .left-side .logo {
      width: 100px;
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

<div class="home-container">
  <div class="left-side">
    <img src="{{ asset('images/logo.jpg') }}" alt="Logo PT BAKER'S" class="logo">
    <h1>Selamat Datang di</h1>
    <div class="animated-text">UD BAKER'S</div>
  </div>
  <div class="right-side">
    <video controls autoplay muted loop>
      <source src="{{ asset('videos/videopromosi.mp4') }}" type="video/mp4">
      Browser Anda tidak mendukung video.
    </video>
    <a href="{{ route('register') }}" class="btn-start">Mulai Belanja</a>
  </div>
</div>
@endsection
