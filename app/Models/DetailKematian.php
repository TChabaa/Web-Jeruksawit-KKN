<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailKematian extends Model
{
    use HasFactory;

    protected $table = 'detail_kematian';
    protected $primaryKey = 'id_detail_kematian';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'nama_almarhum',
        'nik_almarhum',
        'jenis_kelamin',
        'alamat',
        'umur',
        'hari_kematian',
        'tanggal_kematian',
        'tempat_kematian',
        'penyebab_kematian',
        'hubungan_pelapor',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
