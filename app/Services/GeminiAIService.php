<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAIService
{
    // Gunakan model yang lebih spesifik dan umum, misal 'gemini-1.5-flash'
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function generateText(string $prompt)
    {
        // Gemini API mengharapkan payload dalam format 'contents'
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '?key=' . env('GEMINI_API_KEY'), $payload);

        if ($response->failed()) {
            // Jika ada error dari API, catat untuk debugging
            Log::error('Gemini API Error:', $response->json());
            return ['error' => 'Gagal berkomunikasi dengan AI Service.'];
        }

        // Ekstrak teks jawaban dari struktur respons yang benar
        return $response->json('candidates.0.content.parts.0.text', 'Maaf, saya tidak dapat memberikan jawaban saat ini.');
    }
}