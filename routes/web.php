<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;

Route::get('/articles', [FrontendController::class, 'articles'])->name('articles');
Route::get('/articles/{slug}/show', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/404', function () {
    return view('components.pages.frontend.page-not-found');
});

Route::get('/events', [FrontendController::class, 'events'])->name('events');
Route::get('/events/{slug}/show', [EventController::class, 'show'])->name('events.show');
Route::view('/about-us', 'components.pages.frontend.about-us-page')->name('about-us');

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/destinations', [FrontendController::class, 'destinations'])->name('destinations');
Route::get('/destinations/{slug}/show', [DestinationController::class, 'show'])->middleware('check.destination.active')->name('destinations.show');

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

        Route::resource('events', EventController::class)->except([
            'show'
        ]);

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
            'show', 'edit', 'update', 'store'
        ]);

        Route::resource('articles', ArticleController::class)->except([
            'show'
        ]);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Layanan Surat Menyurat
        Route::get('/layanan-surat', [\App\Http\Controllers\LayananSuratController::class, 'index'])->name('layanan-surat');
        Route::get('/layanan-surat/{type}/form', [\App\Http\Controllers\LayananSuratController::class, 'showForm'])->name('layanan-surat.form');
        Route::post('/layanan-surat/{type}/submit', [\App\Http\Controllers\LayananSuratController::class, 'submitForm'])->name('layanan-surat.submit');
    });

    // Admin
    Route::middleware([
        'role:admin'
    ])->name('admin.')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::resource('events', EventController::class)->except([
            'show'
        ]);

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
            'show', 'edit', 'update', 'store'
        ]);

        Route::resource('articles', ArticleController::class)->except([
            'show'
        ]);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Layanan Surat Menyurat
        Route::get('/layanan-surat', [\App\Http\Controllers\LayananSuratController::class, 'index'])->name('layanan-surat');
        Route::get('/layanan-surat/{type}/form', [\App\Http\Controllers\LayananSuratController::class, 'showForm'])->name('layanan-surat.form');
        Route::post('/layanan-surat/{type}/submit', [\App\Http\Controllers\LayananSuratController::class, 'submitForm'])->name('layanan-surat.submit');
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

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Layanan Surat Menyurat
        Route::get('/layanan-surat', [\App\Http\Controllers\LayananSuratController::class, 'index'])->name('layanan-surat');
        Route::get('/layanan-surat/{type}/form', [\App\Http\Controllers\LayananSuratController::class, 'showForm'])->name('layanan-surat.form');
        Route::post('/layanan-surat/{type}/submit', [\App\Http\Controllers\LayananSuratController::class, 'submitForm'])->name('layanan-surat.submit');
    });

    // Writer
    Route::middleware([
        'role:writer'
    ])->name('writer.')->prefix('writer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'writer'])->name('dashboard');

        Route::resource('articles', ArticleController::class)->except([
            'show'
        ]);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Layanan Surat Menyurat
        Route::get('/layanan-surat', [\App\Http\Controllers\LayananSuratController::class, 'index'])->name('layanan-surat');
        Route::get('/layanan-surat/{type}/form', [\App\Http\Controllers\LayananSuratController::class, 'showForm'])->name('layanan-surat.form');
        Route::post('/layanan-surat/{type}/submit', [\App\Http\Controllers\LayananSuratController::class, 'submitForm'])->name('layanan-surat.submit');
    });
});

require __DIR__ . '/auth.php';
