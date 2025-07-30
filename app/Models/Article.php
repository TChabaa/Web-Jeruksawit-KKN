<?php

namespace App\Models;

use App\Models\User;
use App\Models\GambarArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function gambar_articles()
{
    return $this->hasMany(GambarArticle::class);
}

}
