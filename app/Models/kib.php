<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class kib extends Model
{
    use HasFactory, HasApiTokens;


    protected $appends = ['gambar_url'];


    protected $fillable = [
        'user_id',
        'kode_barang',
        'nama_barang',
        'type_kib',
        'nibar',
        'no_register',
        'spesifikasi',
        'spesifikasi_tambahan',
        'lokasi',
        'no_rangka',
        'no_mesin',
        'no_pabrik',
        'ukuran',
        'status_tanah',
        'no_sertifikat',
        'kontruksi',
        'luas_lantai',
        'no_dokumen',
        'jumlah',
        'harga_satuan',
        'nilai_perolehan',
        'status_penggunaan',
        'keterangan',
        'gambar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kib()
    {
        return $this->hasMany(kib::class);
    }

    public function getGambarUrlAttribute()
    {
        return $this->gambar
            ? asset('storage/' . $this->gambar)
            : null;
    }
}
