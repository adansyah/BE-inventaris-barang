<?php

namespace App\Http\Controllers;

use App\Models\kib;
use App\Models\kir;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KIRController extends Controller
{
    public function Kir()
    {
        $kirs = kir::latest()->paginate(10)->get();

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
        $dataArray = $request->all(); // terima array

        foreach ($dataArray as $data) {

            $validated = validator($data, [
                'kib_id' => 'required',
                'nama_barang' => 'required',
                'kode_barang' => 'required',
                'tahun' => 'required',
                'lokasi' => 'required',
                'jumlah' => 'required',
                'nilai_perolehan' => 'required'
            ])->validate();

            $item = kir::create([
                'user_id' => Auth::id(),
                'kib_id' => $data['kib_id'],
                'nama_barang' => $data['nama_barang'],
                'kode_barang' => $data['kode_barang'],
                'tahun' => $data['tahun'],
                'lokasi' => $data['lokasi'],
                'kondisi' => $data['kondisi'] ?? 'baik',
                'jumlah' => $data['jumlah'],
                'nilai_perolehan' => $data['nilai_perolehan'],
            ]);

            // Generate QR
            $qrData = url('/kir/' . $item->id);
            $qrName = 'qr_' . time() . '_' . $item->id . '.svg';
            $qrPath = 'qrcodes/' . $qrName;

            $qrImage = \QrCode::format('svg')->size(300)->generate($qrData);
            Storage::disk('public')->put($qrPath, $qrImage);

            $item->update([
                'gambar_qr' => $qrPath
            ]);
        }

        return response()->json([
            'message' => 'Semua data berhasil disimpan!'
        ]);
    }


    public function update(Request $request, $id)
    {
        $kir = Kir::findOrFail($id);

        $validated = $request->validate([
            'kib_id' => 'required',
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'tahun' => 'required',
            'lokasi' => 'required',
            'kondisi' => 'required',
            'jumlah' => 'required|numeric',
            'nilai_perolehan' => 'required|numeric',
        ]);

        $kir->update([
            'kib_id' => $validated['kib_id'],
            'nama_barang' => $validated['nama_barang'],
            'kode_barang' => $validated['kode_barang'],
            'tahun' => $validated['tahun'],
            'lokasi' => $validated['lokasi'],
            'kondisi' => $validated['kondisi'],
            'jumlah' => $validated['jumlah'],
            'nilai_perolehan' => $validated['nilai_perolehan'],
        ]);

        return response()->json([
            'message' => 'Data KIR berhasil diperbarui',
            'data' => $kir
        ], 200);
    }



    public function show($id)
    {
        $kir = kir::with('kib')->findOrFail($id);

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

    public function printLabel(Request $request)
    {
        $request->validate([
            'ids' => 'required|array'
        ]);

        $items = Kir::with('kib')->whereIn('id', $request->ids)->get();

        $pdf = \PDF::loadView('pdf.label', compact('items'));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('label-aset.pdf');
    }

    public function tes()
    {
        $items = kir::all();
        return view('pdf.label', compact('items'));
    }
}
