<?php

namespace App\Models;

use App\Models\User;
use App\Models\GambarArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'content',
        'views',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($article) {
            // Delete all associated images from storage before deleting the article
            foreach ($article->gambar_articles as $gambar) {
                if ($gambar->image_url && Storage::disk('public')->exists($gambar->image_url)) {
                    Storage::disk('public')->delete($gambar->image_url);
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function gambar_articles()
    {
        return $this->hasMany(GambarArticle::class);
    }
}
