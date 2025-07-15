<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiAIService
{
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

<<<<<<< Updated upstream
    public function generateText($prompt)
    {
        $response = Http::post($this->apiUrl . '?key=' . env('GEMINI_API_KEY'), [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);
=======
    // public function generateText($prompt)
    // {
    //     $response = Http::post($this->apiUrl . '?key=' . env('GEMINI_API_KEY'), [
    //         'prompt' => ['text' => $prompt]
    //     ]);
>>>>>>> Stashed changes

    //     return $response->json();
    // }

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
            return ['error' => 'Gagal berkomunikasi dengan AI Service.'];
        }

        // Ekstrak teks jawaban dari struktur respons yang benar
        return $response->json('candidates.0.content.parts.0.text', 'Maaf, saya tidak dapat memberikan jawaban saat ini.');
    }
}