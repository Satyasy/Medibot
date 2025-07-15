<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Smalot\PdfParser\Parser;
use App\Models\MedicalDocument;
use Illuminate\Support\Facades\File;

class ProcessMedicalPdfs extends Command
{
    protected $signature = 'app:process-medical-pdfs';
    protected $description = 'Processes PDF files from storage and saves their content to the database.';

    public function handle()
    {
        $parser = new Parser();
        $path = storage_path('app\medical_documents');
        $files = File::files($path);

        foreach ($files as $file) {
            if (strtolower($file->getExtension()) !== 'pdf') {
                continue;
            }

            $this->info("Processing: " . $file->getFilename());

            try {
                $pdf = $parser->parseFile($file->getPathname());
                $content = $pdf->getText();

                // Simpan atau perbarui berdasarkan nama file
                MedicalDocument::updateOrCreate(
                    ['file_name' => $file->getFilename()],
                    [
                        'title' => pathinfo($file->getFilename(), PATHINFO_FILENAME), // Judul dari nama file
                        'content' => $content
                    ]
                );

                $this->info("Successfully processed and saved: " . $file->getFilename());
            } catch (\Exception $e) {
                $this->error("Failed to process " . $file->getFilename() . ": " . $e->getMessage());
            }
        }

        $this->info("All PDF files have been processed.");
        return 0;
    }
}