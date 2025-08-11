<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailDomisiliKelompok extends Model
{
    use HasFactory;

    protected $table = 'detail_domisili_kelompok';
    protected $primaryKey = 'id_detail_domisili_kelompok';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'nama_kelompok',
        'email_ketua',
        'alamat_kelompok',
        'ketua',
        'sekretaris',
        'bendahara',
        'keterangan_lokasi',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
