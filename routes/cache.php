<?php 


Route::get('/cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return redirect()->back()->with('message', 'Cache cleared successfully');
})->name('cache.clear');