<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;


// Media fallback route
Route::get('/media-file/{path}', function ($path) {
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
})->where('path', '.*')->name('media.file');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('admin/components', function () {
    return Inertia::render('Admin/Components/Components');
})->middleware(['auth', 'verified'])->name('admin.components');

// Services routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/services', [ServiceController::class, 'index'])->name('admin.services.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
});

// Projects routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('admin.projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy');
});

// Blogs routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('admin.blogs.index');
    Route::post('/blogs', [\App\Http\Controllers\BlogController::class, 'store'])->name('admin.blogs.store');
    Route::put('/blogs/{blog}', [\App\Http\Controllers\BlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/blogs/{blog}', [\App\Http\Controllers\BlogController::class, 'destroy'])->name('admin.blogs.destroy');
});

// Events routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('admin.events.index');
    Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('admin.events.store');
    Route::put('/events/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('admin.events.destroy');
});

// Board Members routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/board-members', [\App\Http\Controllers\BoardMemberController::class, 'index'])->name('admin.board-members.index');
    Route::post('/board-members', [\App\Http\Controllers\BoardMemberController::class, 'store'])->name('admin.board-members.store');
    Route::put('/board-members/{boardMember}', [\App\Http\Controllers\BoardMemberController::class, 'update'])->name('admin.board-members.update');
    Route::delete('/board-members/{boardMember}', [\App\Http\Controllers\BoardMemberController::class, 'destroy'])->name('admin.board-members.destroy');
});

// Partners routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/partners', [\App\Http\Controllers\PartnerController::class, 'index'])->name('admin.partners.index');
    Route::post('/partners', [\App\Http\Controllers\PartnerController::class, 'store'])->name('admin.partners.store');
    Route::put('/partners/{partner}', [\App\Http\Controllers\PartnerController::class, 'update'])->name('admin.partners.update');
    Route::delete('/partners/{partner}', [\App\Http\Controllers\PartnerController::class, 'destroy'])->name('admin.partners.destroy');
});

// Clients routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/clients', [\App\Http\Controllers\ClientController::class, 'index'])->name('admin.clients.index');
    Route::post('/clients', [\App\Http\Controllers\ClientController::class, 'store'])->name('admin.clients.store');
    Route::put('/clients/{client}', [\App\Http\Controllers\ClientController::class, 'update'])->name('admin.clients.update');
    Route::delete('/clients/{client}', [\App\Http\Controllers\ClientController::class, 'destroy'])->name('admin.clients.destroy');

    // Menus routes
    Route::get('/menus', [\App\Http\Controllers\MenuController::class, 'index'])->name('admin.menus.index');
    Route::post('/menus', [\App\Http\Controllers\MenuController::class, 'store'])->name('admin.menus.store');
    Route::put('/menus/{menu}', [\App\Http\Controllers\MenuController::class, 'update'])->name('admin.menus.update');
    Route::delete('/menus/{menu}', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('admin.menus.destroy');
    Route::post('/menus/reorder', [\App\Http\Controllers\MenuController::class, 'reorder'])->name('admin.menus.reorder');

    // Pages routes
    Route::get('/pages', [\App\Http\Controllers\PageController::class, 'index'])->name('admin.pages.index');
    Route::post('/pages', [\App\Http\Controllers\PageController::class, 'store'])->name('admin.pages.store');
    Route::put('/pages/{page}', [\App\Http\Controllers\PageController::class, 'update'])->name('admin.pages.update');
    Route::delete('/pages/{page}', [\App\Http\Controllers\PageController::class, 'destroy'])->name('admin.pages.destroy');

    // Themes routes
    Route::get('/themes', [\App\Http\Controllers\ThemeController::class, 'index'])->name('admin.themes.index');
    Route::post('/themes/{id}/activate', [\App\Http\Controllers\ThemeController::class, 'activate'])->name('admin.themes.activate');
    Route::post('/themes/{id}/deactivate', [\App\Http\Controllers\ThemeController::class, 'deactivate'])->name('admin.themes.deactivate');
    Route::post('/themes/sync', [\App\Http\Controllers\ThemeController::class, 'sync'])->name('admin.themes.sync');
});

// API routes for themes
Route::middleware(['auth', 'verified'])->prefix('api')->group(function () {
    Route::get('/themes/active/sections', [\App\Http\Controllers\ThemeController::class, 'getActiveSections'])->name('api.themes.active.sections');
});


require __DIR__ . '/settings.php';
