<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
