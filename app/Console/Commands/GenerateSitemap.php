<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Article;
use App\Models\Destination;
use App\Models\Umkm;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml for Desa Jeruksawit website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting sitemap generation...');

        $sitemap = Sitemap::create();

        // Add static pages
        $this->addStaticPages($sitemap);

        // Add dynamic content
        $this->addDynamicContent($sitemap);

        // Write the sitemap to public directory
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at: ' . public_path('sitemap.xml'));

        return Command::SUCCESS;
    }

    /**
     * Add static pages to sitemap
     */
    private function addStaticPages(Sitemap $sitemap): void
    {
        $staticPages = [
            [
                'url' => route('index'),
                'priority' => 1.0,
                'changefreq' => 'daily',
                'lastmod' => Carbon::now()
            ],
            [
                'url' => route('destinations'),
                'priority' => 0.9,
                'changefreq' => 'weekly',
                'lastmod' => Carbon::now()
            ],
            [
                'url' => route('umkm'),
                'priority' => 0.9,
                'changefreq' => 'weekly',
                'lastmod' => Carbon::now()
            ],
            [
                'url' => route('articles'),
                'priority' => 0.8,
                'changefreq' => 'daily',
                'lastmod' => Carbon::now()
            ],
            [
                'url' => route('galleries'),
                'priority' => 0.7,
                'changefreq' => 'weekly',
                'lastmod' => Carbon::now()
            ],
            [
                'url' => route('about-us'),
                'priority' => 0.6,
                'changefreq' => 'monthly',
                'lastmod' => Carbon::now()
            ],
            [
                'url' => route('layanan-surat'),
                'priority' => 0.8,
                'changefreq' => 'monthly',
                'lastmod' => Carbon::now()
            ]
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create($page['url'])
                    ->setLastModificationDate($page['lastmod'])
                    ->setChangeFrequency($page['changefreq'])
                    ->setPriority($page['priority'])
            );
        }

        $this->info('Added ' . count($staticPages) . ' static pages');
    }

    /**
     * Add dynamic content to sitemap
     */
    private function addDynamicContent(Sitemap $sitemap): void
    {
        // Add destinations with images
        $destinations = Destination::with('galleries')->latest()->get();
        foreach ($destinations as $destination) {
            $url = Url::create(route('destinations.show', $destination->slug))
                ->setLastModificationDate($destination->updated_at)
                ->setChangeFrequency('monthly')
                ->setPriority(0.8);

            // Add images for destinations
            if ($destination->galleries && $destination->galleries->count() > 0) {
                foreach ($destination->galleries->take(5) as $gallery) { // Limit to 5 images
                    $imageUrl = asset('storage/' . $gallery->image_url);
                    $caption = $destination->name ?? 'Wisata Desa Jeruksawit';
                    $url->addImage($imageUrl, $caption);
                }
            }

            $sitemap->add($url);
        }
        $this->info('Added ' . $destinations->count() . ' destination pages');

        // Add UMKM with images
        $umkms = Umkm::with('gambarUmkm')->latest()->get();
        foreach ($umkms as $umkm) {
            $url = Url::create(route('umkm.show', $umkm->slug))
                ->setLastModificationDate($umkm->updated_at)
                ->setChangeFrequency('monthly')
                ->setPriority(0.7);

            // Add images for UMKM
            if ($umkm->gambarUmkm && $umkm->gambarUmkm->count() > 0) {
                foreach ($umkm->gambarUmkm->take(3) as $gambar) { // Limit to 3 images
                    $imageUrl = asset('storage/' . $gambar->image_url);
                    $caption = $umkm->name ?? 'UMKM Desa Jeruksawit';
                    $url->addImage($imageUrl, $caption);
                }
            }

            $sitemap->add($url);
        }
        $this->info('Added ' . $umkms->count() . ' UMKM pages');

        // Add articles with images
        $articles = Article::with('gambar_articles')->latest()->get();
        foreach ($articles as $article) {
            $url = Url::create(route('articles.show', $article->slug))
                ->setLastModificationDate($article->updated_at)
                ->setChangeFrequency('weekly')
                ->setPriority(0.6);

            // Add images for articles
            if ($article->gambar_articles && $article->gambar_articles->count() > 0) {
                foreach ($article->gambar_articles->take(3) as $gambar) { // Limit to 3 images
                    $imageUrl = asset('storage/' . $gambar->image_url);
                    $caption = $article->title ?? 'Artikel Desa Jeruksawit';
                    $url->addImage($imageUrl, $caption);
                }
            }

            $sitemap->add($url);
        }
        $this->info('Added ' . $articles->count() . ' article pages');

        // Add layanan surat forms
        $suratTypes = [
            'skck' => 'SKCK',
            'sktm' => 'SKTM',
            'belum-menikah' => 'Belum Menikah',
            'izin-keramaian' => 'Izin Keramaian',
            'keterangan-usaha' => 'Keterangan Usaha',
            'keterangan-kematian' => 'Keterangan Kematian',
            'keterangan-kelahiran' => 'Keterangan Kelahiran',
            'orang-yang-sama' => 'Orang yang Sama',
            'pindah-keluar' => 'Pindah Keluar',
            'domisili-instansi' => 'Domisili Instansi',
            'domisili-kelompok' => 'Domisili Kelompok',
            'domisili-orang' => 'Domisili Orang'
        ];

        foreach ($suratTypes as $type => $name) {
            $sitemap->add(
                Url::create(route('layanan-surat.form', $type))
                    ->setLastModificationDate(Carbon::now())
                    ->setChangeFrequency('yearly')
                    ->setPriority(0.5)
            );
        }
        $this->info('Added ' . count($suratTypes) . ' surat form pages');
    }
}
