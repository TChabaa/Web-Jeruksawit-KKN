<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarArticle extends Model
{
    use HasFactory;

    protected $table = 'gambar_artikels';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'article_id',
        'nama',
        'link',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
