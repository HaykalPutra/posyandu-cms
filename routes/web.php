<?php

use App\Http\Controllers\Cms\AuthController;
use App\Http\Controllers\Cms\CarouselItemController;
use App\Http\Controllers\Cms\CmsPageController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\GalleryItemController;
use App\Http\Controllers\Cms\HomeStatController;
use App\Http\Controllers\Cms\OrgGroupController;
use App\Http\Controllers\Cms\OrgMemberController;
use App\Http\Controllers\Cms\PasswordResetController;
use App\Http\Controllers\Cms\PostController;
use App\Http\Controllers\Cms\ScheduleController;
use App\Http\Controllers\Cms\SiteSettingController;
use App\Http\Controllers\Cms\TrashController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/media/{mediaAsset}', [MediaController::class, 'show'])->name('media.show');
Route::get('/', [PublicPageController::class, 'home'])->name('beranda');
Route::get('/berita', [PublicPageController::class, 'berita'])->name('berita');
Route::get('/berita/{post:slug}', [PublicPageController::class, 'beritaShow'])->name('berita.show');
Route::get('/galeri', [PublicPageController::class, 'galeri'])->name('galeri');
Route::get('/dokumentasi', [PublicPageController::class, 'page'])->defaults('slug', 'dokumentasi')->name('dokumentasi');
Route::get('/struktur', [PublicPageController::class, 'page'])->defaults('slug', 'struktur')->name('struktur');
Route::get('/tentang', [PublicPageController::class, 'page'])->defaults('slug', 'tentang')->name('tentang');
Route::get('/lokasi', [PublicPageController::class, 'page'])->defaults('slug', 'lokasi')->name('lokasi');

Route::prefix('cms')->group(function (): void {
	Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
	Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->middleware('throttle:3,1')->name('password.email');
	Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
	Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::prefix('cms')->name('cms.')->group(function (): void {
	Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
	Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');

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
		Route::resource('/carousel', CarouselItemController::class)->except(['show']);
		Route::resource('/schedules', ScheduleController::class)->except(['show']);
		Route::resource('/home-stats', HomeStatController::class)->except(['show']);
		Route::resource('/struktur', OrgGroupController::class)->except(['show']);
		Route::get('/struktur/{group}/members', [OrgMemberController::class, 'index'])->name('struktur.members.index');
		Route::get('/struktur/{group}/members/create', [OrgMemberController::class, 'create'])->name('struktur.members.create');
		Route::post('/struktur/{group}/members', [OrgMemberController::class, 'store'])->name('struktur.members.store');
		Route::get('/struktur/{group}/members/{member}/edit', [OrgMemberController::class, 'edit'])->name('struktur.members.edit');
		Route::put('/struktur/{group}/members/{member}', [OrgMemberController::class, 'update'])->name('struktur.members.update');
		Route::delete('/struktur/{group}/members/{member}', [OrgMemberController::class, 'destroy'])->name('struktur.members.destroy');

		Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
		Route::post('/trash/{type}/{id}/restore', [TrashController::class, 'restore'])->name('trash.restore');
		Route::delete('/trash/{type}/{id}', [TrashController::class, 'forceDelete'])->name('trash.force-delete');
	});
});
