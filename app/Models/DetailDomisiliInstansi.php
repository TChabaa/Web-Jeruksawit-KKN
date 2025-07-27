<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailDomisiliInstansi extends Model
{
    use HasFactory;

    protected $table = 'detail_domisili_instansi';
    protected $primaryKey = 'id_detail_domisili_instansi';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'nama_instansi',
        'nama_pimpinan',
        'nip_pimpinan',
        'email_pimpinan',
        'alamat_instansi',
        'keterangan_lokasi',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
