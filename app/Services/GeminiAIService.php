<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiAIService
{
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function generateText($prompt)
    {
        $response = Http::post($this->apiUrl . '?key=' . env('GEMINI_API_KEY'), [
            'prompt' => ['text' => $prompt]
        ]);

        return $response->json();
    }
}