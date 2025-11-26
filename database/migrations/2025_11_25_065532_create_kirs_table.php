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
        Schema::create('kirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kib_id')->constrained()->onDelete('cascade');
            $table->string('nama_barang');
            $table->string('merk');
            $table->integer('no_seri');
            $table->string('ukuran');
            $table->string('bahan');
            $table->date('tahun_buat');
            $table->integer('jumlah_barang_register');
            $table->decimal('harga_beli', 10, 2);
            $table->enum('kondisi_barang', ['baik', 'kurang baik', 'rusak berat'])->default('baik');
            $table->string('keterangan_mutasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kirs');
    }
};
