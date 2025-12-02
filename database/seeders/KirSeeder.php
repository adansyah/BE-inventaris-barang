<?php

namespace Database\Seeders;

use App\Models\kir;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = kir::create([
            'user_id' => 1,
            'kib_id' => 1,
            'nama_barang' => 'Laptop Lenovo ThinkPad',
            'kode_barang' => 12345,
            'tahun' => '2024-01-01',
            'lokasi_ruangan' => 'Ruang Kepala Desa',
            'kondisi' => 'baik',
            'jumlah' => 1,
            'nilai_perolehan' => 15000000,
            'gambar_qr' => null,
        ]);

        // 2. Buat URL tujuan ketika QR discan
        $scanUrl = url('/kir/' . $data->id);

        // 3. Buat nama file QR
        $fileName = 'qr_' . $data->id . '.svg';

        // 4. Simpan QR ke storage/public/qr/
        Storage::disk('public')->put(
            'qr/' . $fileName,
            QrCode::format('svg')->size(300)->generate($scanUrl)
        );

        // 5. Update kolom gambar_qr
        $data->update([
            'gambar_qr' => 'qr/' . $fileName,
        ]);
    }
}
