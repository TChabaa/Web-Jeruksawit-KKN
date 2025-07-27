<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GambarUmkm extends Model
{
    use HasFactory;

    protected $table = 'gambar_umkm';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_umkm',
        'nama',
        'link',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }
}
