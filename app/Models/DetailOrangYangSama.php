<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailOrangYangSama extends Model
{
    use HasFactory;

    protected $table = 'detail_orang_yang_sama';
    protected $primaryKey = 'id_detail_orang_sama';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'nama_2',
        'tempat_lahir_2',
        'tanggal_lahir_2',
        'nama_ayah_2',
        'dasar_dokumen_1',
        'dasar_dokumen_2',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
