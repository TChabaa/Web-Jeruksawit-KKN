<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GambarArticle extends Model
{
    use HasFactory;

    protected $table = 'gambar_articles';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'article_id',
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

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
