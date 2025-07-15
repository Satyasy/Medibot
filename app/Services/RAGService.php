<?php

namespace App\Services;

use App\Models\MedicalDocument;

class RAGService
{
    /**
     * Mencari konteks relevan dari database berdasarkan query.
     */
    public function findRelevantContext(string $userQuery): ?string
    {
        // Pecah query menjadi kata kunci. Ini adalah pendekatan sederhana.
        $keywords = array_filter(explode(' ', $userQuery), fn($word) => strlen($word) > 3);

        if (empty($keywords)) {
            return null;
        }

        // Cari dokumen yang paling cocok
        $document = MedicalDocument::query()
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('content', 'LIKE', '%' . $keyword . '%');
                }
            })
            ->select('title', 'content') // Pilih kolom yang dibutuhkan
            ->first(); // Ambil yang paling relevan pertama

        if ($document) {
            // Konteks yang akan kita berikan ke AI
            // Format: Judul sumber + sedikit potongan teks (misal 4000 karakter pertama)
            return "Sumber Informasi: " . $document->title . "\n\nKutipan: " . mb_substr($document->content, 0, 4000);
        }

        return null;
    }
}