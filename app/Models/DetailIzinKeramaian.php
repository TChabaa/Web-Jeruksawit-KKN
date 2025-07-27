<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailIzinKeramaian extends Model
{
    use HasFactory;

    protected $table = 'detail_izin_keramaian';
    protected $primaryKey = 'id_detail_izin';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'keperluan',
        'jenis_hiburan',
        'tempat_acara',
        'hari_acara',
        'tanggal_acara',
        'jumlah_undangan',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
