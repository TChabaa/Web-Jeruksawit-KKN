<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemohon extends Model
{
    use HasFactory;

    protected $table = 'pemohon';
    protected $primaryKey = 'id_pemohon';
    public $timestamps = true;

    protected $fillable = [
        'nik',
        'nomor_kk',
        'nama_lengkap',
        'email',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'kewarganegaraan',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'alamat',
    ];

    public function surat()
    {
        return $this->hasMany(Surat::class, 'id_pemohon');
    }
}
