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
        Schema::create('kibs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->enum('type_kib', ['tanah', 'mesin', 'gedung']);
            $table->integer('nibar');
            $table->integer('no_register');
            $table->string('spesifikasi');
            $table->string('spesifikasi_tambahan')->nullable();
            $table->string('lokasi');
            $table->integer('no_rangka')->nullable();
            $table->integer('no_mesin')->nullable();
            $table->integer('no_pabrik')->nullable();
            $table->integer('ukuran')->nullable();
            $table->string('status_tanah')->nullable();
            $table->string('no_sertifikat')->nullable();
            $table->string('kontruksi')->nullable();
            $table->integer('luas_lantai')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('nilai_perolehan', 10, 2);
            $table->string('status_penggunaan');
            $table->string('keterangan')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kibs');
    }
};
