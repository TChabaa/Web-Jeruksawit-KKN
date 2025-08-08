<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailKelahiran extends Model
{
    use HasFactory;

    protected $table = 'detail_kelahiran';
    protected $primaryKey = 'id_detail_kelahiran';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'nama_anak',
        'jenis_kelamin_anak',
        'hari_lahir',
        'tanggal_lahir',
        'tempat_lahir',
        'penolong_kelahiran',
        'ibu',
        'ayah'

    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
