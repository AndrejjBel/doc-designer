<?php

use App\Middlewares\{
    DashboardMiddleware,
    Auth\AuthMiddleware,
    Admin\AdminMiddleware
};

use App\Controllers\{
    AdminFetchController,
    FrontFetchController,
    PayCallbackController,
    Admin\UsersController,
    Admin\UserAddController,
    Admin\UserEditController,
    Admin\UploadController
};

Route::toGroup()->protect();
    Route::post('/users-admin')->controller(UsersController::class);
    Route::post('/user-admin-add')->controller(UserAddController::class, 'addUser');
    Route::post('/user-admin-edit')->controller(UserEditController::class, 'editUser');
    Route::post('/user-meta-edit')->controller(UserEditController::class, 'editUserMeta');
    Route::post('/user-pass-edit')->controller(UserEditController::class, 'editUserPass');
    Route::post('/user-pass-edit-admin')->controller(UserEditController::class, 'adminEditUserPass');

    Route::post('/admin/upload')->controller(UploadController::class, 'uploadFiles');
    Route::post('/admin/delete')->controller(UploadController::class, 'deleteFiles');

    Route::post('/admin/fetch')->controller(AdminFetchController::class);

    Route::post('/front/fetch')->controller(FrontFetchController::class);

    Route::post('/paycallback')->controller(PayCallbackController::class, 'payCallback');
Route::endGroup();
