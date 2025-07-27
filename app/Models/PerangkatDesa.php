<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerangkatDesa extends Model
{
    use HasFactory;

    protected $table = 'perangkat_desa';
    protected $primaryKey = 'id_perangkat';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'jabatan',
        'gambar',
    ];
}
