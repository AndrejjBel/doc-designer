<?php
use App\Controllers\{
    HomeController,
    PagesFrontController,
    ProductsFrontController
};

Route::get('/')->controller(HomeController::class)->name('homepage');
// Route::get('/about')->controller(HomeController::class, 'about')->name('about');
// Route::get('/services')->controller(HomeController::class, 'services')->name('services');
// Route::get('/contact')->controller(HomeController::class, 'contact')->name('contact');

// Page
Route::get('/{slug}/')->controller(PagesFrontController::class, 'pages_item')->name('pages-item');

Route::get('/documents/{slug}/')->controller(ProductsFrontController::class, 'products_pages')->name('products-pages');
