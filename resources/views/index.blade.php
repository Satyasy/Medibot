@extends('layouts.app') {{-- Menggunakan layout utama --}}

@section('title', 'Lindungi Dirimu Lindungi Keluarga') {{-- Judul halaman spesifik --}}

@section('styles')
    {{-- CSS spesifik untuk halaman landing ini --}}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endsection

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>Lindungi dirimu <br>Lindungi keluarga.</h1>
                <p>Konsultasikan kesehatan Anda langsung kepada dokter profesional dan dapatkan informasi terpercaya dari sumber yang kredibel. Kami siap membantu Anda menjaga kesehatan keluarga, kapanpun dan dimanapun.</p>
                <a href="#" class="btn btn-primary">Cari informasi</a>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/hero-landing.png') }}" alt="Ilustrasi Dokter dan Pasien">
            </div>
        </div>
        <div class="chatbot-button-wrapper">
            <a href="#" class="btn chatbot-btn">
                <span>Chatbot</span>
                <img src="{{ asset('images/profile-picture.png') }}" alt="Chatbot Icon">
            </a>
        </div>
    </section>

    <section id="fitur-section" class="features-section">
        <div class="container">
            <h2 class="section-title">Fitur - Fitur Kami</h2>
            <p class="section-subtitle">Untuk Menunjang Kesehatan Anda</p>

            <div class="features-list">
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('images/icon-fast-respon.png') }}" alt="Fast Respon Icon"> {{-- Pastikan ada ikon ini --}}
                    </div>
                    <h3>Layanan yang Fast Respon</h3>
                    <p>Tim kami siap merespon keluhan kesehatanmu dengan cepat, 24/7 tanpa harus menunggu lama.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('images/icon-24-jam.png') }}" alt="24 Jam Icon"> {{-- Pastikan ada ikon ini --}}
                    </div>
                    <h3>Layanan 24 Jam</h3>
                    <p>Konsultasi kesehatan tersedia kapan pun, siap melayani kamu siang dan malam tanpa henti.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="{{ asset('images/icon-konsultasi-gratis.png') }}" alt="Konsultasi Gratis Icon"> {{-- Pastikan ada ikon ini --}}
                    </div>
                    <h3>Layanan Konsultasi Gratis</h3>
                    <p>Nikmati layanan konsultasi kesehatan tanpa biaya, langsung dari rumah kamu.</p>
                </div>
            </div>
        </div>
    </section>


    {{-- Article Section --}}
    <section id="articles-section" class="articles-section">
        <div class="container">
            <h2>Artikel Kesehatan Terkini untuk Anda</h2>

            {{-- Perawatan Kulit Category --}}
            <div class="article-category">
                <h3>Berita Kesehatan Terkini</h3>
                <div class="article-list">
                    <div class="article-card">
                        <img src="{{ asset('images/berita-wajah.jpeg') }}" alt="Gambar Wajah">
                        <div class="article-info">
                            <h4>Inilah 5 Cara Tepat untuk Meratakan Warna Kulit Wajah</h4>
                            <p>Ditinjau oleh: Prof. Dr. Maulana Al Ghifari</p>
                            <span class="date">Meicam, M.Kes - 09/05/2025</span>
                        </div>
                    </div>
                    <div class="article-card">
                        <img src="{{ asset('images/telur-asin.png') }}" alt="Gambar Telur Asin">
                        <div class="article-info">
                            <h4>Apakah Telur Asin Bermanfaat untuk Mengatasi Diare?</h4>
                            <p>Ditunjang oleh: Dr. Nabil Putra</p>
                            <span class="date">amhdiya - 09/05/2025</span>
                        </div>
                    </div>
                </div>

                <div class="article-list">
                    <div class="article-card">
                        <img src="{{ asset('images/berita-pencernaan.jpeg') }}" alt="Gambar Ikan Baronang">
                        <div class="article-info">
                            <h4>10 Makanan yang Memperlancar Pencernaan, BAB Jadi Lancar</h4>
                            <p>Ditinjau oleh: Prof. Dr. Reyjuno Al Cannavaro</p>
                            <span class="date">Meicam, M.Kes - 09/05/2025</span>
                        </div>
                    </div>
                    <div class="article-card">
                        <img src="{{ asset('images/berita-suntik.jpeg') }}" alt="Gambar Buah Merah">
                        <div class="article-info">
                            <h4>WHO Rekomendasikan Obat Suntik Lencapavir untuk Cegah HIV</h4>
                            <p>Ditunjang oleh: Dr. Revano Satya</p>
                            <span class="date">amhdiya - 09/05/2025</span>
                        </div>
                    </div>
                </div>

                <div class="article-list">
                    <div class="article-card">
                        <img src="{{ asset('images/berita-kanker.jpg') }}" alt="Gambar Ikan Baronang">
                        <div class="article-info">
                            <h4>Dokter Sebut Ada Gejala Khas Kanker pada Malam Hari, Apa Itu?</h4>
                            <p>Ditinjau oleh: Prof. Dr. Ghifari Al Baihaqi</p>
                            <span class="date">Meicam, M.Kes - 09/05/2025</span>
                        </div>
                    </div>
                    <div class="article-card">
                        <img src="{{ asset('images/berita-darah.jpeg') }}" alt="Gambar Buah Merah">
                        <div class="article-info">
                            <h4>Tanpa Sadar, Kebiasaan Ini Bisa Merusak Pembuluh Darah</h4>
                            <p>Ditunjang oleh: Dr. Revano Satya</p>
                            <span class="date">amhdiya - 09/05/2025</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nutrisi Category --}}
            <div class="article-category">
                <h3>Nutrisi</h3>
                <div class="article-list">
                    <div class="article-card">
                        <img src="{{ asset('images/berita-baronang.jpg') }}" alt="Gambar Ikan Baronang">
                        <div class="article-info">
                            <h4>Ketahui! Manfaatnya Ikan Baronang Bagi Tubuh</h4>
                            <p>Ditinjau oleh: Ahmad Hidayanto</p>
                            <span class="date">Meicam, M.Kes - 09/05/2025</span>
                        </div>
                    </div>
                    <div class="article-card">
                        <img src="{{ asset('images/berita-buah.jpg') }}" alt="Gambar Buah Merah">
                        <div class="article-info">
                            <h4>7 Buah yang Tinggi Antioksidan dan Khasiat Utamanya</h4>
                            <p>Ditunjang oleh: dr. Maul</p>
                            <span class="date">amhdiya - 09/05/2025</span>
                        </div>
                    </div>
                </div>

                <div class="article-list">
                    <div class="article-card">
                        <img src="{{ asset('images/berita-kelor.jpg') }}" alt="Gambar Daun Kelor">
                        <div class="article-info">
                            <h4>Rahasia Daun Kelor: Si Daun Ajaib Penangkal Radikal Bebas</h4>
                            <p>Ditinjau oleh: dr. Sarah Indrawati</p>
                            <span class="date">Herbalia Team - 09/05/2025</span>
                        </div>
                    </div>
                    <div class="article-card">
                        <img src="{{ asset('images/berita-tehijo.jpg') }}" alt="Gambar Teh Hijau">
                        <div class="article-info">
                            <h4>Minum Teh Hijau Setiap Hari, Apa Saja Manfaatnya?</h4>
                            <p>Ditinjau oleh: dr. Bima Putra</p>
                            <span class="date">Redaksi Sehat - 09/05/2025</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    {{-- JavaScript untuk Smooth Scrolling --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah perilaku default (meloncat)

                // Mendapatkan ID target dari href
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth' // Ini yang membuat efek "terslide"
                    });
                }
            });
        });
    </script>
@endsection