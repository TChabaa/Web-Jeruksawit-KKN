<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';
    protected $primaryKey = 'id_umkm';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'alamat',
        'gmaps_url',
        'deskripsi',
        'views',
        'slug',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($umkm) {
            // Delete all associated images from storage before deleting the UMKM
            foreach ($umkm->gambarUmkm as $gambar) {
                if ($gambar->image_url && Storage::disk('public')->exists($gambar->image_url)) {
                    Storage::disk('public')->delete($gambar->image_url);
                }
            }
        });
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function gambarUmkm()
    {
        return $this->hasMany(GambarUmkm::class, 'id_umkm');
    }

    public function contactUmkm()
    {
        return $this->hasOne(ContactUmkm::class, 'id_umkm');
    }

    public function openingHours()
    {
        return $this->hasMany(OpeningHourUmkm::class, 'id_umkm');
    }
}
