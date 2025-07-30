<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
