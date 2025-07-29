<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $table = 'umkm';
    protected $primaryKey = 'id';
    public $timestamps = true;

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

    public function gambarArticle()
    {
        return $this->hasMany(GambarArticle::class, 'id');
    }

}
