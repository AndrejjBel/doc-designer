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
    Admin\AdminProductsController,
    Admin\ProductAddController,
    Admin\ProductEditController,
    Admin\AdminOrdersController,
    Admin\UploadController,
    Admin\VarsController
};

Route::toGroup()->prefix('admin')->middleware(AdminMiddleware::class);
    Route::get('/')->controller(AdminController::class)->name('admin.generale');

    Route::get('/vars/{id}/')->controller(VarsController::class, 'vars_item')->name('admin.var');
    Route::get('/vars-group')->controller(VarsController::class, 'vars_group')->name('admin.vars-group');
    Route::get('/vars-add')->controller(VarsController::class, 'vars_add')->name('admin.vars-add');

    Route::get('/settings')->controller(AdminController::class, 'admin_settings')->name('admin.settings');

    Route::get('/user-settings')->controller(AdminController::class, 'user_settings')->name('admin.user-settings');
    Route::get('/users')->controller(UsersController::class)->name('admin.users');
    Route::get('/user-add')->controller(UserAddController::class)->name('admin.user-add');

    Route::post('/settings-post')
        ->protect()
        ->controller(AdminController::class, 'site_settings');
Route::endGroup();
