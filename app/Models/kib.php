<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class kib extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'kode_barang',
        'nama_barang',
        'nibar',
        'no_register',
        'spesifikasi',
        'spesifikasi_tambahan',
        'lokasi',
        'no_polisi',
        'no_rangka',
        'no_bpkb',
        'jumlah',
        'harga_satuan',
        'nilai_perolehan',
        'status_penggunaan',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kib()
    {
        return $this->hasMany(kib::class);
    }
}
