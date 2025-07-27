<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailSkck extends Model
{
    use HasFactory;

    protected $table = 'detail_skck';
    protected $primaryKey = 'id_detail_skck';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'keperluan',
        'tanggal_mulai_berlaku',
        'tanggal_akhir_berlaku',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
