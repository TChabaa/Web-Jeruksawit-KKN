<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';
    protected $primaryKey = 'id_surat';
    public $timestamps = true;

    protected $fillable = [
        'id_pemohon',
        'id_jenis',
        'nomor_surat',
        'tanggal_surat',
        'created_by',
    ];

    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class, 'id_pemohon');
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'id_jenis');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
