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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->string('kategori')->default('Perlengkapan Kelas');
            $table->string('deskripsi');
            $table->unsignedInteger('nominal');
            $table->date('tanggal');
            $table->string('toko_vendor');
            $table->string('nomor_nota')->nullable();
            $table->enum('status_verifikasi', ['terverifikasi', 'menunggu', 'ditolak'])->default('terverifikasi');
            $table->string('penanggung_jawab')->default('Salsabila Putri');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
