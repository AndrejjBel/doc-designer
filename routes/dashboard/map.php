<?php

use App\Middlewares\{
    DashboardMiddleware,
    Admin\AdminMiddleware
};

use App\Controllers\{
    Admin\AdminController,
    Admin\UsersController,
    Admin\UserAddController,
    Admin\UserEditController,
    Admin\UploadController
};

Route::toGroup()->prefix('dashboard')->middleware(DashboardMiddleware::class);
    // Route::get('/')->controller(AdminController::class, 'dashboard')->name('dashboard.generale');
    Route::get('/user-settings')->controller(AdminController::class, 'user_settings_dashboard')->name('dashboard.user-settings');
    Route::get('/user-orders')->controller(AdminController::class, 'user_orders_dashboard')->name('dashboard.user-orders');
Route::endGroup();
