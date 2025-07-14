<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiAIService;

class GeminiController extends Controller
{
    protected $geminiService;

    public function _construct(GeminiAIService $geminiService) {
        $this->geminiService = $geminiService;
    }

    public function generate(Request $request) {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $response = $this->geminiService->generateText($request->input('prompt'));
        return response()->json($response);
    }
}