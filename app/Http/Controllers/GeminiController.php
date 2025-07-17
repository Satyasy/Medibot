<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiAIService;

class GeminiController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiAIService $geminiService) {
        $this->geminiService = $geminiService;
    }

    public function showChatbotPage()
    {
        return view('chatbot');
    }

    public function generate(Request $request) {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $userQuery = $request->input('prompt');

        // AUGMENTATION ENHANCED (NO FILTER, NO RAG)
        $finalPrompt = "Anda adalah Medibot, asisten AI medis yang sangat akurat dan profesional.

PERTANYAAN USER: {$userQuery}

INSTRUKSI RESPONS:
1. WAJIB analisis gejala yang disebutkan user dengan sangat teliti
2. WAJIB berikan diagnosis diferensial dengan persentase kemungkinan yang realistis (minimal 3-5 penyakit)
3. Format persentase: 'Nama Penyakit: XX%'
4. Urutkan dari persentase tertinggi ke terendah
5. Berikan penjelasan detail untuk setiap penyakit yang disebutkan
6. Sertakan gejala tambahan yang mungkin muncul
7. Berikan rekomendasi tindakan medis yang tepat
8. SELALU akhiri dengan disclaimer medis dan anjuran konsultasi dokter
9. WAJIB sebutkan sumber informasi di akhir

BATASAN:
- Jangan memberikan diagnosis pasti, hanya kemungkinan
- Jangan merekomendasikan dosis obat spesifik
- Selalu tekankan pentingnya konsultasi medis profesional
- Jika tidak yakin, katakan 'memerlukan pemeriksaan lebih lanjut'

Format respons yang diharapkan:
**ANALISIS GEJALA:**
[Analisis gejala yang disebutkan]

**KEMUNGKINAN DIAGNOSIS:**
1. [Nama Penyakit]: [XX]%
   - Penjelasan: [detail penyakit]
   - Gejala tambahan: [gejala lain yang mungkin muncul]

2. [Nama Penyakit]: [XX]%
   - Penjelasan: [detail penyakit]
   - Gejala tambahan: [gejala lain yang mungkin muncul]

**REKOMENDASI:**
[Tindakan yang disarankan]

**DISCLAIMER:**
[Penafian medis dan anjuran konsultasi dokter]

**SUMBER:** [Sumber informasi]";

        $responseText = $this->geminiService->generateText($finalPrompt);

        return response()->json([
            'reply' => $responseText,
            'source' => 'Basis Pengetahuan Umum AI'
        ]);
    }
}