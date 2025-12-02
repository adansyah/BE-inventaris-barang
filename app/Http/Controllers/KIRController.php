<?php

namespace App\Http\Controllers;

use App\Models\kib;
use App\Models\kir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KIRController extends Controller
{
    public function Kir()
    {
        $kirs = kir::all();

        foreach ($kirs as $kir) {
            if ($kir->gambar_qr) {
                $kir->gambar_qr = url('storage/' . $kir->gambar_qr);
            }
        }

        return response()->json([
            'message' => 'Kir Berhasil Diambil',
            'data' => $kirs
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kib_id' => 'required',
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'tahun' => 'required',
            'lokasi_ruangan' => 'required',
            'jumlah' => 'required',
            'nilai_perolehan' => 'required'
        ]);

        // Simpan data biasa
        $item = kir::create([
            'user_id' => Auth::id(),
            'kib_id' => $request->kib_id,
            'nama_barang' => $request->nama_barang,
            'kode_barang' => $request->kode_barang,
            'tahun' => $request->tahun,
            'lokasi_ruangan' => $request->lokasi_ruangan,
            'kondisi' => $request->kondisi ?? 'baik',
            'jumlah' => $request->jumlah,
            'nilai_perolehan' => $request->nilai_perolehan,
        ]);

        $validated['user_id'] = Auth::id();

        // ------------------------------------------------
        // GENERATE QR CODE (isi QR = URL detail API)
        // ------------------------------------------------
        $qrData = url('/kir/' . $item->id);  // URL untuk scan QR

        // Simpan ke storage/public/qrcodes
        $qrName = 'qr_' . time() . '_' . $item->id . '.svg';
        $qrPath = 'qrcodes/' . $qrName;

        $qrImage = QrCode::format('svg')->size(300)->generate($qrData);
        Storage::disk('public')->put($qrPath, $qrImage);

        // Update field gambar_qr
        $item->update([
            'gambar_qr' => $qrPath
        ]);

        return response()->json([
            'message' => 'Data berhasil disimpan dan QR telah dibuat',
            'data' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = kir::findOrFail($id);

        $validated = $request->validate([
            'kib_id' => 'required',
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'tahun' => 'required',
            'lokasi_ruangan' => 'required',
            'jumlah' => 'required',
            'nilai_perolehan' => 'required'
        ]);

        // Update data tanpa menyentuh gambar_qr
        $item->update([
            'kib_id' => $request->kib_id,
            'nama_barang' => $request->nama_barang,
            'kode_barang' => $request->kode_barang,
            'tahun' => $request->tahun,
            'lokasi_ruangan' => $request->lokasi_ruangan,
            'kondisi' => $request->kondisi ?? $item->kondisi,
            'jumlah' => $request->jumlah,
            'nilai_perolehan' => $request->nilai_perolehan,
            // gambar_qr TIDAK DIUBAH
        ]);

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $item
        ]);
    }


    public function show($id)
    {
        $kir = kir::findOrFail($id);

        if (!$kir) {
            return response()->json([
                'message' => 'Data KIR tidak ditemukan'
            ], 404);
        }

        // ubah path QR jadi URL publik
        if ($kir->gambar_qr) {
            $kir->gambar_qr = url('storage/' . $kir->gambar_qr);
        }
        return response()->json([
            'message' => 'Data KIR berhasil diambil',
            'data' => $kir
        ]);
    }

    public function destroy($id)
    {
        $item = kir::findOrFail($id);

        // Hapus file QR jika ada
        if ($item->gambar_qr && Storage::disk('public')->exists($item->gambar_qr)) {
            Storage::disk('public')->delete($item->gambar_qr);
        }

        $item->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
