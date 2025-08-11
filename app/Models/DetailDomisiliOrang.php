<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailDomisiliOrang extends Model
{
    use HasFactory;

    protected $table = 'detail_domisili_orang';
    protected $primaryKey = 'id_detail_domisili_orang';
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
