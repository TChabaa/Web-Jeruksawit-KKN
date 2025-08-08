<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Destination;
use App\Models\User;
use App\Models\Surat;
use App\Models\PerangkatDesa;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function writer()
    {
        $totalArticle = Article::where('author_id', Auth::user()->id)->count();

        // Mengambil 5 artikel dengan views terbanyak
        $articles = Article::where('author_id', Auth::user()->id)->orderBy('views', 'desc')->take(5)->get();

        $articleLabels = $articles->pluck('title');
        $articleData = $articles->pluck('views');

        $dataArticle = [
            'articleLabels' => $articleLabels,
            'articleData' => $articleData
        ];

        return view('components.pages.dashboard.index', compact('totalArticle', 'dataArticle'));
    }

    public function owner()
    {
        $totalDestination = Destination::where('owner_id', Auth::user()->id)->count();

        // Mengambil 5 wisata dengan views terbanyak
        $destinations = Destination::where('owner_id', Auth::user()->id)->orderBy('views', 'desc')->take(5)->get();

        $destinationLabels = $destinations->pluck('name');
        $destinationData = $destinations->pluck('views');

        $dataDestination = [
            'destinationLabels' => $destinationLabels,
            'destinationData' => $destinationData
        ];

        return view('components.pages.dashboard.index', compact('totalDestination', 'dataDestination'));
    }

    public function admin()
    {
        $totalArticle = Article::count();
        $totalDestination = Destination::count();
        $totalUser = User::where('role', '!=', 'super_admin')->count();
        $totalSurat = Surat::count();
        $totalPerangkatDesa = PerangkatDesa::count();

        // Mengambil 5 acara dengan views terbanyak

        // Mengambil 5 wisata dengan views terbanyak
        $destinations = Destination::orderBy('views', 'desc')->take(5)->get();

        $destinationLabels = $destinations->pluck('name');
        $destinationData = $destinations->pluck('views');

        $dataDestination = [
            'destinationLabels' => $destinationLabels,
            'destinationData' => $destinationData
        ];

        // Mengambil 5 artikel dengan views terbanyak
        $articles = Article::orderBy('views', 'desc')->take(5)->get();

        $articleLabels = $articles->pluck('title');
        $articleData = $articles->pluck('views');

        $dataArticle = [
            'articleLabels' => $articleLabels,
            'articleData' => $articleData
        ];

        // Mengambil data surat berdasarkan jenis untuk grafik
        $suratByJenis = JenisSurat::withCount('surat')->orderBy('surat_count', 'desc')->get();

        $suratLabels = $suratByJenis->pluck('nama_jenis');
        $suratData = $suratByJenis->pluck('surat_count');

        $dataSurat = [
            'suratLabels' => $suratLabels,
            'suratData' => $suratData
        ];

        return view('components.pages.dashboard.index', compact('totalDestination', 'totalArticle', 'totalUser', 'totalSurat', 'totalPerangkatDesa', 'dataArticle', 'dataDestination', 'dataSurat'));
    }

    public function superAdmin()
    {
        $totalArticle = Article::count();
        $totalDestination = Destination::count();
        $totalUser = User::count();
        $totalSurat = Surat::count();
        $totalPerangkatDesa = PerangkatDesa::count();

        // Mengambil 5 acara dengan views terbanyak

        // Mengambil 5 wisata dengan views terbanyak
        $destinations = Destination::orderBy('views', 'desc')->take(5)->get();

        $destinationLabels = $destinations->pluck('name');
        $destinationData = $destinations->pluck('views');

        $dataDestination = [
            'destinationLabels' => $destinationLabels,
            'destinationData' => $destinationData
        ];

        // Mengambil 5 artikel dengan views terbanyak
        $articles = Article::orderBy('views', 'desc')->take(5)->get();

        $articleLabels = $articles->pluck('title');
        $articleData = $articles->pluck('views');

        $dataArticle = [
            'articleLabels' => $articleLabels,
            'articleData' => $articleData
        ];

        // Mengambil data surat berdasarkan jenis untuk grafik
        $suratByJenis = JenisSurat::withCount('surat')->orderBy('surat_count', 'desc')->get();

        $suratLabels = $suratByJenis->pluck('nama_jenis');
        $suratData = $suratByJenis->pluck('surat_count');

        $dataSurat = [
            'suratLabels' => $suratLabels,
            'suratData' => $suratData
        ];

        return view('components.pages.dashboard.index', compact('totalDestination', 'totalArticle', 'totalUser', 'totalSurat', 'totalPerangkatDesa', 'dataArticle', 'dataDestination', 'dataSurat'));
    }
}
