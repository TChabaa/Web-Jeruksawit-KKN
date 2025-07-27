<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPindahKeluar extends Model
{
    use HasFactory;

    protected $table = 'detail_pindah_keluar';
    protected $primaryKey = 'id_detail_pindah';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'alamat_tujuan',
        'alasan_pindah',
        'tanggal_pindah',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }

    public function anggotaPindah()
    {
        return $this->hasMany(AnggotaPindah::class, 'id_detail_pindah');
    }
}
