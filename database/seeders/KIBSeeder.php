<?php

namespace Database\Seeders;

use App\Models\kib;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KIBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        kib::create([
            'user_id' => 1,
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Tanah Perkantoran',
            'type_kib' => 'tanah',
            'nibar' => 1001,
            'no_register' => 12345,
            'spesifikasi' => 'Tanah kosong',
            'spesifikasi_tambahan' => null,
            'lokasi' => 'Jl. Raya No. 1',
            'no_rangka' => null,
            'no_mesin' => null,
            'no_pabrik' => null,
            'ukuran' => null,
            'status_tanah' => 'Hak Milik',
            'no_sertifikat' => '123/ABC/2024',
            'kontruksi' => null,
            'luas_lantai' => null,
            'no_dokumen' => null,
            'jumlah' => 1,
            'harga_satuan' => 5000,
            'nilai_perolehan' => 5000,
            'status_penggunaan' => 'Digunakan',
            'keterangan' => 'Data contoh',
            'gambar' => null,
        ]);
    }
}
