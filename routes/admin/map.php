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
    Admin\ProductsController,
    Admin\ProductAddController,
    Admin\ProductEditController,
    Admin\PagesController,
    Admin\AdminOrdersController,
    Admin\UploadController,
    Admin\VarsController
};

Route::toGroup()->prefix('admin')->middleware(AdminMiddleware::class);
    // Route::get('/')->controller(AdminController::class)->name('admin.generale');

    Route::get('/pages')->controller(PagesController::class)->name('admin.pages');
    Route::get('/page-add')->controller(PagesController::class, 'page_add')->name('admin.page-add');
    Route::get('/page-edit')->controller(PagesController::class, 'page_edit')->name('admin.page-edit');

    Route::get('/products')->controller(ProductsController::class)->name('admin.products');
    Route::get('/products-group')->controller(ProductsController::class, 'products_group')->name('admin.products-group');
    Route::get('/product-add')->controller(ProductsController::class, 'product_add')->name('admin.product-add');
    Route::get('/product-edit')->controller(ProductsController::class, 'product_edit')->name('admin.product-edit');

    Route::get('/vars/{id}/')->controller(VarsController::class, 'vars_item')->name('admin.var');
    Route::get('/vars-group')->controller(VarsController::class, 'vars_group')->name('admin.vars-group');
    Route::get('/vars-add')->controller(VarsController::class, 'vars_add')->name('admin.vars-add');

    Route::get('/orders')->controller(AdminController::class, 'orders')->name('admin.orders');
    Route::get('/orders-documents')->controller(AdminController::class, 'orders_documents')->name('admin.orders-documents');
    Route::get('/doc-order')->controller(AdminController::class, 'doc_order')->name('admin.doc-order');

    Route::get('/settings')->controller(AdminController::class, 'admin_settings')->name('admin.settings');
    Route::get('/settings-pay')->controller(AdminController::class, 'admin_settings_pay')->name('admin.settings-pay');

    Route::get('/user-settings')->controller(AdminController::class, 'user_settings')->name('admin.user-settings');
    Route::get('/user-orders')->controller(AdminController::class, 'user_orders_admin')->name('admin.user-orders');
    Route::get('/users')->controller(UsersController::class)->name('admin.users');
    Route::get('/users-admins')->controller(UsersController::class, 'users_admins')->name('admin.users-admins');
    Route::get('/users-lawyers')->controller(UsersController::class, 'users_lawyers')->name('admin.users-lawyers');
    Route::get('/user-add')->controller(UserAddController::class)->name('admin.user-add');

    Route::post('/settings-post')
        ->protect()
        ->controller(AdminController::class, 'site_settings');

    Route::post('/settings-post-pay')
        ->protect()
        ->controller(AdminController::class, 'site_settings_pay');

    Route::post('/upload-doc')->controller(UploadController::class, 'uploadDocs');
Route::endGroup();
