<?php

namespace App\Http\Controllers;

use App\Models\kib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $kib = kib::latest()->get();
        $total = kib::sum('harga_satuan');
        return view('pdf.laporan-barang', compact('kib', 'total'));
    }

    public function kondisi()
    {
        $tipe_kib = ['tanah', 'mesin', 'gedung'];
        $data_kondisi = [];

        // Inisialisasi variabel untuk menyimpan total keseluruhan
        $total_kondisi_baik = 0;
        $total_kondisi_rusak = 0;

        foreach ($tipe_kib as $tipe) {
            // Hitung kondisi 'baik' untuk tipe KIB saat ini
            $baik = kib::where('type_kib', $tipe)
                ->where('status_penggunaan', 'baik')
                ->count();

            // Hitung kondisi 'rusak berat' untuk tipe KIB saat ini
            $rusak = kib::where('type_kib', $tipe)
                ->where('status_penggunaan', 'rusak berat')
                ->count();

            // Simpan hasil hitungan untuk tipe KIB ini
            $data_kondisi[$tipe] = [
                'baik' => $baik,
                'rusak berat' => $rusak,
            ];

            // Tambahkan ke total keseluruhan (jika diperlukan di view)
            $total_kondisi_baik += $baik;
            $total_kondisi_rusak += $rusak;
        }

        // Kirim data terstruktur ($data_kondisi) dan total (jika perlu) ke view
        return view('pdf.kondisi-barang', compact('data_kondisi', 'total_kondisi_baik', 'total_kondisi_rusak'));
    }

    public function kondisi_baik()
    {
        $kib = kib::where('status_penggunaan', 'baik')->get();
        $total = kib::where('status_penggunaan', 'baik')->sum('harga_satuan');
        return view('pdf.kondisi-baik', compact('kib', 'total'));
    }

    public function kondisi_rusak()
    {
        $kib = kib::where('status_penggunaan', 'rusak berat')->get();
        $total = kib::where('status_penggunaan', 'rusak berat')->sum('harga_satuan');
        return view('pdf.kondisi-rusak', compact('kib', 'total'));
    }
}
