<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailBelumMenikah extends Model
{
    use HasFactory;

    protected $table = 'detail_belum_menikah';
    protected $primaryKey = 'id_detail_belum_menikah';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'keperluan',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
