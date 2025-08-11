<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class GambarUmkm extends Model
{
    use HasFactory;

    protected $table = 'gambar_umkm';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_umkm',
        'image_url',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($gambar) {
            if ($gambar->image_url && Storage::disk('public')->exists($gambar->image_url)) {
                Storage::disk('public')->delete($gambar->image_url);
            }
        });
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }
}
