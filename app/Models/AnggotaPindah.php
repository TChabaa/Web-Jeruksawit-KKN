<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnggotaPindah extends Model
{
    use HasFactory;

    protected $table = 'anggota_pindah';
    protected $primaryKey = 'id_anggota_pindah';
    public $timestamps = false;

    protected $fillable = [
        'id_detail_pindah',
        'id_pemohon',
        'shdk',
    ];

    public function detailPindahKeluar()
    {
        return $this->belongsTo(DetailPindahKeluar::class, 'id_detail_pindah');
    }

    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class, 'id_pemohon');
    }
}
