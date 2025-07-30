<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Article;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRemainingImagesArticle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
           public function handle(Request $request, Closure $next): Response
        {
            $idArticle = $request->route('article');

            // Ambil jumlah gambar yang tersisa
            $article = Article::with('gambar_articles')->findOrFail($idArticle);
            $remainingImagesCount = $article->gambar_articles->count();

            // Periksa apakah gambar yang tersisa hanya satu atau kurang
            if ($remainingImagesCount <= 1) {
                return back()->withErrors(['error' => 'Setidaknya sisakan 1 gambar']);
            }
            return $next($request);
        }

}
