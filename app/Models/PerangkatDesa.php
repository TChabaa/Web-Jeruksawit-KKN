<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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
        'created_by',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($perangkatDesa) {
            // Delete associated image from storage before deleting the record
            if ($perangkatDesa->gambar && Storage::disk('public')->exists($perangkatDesa->gambar)) {
                Storage::disk('public')->delete($perangkatDesa->gambar);
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
}
