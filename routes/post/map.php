<?php

use App\Middlewares\{
    DashboardMiddleware,
    Auth\AuthMiddleware,
    Admin\AdminMiddleware
};

use App\Controllers\{
    AdminFetchController,
    FrontFetchController,
    PaymentProcessController,
    DocCommentsController,
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
    Route::post('/user-admin-delete')->controller(UserEditController::class, 'deleteUser');

    Route::post('/admin/upload')->controller(UploadController::class, 'uploadFiles');
    Route::post('/admin/delete')->controller(UploadController::class, 'deleteFiles');

    Route::post('/admin/fetch')->controller(AdminFetchController::class);
    Route::post('/admin/doc-comments')->controller(DocCommentsController::class);

    Route::post('/front/fetch')->controller(FrontFetchController::class);

    Route::post('/paylink')->controller(PaymentProcessController::class, 'getPayLink');
    // Route::post('/paycallback')->controller(PaymentProcessController::class, 'payCallback');
Route::endGroup();

Route::post('/paycallback')->controller(PaymentProcessController::class, 'payCallback');

Route::post('/paycallbacktt')->controller(PaymentProcessController::class, 'payCallbackTest');
