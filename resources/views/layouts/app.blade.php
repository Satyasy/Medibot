<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Kesehatan')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Link ke CSS global utama --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    {{-- Font Awesome untuk ikon (Jika belum ada di app.css) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- CSS spesifik halaman (akan diisi oleh @yield('styles') di halaman turunan) --}}
    @yield('styles')
</head>

{{-- Body class akan ditentukan oleh halaman turunan (misal: 'chatbot-page') --}}
<body class="@yield('body_class')">

    {{-- Header Section (Navbar) --}}
    <header class="main-header">
        <div class="container header-content">
            <div class="logo">
                <img src="{{ asset('images/logo-header.png') }}" alt="Logo M3">
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="#fitur-section">Fitur</a></li>
                    <li><a href="#articles-section">Artikel</a></li>
                    <li><a href="{{ url('/chatbot') }}">Konsultasi Dokter</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                @guest
                    <a href="{{ url('/chatbot') }}" class="btn btn-login">Chatbot</a>
                @endguest
            </div>
        </div>
    </header>

    {{-- Konten Utama Halaman --}}
    {{-- Ini adalah wrapper utama untuk konten dinamis. Ini akan diatur oleh CSS --}}
    <main id="main-content-wrapper">
        @yield('content')
    </main>

    {{-- Footer Section --}}
    <footer class="main-footer">
        <div class="container footer-content">
            <div class="footer-brand">
                <img src="{{ asset('images/logo-medibot.png') }}" alt="Logo M3 Footer">
                <p>Kesehatan adalah Investasi Terbaik. Medibot penyedia layanan konsultasi gratis berintegrasi AI atau
                    Kecerdasan Buatan. Dengan layanan 24 jam, mampu melayani anda kapanpun dan dimanapun</p>
            </div>
            <div class="footer-nav">
                <h4>Informasi</h4>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>Kontak Kami</h4>
                <p>Email: medibotai@gmail.com</p>
                <p>Telepon: +62 813 9883 6319</p>
                <div class="social-media">
                    <a href="#"><img src="{{ asset('images/facebook-icon.png') }}" alt="Facebook"></a>
                    <a href="#"><img src="{{ asset('images/instagram-icon.png') }}" alt="Instagram"></a>
                    <a href="#"><img src="{{ asset('images/twitter-icon.png') }}" alt="Twitter"></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2025 MEDIBOT AI. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Link ke JavaScript global --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- JavaScript spesifik halaman --}}
    @yield('scripts')
</body>
</html>