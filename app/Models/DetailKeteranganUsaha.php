<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailKeteranganUsaha extends Model
{
    use HasFactory;

    protected $table = 'detail_keterangan_usaha';
    protected $primaryKey = 'id_detail_usaha';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'mulai_usaha',
        'jenis_usaha',
        'alamat_usaha',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
