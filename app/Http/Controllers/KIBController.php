<?php

namespace App\Http\Controllers;

use App\Models\kib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KIBController extends Controller
{
    public function kib()
    {
        kib::latest()->get();

        return response()->json([
            'message' => 'KIB Berhasil Diambil',
            'data' => kib::all()
        ]);
    }

    public function show($id)
    {
        $data = kib::find($id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['status' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'type_kib' => 'required|in:tanah,mesin,gedung',
            'nibar' => 'required|numeric',
            'no_register' => 'required|numeric',
            'spesifikasi' => 'required',
            'spesifikasi_tambahan' => 'nullable',
            'lokasi' => 'required',
            'no_mesin' => 'nullable',
            'no_rangka' => 'nullable',
            'no_pabrik' => 'nullable',
            'ukuran' => 'nullable',
            'status_tanah' => 'nullable',
            'no_sertifikat' => 'nullable',
            'kontruksi' => 'nullable',
            'luas_lantai' => 'nullable',
            'no_dokumen' => 'nullable',
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'nilai_perolehan' => 'required|numeric',
            'status_penggunaan' => 'required',
            'keterangan' => 'nullable',
        ]);

        // Convert empty string to null
        foreach ($validated as $key => $value) {
            if ($value === "" || $value === "null") {
                $validated[$key] = null;
            }
        }

        $validated['user_id'] = Auth::id();

        // upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kib', 'public');
        }

        $data = KIB::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menambahkan data',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = kib::find($id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'type_kib' => 'required|in:tanah,mesin,gedung',
            'nibar' => 'required|numeric',
            'no_register' => 'required|numeric',
            'spesifikasi' => 'required',
            'spesifikasi_tambahan' => 'nullable',
            'lokasi' => 'required',
            'no_mesin' => 'nullable',
            'no_rangka' => 'nullable',
            'no_pabrik' => 'nullable',
            'ukuran' => 'nullable',
            'status_tanah' => 'nullable',
            'no_sertifikat' => 'nullable',
            'kontruksi' => 'nullable',
            'luas_lantai' => 'nullable',
            'no_dokumen' => 'nullable',
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'nilai_perolehan' => 'required|numeric',
            'status_penggunaan' => 'required',
            'keterangan' => 'nullable',
        ]);

        // Convert empty string to null
        foreach ($validated as $key => $value) {
            if ($value === "" || $value === "null") {
                $validated[$key] = null;
            }
        }

        $validated['user_id'] = Auth::id();

        // upload gambar jika ada file baru
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kib', 'public');
        }

        $data->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengubah data',
            'data' => $data
        ]);
    }


    public function destroy($id)
    {
        $data = kib::find($id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menghapus data'
        ]);
    }
}
