<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpeningHourUmkm extends Model
{
    use HasFactory;

    protected $table = 'opening_hour_umkm';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_umkm',
        'day',
        'open',
        'close',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }
}
