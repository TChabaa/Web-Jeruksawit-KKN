<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GambarKegiatan extends Model
{
    use HasFactory;

    protected $table = 'gambar_kegiatan';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_kegiatan',
        'nama',
        'link',
    ];

    public function kegiatanRutin()
    {
        return $this->belongsTo(KegiatanRutin::class, 'id_kegiatan');
    }
}
