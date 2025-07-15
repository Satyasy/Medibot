<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Smalot\PdfParser\Parser;
use App\Models\MedicalDocument;
use Illuminate\Support\Facades\Http; // <-- Tambahkan ini
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class ProcessMedicalPdfs extends Command
{
    protected $signature = 'app:process-medical-pdfs';
    protected $description = 'Downloads and processes medical PDFs from a list of URLs.';

    public function handle()
    {
        // Daftar URL sumber PDF terpercaya Anda
        $pdfUrls = [
            'https://www.who.int/docs/default-source/searo/indonesia/leprosy-who-leaflet-2016-indonesian.pdf',
            'https://promkes.kemkes.go.id/download/publikasi/media-promosi-kesehatann/Brosur-GERMAS_1659079999.pdf',
            // Tambahkan URL lainnya di sini
        ];

        $parser = new Parser();

        foreach ($pdfUrls as $url) {
            $this->info("Processing URL: " . $url);

            try {
                // Langkah 1: Unduh konten PDF dari URL
                $response = Http::get($url);

                if ($response->failed()) {
                    $this->error("Failed to download: " . $url);
                    continue;
                }

                
                // Langkah 2: Simpan PDF sementara di storage
                $fileName = basename($url);
                $temporaryPath = 'temp_pdfs/' . $fileName;
                Storage::put($temporaryPath, $response->body());

                // Langkah 3: Proses file PDF yang sudah diunduh menggunakan PdfParser
                $pdf = $parser->parseFile(storage_path('app/' . $temporaryPath));
                $content = $pdf->getText();
                
                // Simpan atau perbarui berdasarkan nama file
                MedicalDocument::updateOrCreate(
                    ['file_name' => $fileName],
                    [
                        'title' => pathinfo($fileName, PATHINFO_FILENAME),
                        'content' => $content
                    ]
                );

                // Hapus file sementara setelah selesai
                Storage::delete($temporaryPath);
                
                $this->info("Successfully processed and saved: " . $fileName);

            } catch (\Exception $e) {
                $this->error("Failed to process " . $url . ": " . $e->getMessage());
            }
        }

        $this->info("All PDF files from URLs have been processed.");
        return 0;
    }
}