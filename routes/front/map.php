<?php
use App\Controllers\{
    HomeController
};

Route::get('/')->controller(HomeController::class)->name('homepage');
Route::get('/about')->controller(HomeController::class, 'about')->name('about');
Route::get('/services')->controller(HomeController::class, 'services')->name('services');
Route::get('/contact')->controller(HomeController::class, 'contact')->name('contact');
