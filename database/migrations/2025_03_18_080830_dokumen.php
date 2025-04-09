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
            $table->string('laporan_polisi')->unique();
            $table->date('tanggal_laporan');
            $table->string('file');
            $table->bigInteger('size');
            $table->enum('kategori', ['curas', 'curat', 'curanmor']);
            $table->foreignId('rak_id')->constrained('Rak')->onDelete('cascade');
            $table->enum('jenis_surat', ['tahap2', 'sp3', 'rj']);
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
