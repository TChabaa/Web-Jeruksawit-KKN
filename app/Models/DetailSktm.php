<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailSktm extends Model
{
    use HasFactory;

    protected $table = 'detail_sktm';
    protected $primaryKey = 'id_detail_sktm';
    public $timestamps = false;

    protected $fillable = [
        'id_surat',
        'pendidikan',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
