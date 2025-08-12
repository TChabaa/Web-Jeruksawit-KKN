<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\EmailQueueController;
use App\Http\Controllers\QRCodeController;


// Route untuk melihat bentuk PDF
Route::get('/view-pdf/{type}', function ($type) {
    $validTypes = [
        'skck',
        'izin-keramaian',
        'keterangan-usaha',
        'sktm',
        'belum-menikah',
        'keterangan-kematian',
        'keterangan-kelahiran',
        'orang-yang-sama',
        'pindah-keluar',
        'domisili-instansi',
        'domisili-kelompok',
        'domisili-orang'
    ];

    if (!in_array($type, $validTypes)) {
        abort(404, 'Jenis PDF tidak ditemukan');
    }

    // Sample data untuk preview
    $sampleData = [
        'nomor' => '474/001/VIII/2025',
        'tahun' => '2025',
        'nama_kepala' => 'MIDI',
        'nama' => 'CONTOH NAMA',
        'ttl' => 'Karanganyar, 01-01-1990',
        'ktp' => '3313130101900001',
        'kk' => '3313130101900001',
        'agama' => 'Islam',
        'pekerjaan' => 'Karyawan Swasta',
        'alamat' => 'Desa Jeruksawit, Kec. Gondangrejo, Kab. Karanganyar',
        'status' => 'Belum Kawin',
        'kewarganegaraan' => 'Indonesia',
        'tanggal' => now()->translatedFormat('d F Y'),

        // Data spesifik untuk setiap jenis surat
        'keperluan' => 'Untuk keperluan administrasi',
        'mulai' => '01-08-2025',
        'berakhir' => '01-09-2025',
        'jenis_hiburan' => 'Campursari',
        'tempat_acara' => 'Balai Desa Jeruksawit',
        'hari_acara' => 'Sabtu',
        'tanggal_acara' => '15 Agustus 2025',
        'jumlah_undangan' => '200',
        'mulai_usaha' => '01 Januari 2020',
        'jenis_usaha' => 'Warung Makan',
        'alamat_usaha' => 'Desa Jeruksawit',
        'pendidikan' => 'SMA',
        'penghasilan' => 'Rp 1.500.000',
        'jumlah_tanggungan' => '3',
        'nama_almarhum' => 'ALMARHUM CONTOH',
        'nik_almarhum' => '3313130101800001',
        'jenis_kelamin_almarhum' => 'Laki-laki',
        'alamat_almarhum' => 'Desa Jeruksawit',
        'umur' => '70',
        'hari_kematian' => 'Senin',
        'tanggal_kematian' => '01 Agustus 2025',
        'tempat_kematian' => 'Rumah Sakit',
        'penyebab_kematian' => 'Sakit',
        'hubungan_pelapor' => 'Anak',
        'nama_anak' => 'BAYI CONTOH',
        'jenis_kelamin_anak' => 'Laki-laki',
        'hari_lahir' => 'Senin',
        'tanggal_lahir_anak' => '01 Agustus 2025',
        'tempat_lahir_anak' => 'Rumah Sakit',
        'penolong_kelahiran' => 'Bidan',
        'nama1' => 'NAMA PERTAMA',
        'ttl1' => 'Karanganyar, 01-01-1990',
        'nik1' => '3313130101900001',
        'alamat1' => 'Desa Jeruksawit',
        'nama2' => 'NAMA KEDUA',
        'ttl2' => 'Karanganyar, 01-01-1990',
        'ayah1' => 'NAMA AYAH',
        'ayah2' => 'NAMA AYAH',
        'buku_nikah' => 'Akta Nikah No. 123',
        'alamat_tujuan' => 'Surakarta',
        'alasan_pindah' => 'Pekerjaan',
        'tanggal_pindah' => '01 September 2025',
        'nama_instansi' => 'PT CONTOH INDONESIA',
        'nama_pimpinan' => 'PIMPINAN CONTOH',
        'nip_pimpinan' => '123456789',
        'email_pimpinan' => 'pimpinan@contoh.com',
        'alamat_instansi' => 'Jl. Contoh No. 1',
        'keterangan_lokasi' => 'Bersebelahan dengan Balai Desa',
        'nama_kelompok' => 'KELOMPOK CONTOH',
        'alamat_kelompok' => 'Desa Jeruksawit',
        'ketua' => 'KETUA CONTOH',
        'email_ketua' => 'ketua@contoh.com',
        'sekretaris' => 'SEKRETARIS CONTOH',
        'bendahara' => 'BENDAHARA CONTOH'
    ];

    $templateName = match ($type) {
        'skck' => 'skck_pdf',
        'izin-keramaian' => 'izin_keramaian_pdf',
        'keterangan-usaha' => 'keterangan_usaha_pdf',
        'sktm' => 'sktm_pdf',
        'belum-menikah' => 'belum_menikah_pdf',
        'keterangan-kematian' => 'keterangan_kematian_pdf',
        'keterangan-kelahiran' => 'keterangan_kelahiran_pdf',
        'orang-yang-sama' => 'orang_yang_sama_pdf',
        'pindah-keluar' => 'pindah_keluar_pdf',
        'domisili-instansi' => 'domisili_instansi_pdf',
        'domisili-kelompok' => 'domisili_kelompok_pdf',
        'domisili-orang' => 'domisili_orang_pdf',
        default => 'skck_pdf'
    };

    return view('components.surat.' . $templateName, $sampleData);
})->name('view-pdf');

Route::get('/verify/{suratId}', [QRCodeController::class, 'show'])->name('verify.qr');

Route::get('/articles', [FrontendController::class, 'articles'])->name('articles');
Route::get('/articles/{slug}/show', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/404', function () {
    return view('components.pages.frontend.page-not-found');
});

Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/destinations', [FrontendController::class, 'destinations'])->name('destinations');
Route::get('/destinations/{slug}/show', [DestinationController::class, 'show'])->middleware('check.destination.active')->name('destinations.show');

Route::get('/umkm', [FrontendController::class, 'umkm'])->name('umkm');
Route::get('/umkm/{slug}/show', [UmkmController::class, 'show'])->name('umkm.show');

Route::get('/galleries', [FrontendController::class, 'galleries'])->name('galleries');

// Layanan Surat Menyurat Routes
Route::get('/layanan-surat', [FrontendController::class, 'layananSurat'])->name('layanan-surat');
Route::get('/layanan-surat/{type}/form', [FrontendController::class, 'layananSuratForm'])->name('layanan-surat.form');
Route::post('/layanan-surat/{type}/submit', [FrontendController::class, 'layananSuratSubmit'])->name('layanan-surat.submit');

Route::middleware([
    'auth',
    'verified'
])->group(function () {

    // Super Admin
    Route::middleware([
        'role:super_admin'
    ])->name('super_admin.')->prefix('super-admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'superAdmin'])->name('dashboard');


        Route::post('/destinations/{destination}/galleries', [DestinationController::class, 'addGalleries'])->name('destinations.addGalleries');
        Route::post('/destinations/{destination}/facility', [DestinationController::class, 'storeFacility'])->name('destinations.storeFacility');
        Route::post('/destinations/{destination}/accommodation', [DestinationController::class, 'storeAccommodation'])->name('destinations.storeAccommodation');
        Route::put('/destinations/{destination}/operational', [DestinationController::class, 'updateOperational'])->name('destinations.updateOperational');
        Route::put('/destinations/{destination}/contact', [DestinationController::class, 'updateContactDetail'])->name('destinations.updateContactDetail');
        Route::delete('/destinations/{destination}/galleries/{gallery}', [DestinationController::class, 'destroyGallery'])->middleware('check.remaining.images')->name('destinations.destroyGallery');
        Route::delete('/destinations/{destination}/facilities/{facility}', [DestinationController::class, 'destroyFacility'])->name('destinations.destroyFacility');
        Route::delete('/destinations/{destination}/accommodations/{accommodation}', [DestinationController::class, 'destroyAccommodation'])->name('destinations.destroyAccommodation');
        Route::resource('destinations', DestinationController::class)->except([
            'show'
        ]);

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('prevent.superadmin.edit')->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->middleware('prevent.superadmin.update')->name('users.update');
        Route::post('/users', [UserController::class, 'store'])->middleware('prevent.superadmin.create')->name('users.store');
        Route::resource('users', UserController::class)->except([
            'show',
            'edit',
            'update',
            'store'
        ]);

        Route::resource('articles', ArticleController::class)->except([
            'show'
        ]);

        Route::post('/articles/{article}/gambar_articles', [ArticleController::class, 'addGambar'])->name('articles.addGambar');
        Route::delete('/articles/{article}/gambar_articles/{gambar_article}', [ArticleController::class, 'destroyGambar'])->middleware('check.remaining.images.article')->name('articles.destroyGambar');

        Route::resource('umkm', UmkmController::class)->except([
            'show'
        ]);
        Route::post('/umkm/{umkm}/galleries', [UmkmController::class, 'addGalleries'])->name('umkm.addGalleries');
        Route::delete('/umkm/{umkm}/galleries/{gallery}', [UmkmController::class, 'destroyGallery'])->middleware('check.remaining.images.umkm')->name('umkm.destroyGallery');
        Route::put('/umkm/{umkm}/contact', [UmkmController::class, 'updateContactDetail'])->name('umkm.updateContactDetail');
        Route::put('/umkm/{umkm}/operational', [UmkmController::class, 'updateOperational'])->name('umkm.updateOperational');

        Route::resource('perangkat-desa', \App\Http\Controllers\PerangkatDesaController::class)->except([
            'show'
        ]);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Layanan Surat Menyurat
        Route::get('/layanan-surat', [\App\Http\Controllers\LayananSuratController::class, 'index'])->name('layanan-surat');
        Route::get('/layanan-surat/create', [\App\Http\Controllers\LayananSuratController::class, 'create'])->name('layanan-surat.create');
        Route::get('/layanan-surat/{type}/form', [\App\Http\Controllers\LayananSuratController::class, 'showForm'])->name('layanan-surat.form');
        Route::post('/layanan-surat/{type}/submit', [\App\Http\Controllers\LayananSuratController::class, 'submitForm'])->name('layanan-surat.submit');
        Route::get('/layanan-surat/{id}/show', [\App\Http\Controllers\LayananSuratController::class, 'show'])->name('layanan-surat.show');
        Route::post('/layanan-surat/{id}/status', [\App\Http\Controllers\LayananSuratController::class, 'updateStatus'])->name('layanan-surat.status');
        Route::get('/layanan-surat/{id}/download-pdf', [\App\Http\Controllers\LayananSuratController::class, 'downloadPdf'])->name('layanan-surat.download-pdf');

        // Website Settings
        Route::get('/website-settings', [\App\Http\Controllers\Admin\WebsiteSettingController::class, 'index'])->name('website-settings.index');
        Route::put('/website-settings', [\App\Http\Controllers\Admin\WebsiteSettingController::class, 'update'])->name('website-settings.update');
    });

    // Admin
    Route::middleware([
        'role:admin'
    ])->name('admin.')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');


        Route::post('/destinations/{destination}/galleries', [DestinationController::class, 'addGalleries'])->name('destinations.addGalleries');
        Route::post('/destinations/{destination}/facility', [DestinationController::class, 'storeFacility'])->name('destinations.storeFacility');
        Route::post('/destinations/{destination}/accommodation', [DestinationController::class, 'storeAccommodation'])->name('destinations.storeAccommodation');
        Route::put('/destinations/{destination}/operational', [DestinationController::class, 'updateOperational'])->name('destinations.updateOperational');
        Route::put('/destinations/{destination}/contact', [DestinationController::class, 'updateContactDetail'])->name('destinations.updateContactDetail');
        Route::delete('/destinations/{destination}/galleries/{gallery}', [DestinationController::class, 'destroyGallery'])->middleware('check.remaining.images')->name('destinations.destroyGallery');
        Route::delete('/destinations/{destination}/facilities/{facility}', [DestinationController::class, 'destroyFacility'])->name('destinations.destroyFacility');
        Route::delete('/destinations/{destination}/accommodations/{accommodation}', [DestinationController::class, 'destroyAccommodation'])->name('destinations.destroyAccommodation');
        Route::resource('destinations', DestinationController::class)->except([
            'show'
        ]);

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('prevent.superadmin.edit')->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->middleware('prevent.superadmin.update')->name('users.update');
        Route::post('/users', [UserController::class, 'store'])->middleware('prevent.superadmin.create')->name('users.store');
        Route::resource('users', UserController::class)->except([
            'show',
            'edit',
            'update',
            'store'
        ]);

        Route::resource('articles', ArticleController::class)->except([
            'show'
        ]);
        Route::post('/articles/{article}/gambar_articles', [ArticleController::class, 'addGambar'])->name('articles.addGambar');
        Route::delete('/articles/{article}/gambar_articles/{gambar_article}', [ArticleController::class, 'destroyGambar'])->middleware('check.remaining.images.article')->name('articles.destroyGambar');


        Route::resource('umkm', UmkmController::class)->except([
            'show'
        ]);
        Route::post('/umkm/{umkm}/galleries', [UmkmController::class, 'addGalleries'])->name('umkm.addGalleries');
        Route::delete('/umkm/{umkm}/galleries/{gallery}', [UmkmController::class, 'destroyGallery'])->middleware('check.remaining.images.umkm')->name('umkm.destroyGallery');
        Route::put('/umkm/{umkm}/contact', [UmkmController::class, 'updateContactDetail'])->name('umkm.updateContactDetail');
        Route::put('/umkm/{umkm}/operational', [UmkmController::class, 'updateOperational'])->name('umkm.updateOperational');

        Route::resource('perangkat-desa', \App\Http\Controllers\PerangkatDesaController::class)->except([
            'show'
        ]);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Layanan Surat Menyurat - Admin Dashboard
        Route::get('/layanan-surat', [\App\Http\Controllers\LayananSuratController::class, 'index'])->name('layanan-surat');
        Route::get('/layanan-surat/create', [\App\Http\Controllers\LayananSuratController::class, 'create'])->name('layanan-surat.create');
        Route::get('/layanan-surat/{type}/form', [\App\Http\Controllers\LayananSuratController::class, 'showForm'])->name('layanan-surat.form');
        Route::post('/layanan-surat/{type}/submit', [\App\Http\Controllers\LayananSuratController::class, 'submitForm'])->name('layanan-surat.submit');
        Route::get('/layanan-surat/{id}/show', [\App\Http\Controllers\LayananSuratController::class, 'show'])->name('layanan-surat.show');
        Route::post('/layanan-surat/{id}/status', [\App\Http\Controllers\LayananSuratController::class, 'updateStatus'])->name('layanan-surat.status');
        Route::get('/layanan-surat/{id}/download-pdf', [\App\Http\Controllers\LayananSuratController::class, 'downloadPdf'])->name('layanan-surat.download-pdf');

        // Website Settings
        Route::get('/website-settings', [\App\Http\Controllers\Admin\WebsiteSettingController::class, 'index'])->name('website-settings.index');
        Route::put('/website-settings', [\App\Http\Controllers\Admin\WebsiteSettingController::class, 'update'])->name('website-settings.update');

        // Email Queue Management (cPanel Friendly)
        Route::get('/email-queue', [EmailQueueController::class, 'index'])->name('email-queue.index');
        Route::post('/email-queue/process', [EmailQueueController::class, 'processQueue'])->name('email-queue.process');
        Route::post('/email-queue/test', [EmailQueueController::class, 'testEmail'])->name('email-queue.test');
        Route::post('/email-queue/clear-failed', [EmailQueueController::class, 'clearFailedJobs'])->name('email-queue.clear-failed');
        Route::get('/email-queue/stats', [EmailQueueController::class, 'getStats'])->name('email-queue.stats');
    });

    // owner
    Route::middleware([
        'role:owner'
    ])->name('owner.')->prefix('owner')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'owner'])->name('dashboard');

        Route::post('/destinations/{destination}/galleries', [DestinationController::class, 'addGalleries'])->name('destinations.addGalleries');
        Route::post('/destinations/{destination}/facility', [DestinationController::class, 'storeFacility'])->name('destinations.storeFacility');
        Route::post('/destinations/{destination}/accommodation', [DestinationController::class, 'storeAccommodation'])->name('destinations.storeAccommodation');
        Route::put('/destinations/{destination}/operational', [DestinationController::class, 'updateOperational'])->name('destinations.updateOperational');
        Route::put('/destinations/{destination}/contact', [DestinationController::class, 'updateContactDetail'])->name('destinations.updateContactDetail');
        Route::delete('/destinations/{destination}/galleries/{gallery}', [DestinationController::class, 'destroyGallery'])->middleware('check.remaining.images')->name('destinations.destroyGallery');
        Route::delete('/destinations/{destination}/facilities/{facility}', [DestinationController::class, 'destroyFacility'])->name('destinations.destroyFacility');
        Route::delete('/destinations/{destination}/accommodations/{accommodation}', [DestinationController::class, 'destroyAccommodation'])->name('destinations.destroyAccommodation');
        Route::resource('destinations', DestinationController::class)->except([
            'show'
        ]);

        Route::resource('umkm', UmkmController::class)->except([
            'show'
        ]);
        Route::post('/umkm/{umkm}/galleries', [UmkmController::class, 'addGalleries'])->name('umkm.addGalleries');
        Route::delete('/umkm/{umkm}/galleries/{gallery}', [UmkmController::class, 'destroyGallery'])->middleware('check.remaining.images.umkm')->name('umkm.destroyGallery');
        Route::put('/umkm/{umkm}/contact', [UmkmController::class, 'updateContactDetail'])->name('umkm.updateContactDetail');
        Route::put('/umkm/{umkm}/operational', [UmkmController::class, 'updateOperational'])->name('umkm.updateOperational');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Layanan Surat Menyurat
        Route::get('/layanan-surat', [\App\Http\Controllers\LayananSuratController::class, 'index'])->name('layanan-surat');
        Route::get('/layanan-surat/{type}/form', [\App\Http\Controllers\LayananSuratController::class, 'showForm'])->name('layanan-surat.form');
        Route::post('/layanan-surat/{type}/submit', [\App\Http\Controllers\LayananSuratController::class, 'submitForm'])->name('layanan-surat.submit');

        // Website Settings
        Route::get('/website-settings', [\App\Http\Controllers\Admin\WebsiteSettingController::class, 'index'])->name('website-settings.index');
        Route::put('/website-settings', [\App\Http\Controllers\Admin\WebsiteSettingController::class, 'update'])->name('website-settings.update');
    });

    // Writer
    Route::middleware([
        'role:writer'
    ])->name('writer.')->prefix('writer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'writer'])->name('dashboard');

        Route::resource('articles', ArticleController::class)->except([
            'show'
        ]);
        Route::post('/articles/{article}/gambar_articles', [ArticleController::class, 'addGambar'])->name('articles.addGambar');
        Route::delete('/articles/{article}/gambar_articles/{gambar_article}', [ArticleController::class, 'destroyGambar'])->middleware('check.remaining.images.article')->name('articles.destroyGambar');


        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Layanan Surat Menyurat
        Route::get('/layanan-surat', [\App\Http\Controllers\LayananSuratController::class, 'index'])->name('layanan-surat');
        Route::get('/layanan-surat/{type}/form', [\App\Http\Controllers\LayananSuratController::class, 'showForm'])->name('layanan-surat.form');
        Route::post('/layanan-surat/{type}/submit', [\App\Http\Controllers\LayananSuratController::class, 'submitForm'])->name('layanan-surat.submit');
    });
});

// QR Code verification routes (public access)
Route::get('/verify/{suratId}', [QRCodeController::class, 'show'])->name('qr.verify');
Route::get('/pdf/viewer/{suratId}', [PDFController::class, 'viewPdf'])->name('pdf.viewer');

// SEO Routes
Route::get('/sitemap.xml', [FrontendController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [FrontendController::class, 'robots'])->name('robots');

require __DIR__ . '/auth.php';
