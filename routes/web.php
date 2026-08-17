<?php

use App\Http\Controllers\Cms\AuthController;
use App\Http\Controllers\Cms\CmsPageController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\GalleryItemController;
use App\Http\Controllers\Cms\PostController;
use App\Http\Controllers\Cms\SiteSettingController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/media/{mediaAsset}', [MediaController::class, 'show'])->name('media.show');
Route::get('/', [PublicPageController::class, 'home'])->name('beranda');
Route::get('/berita', [PublicPageController::class, 'berita'])->name('berita');
Route::get('/galeri', [PublicPageController::class, 'galeri'])->name('galeri');
Route::get('/dokumentasi', [PublicPageController::class, 'page'])->defaults('slug', 'dokumentasi')->name('dokumentasi');
Route::get('/struktur', [PublicPageController::class, 'page'])->defaults('slug', 'struktur')->name('struktur');
Route::get('/tentang', [PublicPageController::class, 'page'])->defaults('slug', 'tentang')->name('tentang');
Route::get('/lokasi', [PublicPageController::class, 'page'])->defaults('slug', 'lokasi')->name('lokasi');

Route::prefix('cms')->name('cms.')->group(function (): void {
	Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
	Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

	Route::middleware('cms.auth')->group(function (): void {
		Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
		Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
		Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
		Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
		Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
		Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
		Route::resource('/pages', CmsPageController::class)->except(['show']);
		Route::resource('/posts', PostController::class)->except(['show']);
		Route::resource('/gallery', GalleryItemController::class)->except(['show']);
	});
});
