<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactUmkm extends Model
{
    use HasFactory;

    protected $table = 'contact_umkm';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_umkm',
        'nomor',
        'email',
        'sosial_media',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }
}
