<?php

namespace App\Http\Middleware;

use App\Models\Umkm;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRemainingImagesUmkm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $idUmkm = $request->route('umkm');

        // Ambil jumlah gambar yang tersisa
        $umkm = Umkm::with('gambarUmkm')->findOrFail($idUmkm);
        $remainingImagesCount = $umkm->gambarUmkm->count();

        // Periksa apakah gambar yang tersisa hanya satu atau kurang
        if ($remainingImagesCount <= 1) {
            return back()->withErrors(['error' => 'Setidaknya sisakan 1 gambar']);
        }
        return $next($request);
    }
}
