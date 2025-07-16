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
        Schema::table('medical_documents', function (Blueprint $table) {
            // Ubah kolom 'content' agar bisa menerima nilai NULL (boleh kosong)
            $table->longText('content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_documents', function (Blueprint $table) {
            // Jika Anda perlu membatalkan, kembalikan ke kondisi semula
            $table->longText('content')->nullable(false)->change();
        });
    }
};