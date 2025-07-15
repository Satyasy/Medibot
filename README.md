<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.


# Medibot - Asisten Kesehatan AI Berbasis RAG

Medibot adalah chatbot AI yang dibangun menggunakan Laravel dan didukung oleh Google Gemini API. Proyek ini dirancang untuk memberikan informasi awal mengenai gejala kesehatan berdasarkan sumber dokumen medis yang terpercaya.

Fitur utamanya adalah implementasi **Retrieval-Augmented Generation (RAG)**, yang memastikan bahwa jawaban AI didasarkan pada data dari basis pengetahuan (jurnal, pedoman medis) yang telah disediakan, bukan semata-mata dari pengetahuan umum AI. Hal ini meningkatkan relevansi, akurasi, dan kepercayaan jawaban.

---

## ⚠️ Penafian Penting

**Medibot bukanlah pengganti diagnosis, nasihat, atau pengobatan dari dokter profesional.** Informasi yang diberikan oleh chatbot ini hanya untuk tujuan edukasi awal. Untuk masalah medis apa pun, **selalu konsultasikan dengan dokter** atau fasilitas kesehatan terdekat. Pengembang tidak bertanggung jawab atas keputusan apa pun yang dibuat berdasarkan informasi dari chatbot ini.

---

## ✨ Fitur Utama

-   **Respons Kontekstual**: Jawaban dihasilkan berdasarkan konten dokumen medis yang relevan.
-   **Kutipan Sumber**: Secara otomatis menyertakan sumber informasi yang digunakan untuk menjawab.
-   **Mekanisme Fallback**: Jika tidak ada informasi relevan yang ditemukan, chatbot akan memberikan jawaban umum dengan penafian yang jelas.
-   **REST API**: Mudah diintegrasikan dengan aplikasi front-end (web atau mobile).
-   **Basis Pengetahuan yang Dapat Diperluas**: Cukup tambahkan file PDF medis baru dan jalankan perintah untuk memperbarui pengetahuan bot.

## 🛠️ Teknologi yang Digunakan

-   **Backend**: Laravel 11
-   **AI Engine**: Google Gemini API
-   **PDF Parser**: `smalot/pdfparser`
-   **Database**: MySQL / PostgreSQL (dapat dikonfigurasi)

---

## 🚀 Instalasi dan Pengaturan Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

### 1. Prasyarat

-   PHP 8.2 atau lebih tinggi
-   Composer
-   Node.js & NPM (untuk pengembangan front-end)
-   Database Server (misalnya MySQL)

### 2. Langkah-langkah Instalasi

1.  **Clone repository ini:**
    ```sh
    git clone https://your-repository-url/medibot.git
    cd medibot
    ```

2.  **Instal dependensi PHP:**
    ```sh
    composer install
    ```

3.  **Buat file `.env`:**
    Salin file `.env.example` menjadi `.env`.
    ```sh
    cp .env.example .env
    ```

4.  **Konfigurasi Environment (`.env`):**
    Buka file `.env` dan atur variabel berikut, terutama koneksi database dan kunci API Anda.
    ```env
    APP_NAME="Medibot"
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=medibot
    DB_USERNAME=root
    DB_PASSWORD=

    # Masukkan Kunci API Gemini Anda di sini
    GEMINI_API_KEY=xxxxxxxxxxxxxxxxxxxxxxxxxx
    ```

5.  **Generate Kunci Aplikasi Laravel:**
    ```sh
    php artisan key:generate
    ```

6.  **Jalankan Migrasi Database:**
    Perintah ini akan membuat tabel `medical_documents` yang diperlukan.
    ```sh
    php artisan migrate
    ```

7.  **Siapkan Basis Pengetahuan (Knowledge Base):**
    -   Letakkan file-file PDF medis Anda di dalam folder `storage/app/medical_documents/`.
    -   Jalankan perintah Artisan untuk memproses PDF tersebut dan menyimpannya ke database.
    ```sh
    php artisan app:process-medical-pdfs
    ```

8.  **Jalankan Server Pengembangan:**
    ```sh
    php artisan serve
    ```
    Aplikasi sekarang berjalan di `http://127.0.0.1:8000`.

---

## 🔌 Dokumentasi API

Gunakan endpoint berikut untuk berinteraksi dengan Medibot dari aplikasi front-end atau alat pengujian API seperti Postman.

### Generate Response

-   **URL:** `/api/generate`
-   **Method:** `POST`
-   **Headers:**
    -   `Content-Type: application/json`
    -   `Accept: application/json`

#### **Request Body:**

Permintaan harus berisi satu kunci `prompt` dengan pertanyaan pengguna sebagai nilainya.

```json
{
    "prompt": "Apa saja gejala awal dari infeksi HIV?"
}
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
