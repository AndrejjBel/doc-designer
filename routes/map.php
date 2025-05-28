<?php
/*
 * Main file for creating a routing map.
 * Routes are recalculated when files in this folder are changed (with the 'routes.auto-update' parameter set).
 * To force updates of the routes cache, you need to run "php console --routes-upd".
 * Since the route map is cached, dynamically changing data is not applicable here.
 *
 * Основной файл для создания карты маршрутизации.
 * Маршруты обновляются при изменении файлов в этой папке (при установленном параметре 'routes.auto-update').
 * Для принудительного обновления кеша маршрутов необходимо выполнить «php console --routes-upd».
 * Так как карта маршрутов хранится в кеше, здесь не применимы динамически изменяющиеся данные.
*/

use App\Middlewares\{
    Auth\AuthMiddleware
};

use App\Controllers\{
    HomeController,
    Auth\LoginController,
    Auth\SigninController,
    Auth\VerifyController,
    Auth\RegController,
    Auth\AuthController,
    Auth\LogoutController,
    Auth\ForgotPassController
};

Route::toGroup()->middleware(AuthMiddleware::class);
    Route::get('/login')->controller(LoginController::class)->name('login');

    // Route::get('/signin')->controller(SigninController::class)->name('signin');
    // Route::get('/verify')->controller(VerifyController::class)->name('verify');
    // Route::get('/forgot-password')->controller(ForgotPassController::class, 'showPasswordForm')->name('forgot.password');

    Route::post('/login')->controller(AuthController::class);
    // Route::post('/signin')->controller(RegController::class);
    // Route::post('/forgot-password')->controller(ForgotPassController::class, 'passReset');
Route::endGroup();

Route::post('/logout')->controller(LogoutController::class);

require_once __DIR__ . '/front/map.php';
require_once __DIR__ . '/admin/map.php';
require_once __DIR__ . '/dashboard/map.php';
require_once __DIR__ . '/post/map.php';
