<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('medical_chunks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('medical_document_id')->constrained()->onDelete('cascade'); // Relasi ke dokumen asli
        $table->text('content'); // Isi potongan/paragraf
        $table->text('content_embedding')->nullable(); // Kolom untuk menyimpan vektor (jika DB mendukung)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_chunks');
    }
};