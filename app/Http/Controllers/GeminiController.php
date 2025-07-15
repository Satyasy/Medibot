<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiAIService;
use App\Services\RAGService; 

class GeminiController extends Controller
{
    protected $geminiService;
    protected $ragService;

    public function __construct(GeminiAIService $geminiService, RAGService $ragService) {
        $this->geminiService = $geminiService;
        $this->ragService = $ragService;
    }

     public function showChatbotPage()
    {
        return view('chatbot'); // Akan merender file resources/views/chatbot.blade.php
    }
    
    public function generate(Request $request) {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $userQuery = $request->input('prompt');

        // ==== LOGIKA RAG DIMULAI DI SINI ====

        // 3. RETRIEVAL: Cari konteks dari database menggunakan RAGService
        $context = $this->ragService->findRelevantContext($userQuery);

        $finalPrompt = '';

        // 4. AUGMENTATION: Buat prompt akhir berdasarkan ada atau tidaknya konteks
        if ($context) {
            // Jika konteks DITEMUKAN, buat prompt yang diperkaya
            $finalPrompt = "Anda adalah asisten AI kesehatan bernama Medibot. Berdasarkan informasi berikut: '{$context}'. Jawab pertanyaan dari pengguna: '{$userQuery}'. Jawablah dengan tepat dan hanya berdasarkan informasi yang diberikan. Selalu sebutkan sumber informasi di akhir jawaban Anda.";
        } else {
            // Jika konteks TIDAK DITEMUKAN, berikan jawaban dengan penafian
            $finalPrompt = "Anda adalah asisten AI kesehatan bernama Medibot. Jawab pertanyaan dari pengguna: '{$userQuery}'. Penting: Karena saya tidak menemukan informasi spesifik di basis data medis saya, berikan jawaban umum dan akhiri dengan penafian bahwa ini adalah informasi umum dan pengguna harus berkonsultasi dengan dokter.";
        }

        // 5. GENERATION: Kirim prompt yang sudah final ke Gemini
        $responseText = $this->geminiService->generateText($finalPrompt);

        // 6. RESPONSE: Kembalikan jawaban ke pengguna
        return response()->json([
            'reply' => $responseText,
            'source' => $context ? strtok($context, "\n") : 'Pengetahuan Umum AI' // Kirim juga sumbernya
        ]);
    }
}