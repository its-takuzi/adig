<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('lp');
            $table->string('laporan_polisi');
            $table->date('tanggal_laporan');
            $table->string('file');
            $table->bigInteger('size');
            $table->enum('kategori', ['CURAS', 'CURAT', 'CURANMOR']);
            $table->foreignId('rak_id')->constrained('Rak')->onDelete('cascade');
            $table->enum('jenis_surat', ['Tahap 2', 'SP3', 'RJ']);
            $table->date('tanggal_ungkap')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
