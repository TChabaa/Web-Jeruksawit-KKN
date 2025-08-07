<?php

namespace App\Models;

use App\Models\Gallery;
use App\Models\Facility;
use App\Models\OpeningHour;
use App\Models\Accommodation;
use App\Models\ContactDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'location',
        'gmaps_url',
        'price_range',
        'status',
        'views',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($destination) {
            // Delete all associated images from storage before deleting the destination
            foreach ($destination->galleries as $gallery) {
                if ($gallery->image_url && Storage::disk('public')->exists($gallery->image_url)) {
                    Storage::disk('public')->delete($gallery->image_url);
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function openingHours()
    {
        return $this->hasMany(OpeningHour::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }

    public function contactDetail()
    {
        return $this->hasOne(ContactDetail::class);
    }
}
