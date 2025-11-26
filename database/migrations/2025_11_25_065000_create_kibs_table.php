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
            $table->integer('nibar');
            $table->integer('no_register');
            $table->string('spesifikasi');
            $table->string('spesifikasi_tambahan')->nullable();
            $table->string('lokasi');
            $table->integer('no_polisi');
            $table->integer('no_rangka');
            $table->integer('no_bpkb');
            $table->decimal('jumlah', 10, 2);
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('nilai_perolehan', 10, 2);
            $table->string('status_penggunaan');
            $table->string('keterangan')->nullable();
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
