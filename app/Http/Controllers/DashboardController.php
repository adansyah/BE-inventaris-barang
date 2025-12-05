<?php

namespace App\Http\Controllers;

use App\Models\kib;
use App\Models\kir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {

        $totalValuation = Kib::sum('harga_satuan');

        $totalUnits = Kib::count('jumlah');

        $unitsRusakBerat = Kir::where('kondisi', 'Rusak Berat')->sum('jumlah');

        $kondisiData = Kir::select('kondisi', DB::raw('SUM(jumlah) as total_unit'))
            ->groupBy('kondisi')
            ->get()
            ->map(function ($item) {
                // Mengubah 'Tersedia' menjadi 'Baik' jika diperlukan untuk konsistensi UI
                $label = $item->kondisi === 'Tersedia' ? 'Baik' : $item->kondisi;
                return [
                    'label' => $label,
                    'value' => (int) $item->total_unit,
                ];
            });

        $lokasi = Kir::select('lokasi', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('lokasi')
            ->get();

        // Ambil total semua unit yang memiliki data lokasi
        $totalUnitsLokasi = $lokasi->sum('jumlah');

        // Hitung persentase untuk setiap lokasi
        $lokasiData = $lokasi->map(function ($item) use ($totalUnitsLokasi) {
            $persentase = ($item->jumlah / $totalUnitsLokasi) * 100;
            return [
                'lokasi' => $item->lokasi,
                'jumlah' => (int) $item->jumlah,
                'persentase' => round($persentase, 2) . '%',
            ];
        })
            // Urutkan dari persentase tertinggi
            ->sortByDesc('persentase')
            ->values();


        // response ke fe
        return response()->json([
            'total_valuasi' => $totalValuation ?? 0,
            'total_units' => $totalUnits ?? 0,
            'units_rusak_berat' => $unitsRusakBerat ?? 0,
            'kondisi_data' => $kondisiData,
            'lokasi_data' => $lokasiData
        ]);
    }
}
