<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KegiatanRutin extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_rutin';
    protected $primaryKey = 'id_kegiatan';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'deskripsi',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function gambarKegiatan()
    {
        return $this->hasMany(GambarKegiatan::class, 'id_kegiatan');
    }
}
