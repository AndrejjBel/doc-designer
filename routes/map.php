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
    DashboardMiddleware,
    Auth\AuthMiddleware,
    Admin\AdminMiddleware
};

use App\Controllers\{
    HomeController,
    DefaultController,
    ProductsController,
    FrontFetchController,
    Admin\AdminController,
    Admin\UsersController,
    Admin\UserAddController,
    Admin\UserEditController,
    Admin\AdminProductsController,
    Admin\ProductAddController,
    Admin\ProductEditController,
    Admin\AdminOrdersController,
    Admin\UploadController,
    Auth\LoginController,
    Auth\SigninController,
    Auth\VerifyController,
    Auth\RegController,
    Auth\AuthController,
    Auth\LogoutController,
    Auth\ForgotPassController
};

Route::get('/')->controller(HomeController::class)->name('homepage');
Route::get('/about')->controller(HomeController::class, 'about')->name('about');
Route::get('/services')->controller(HomeController::class, 'services')->name('services');
Route::get('/contact')->controller(HomeController::class, 'contact')->name('contact');

Route::get('/products')->controller(ProductsController::class)->name('products');
Route::get('/products/{post_slug}')->controller(ProductsController::class, 'product')->name('product');
Route::get('/cart')->controller(HomeController::class, 'cart')->name('cart');

Route::toGroup()->prefix('admin')->middleware(AdminMiddleware::class);
    Route::get('/')->controller(AdminController::class)->name('admin.generale');
    Route::get('/settings')->controller(AdminController::class, 'admin_settings')->name('admin.settings');
    Route::get('/user-settings')->controller(AdminController::class, 'user_settings')->name('admin.user-settings');
    Route::get('/users')->controller(UsersController::class)->name('admin.users');
    Route::get('/user-add')->controller(UserAddController::class)->name('admin.user-add');
    Route::get('/products')->controller(AdminProductsController::class)->name('admin.products');
    Route::get('/product-add')->controller(ProductAddController::class)->name('admin.product-add');
    Route::get('/product-edit')->controller(ProductEditController::class)->name('admin.product-edit');

    Route::get('/landings')->controller(AdminController::class, 'users_landings')->name('admin.landings');
    Route::get('/landing-add')->controller(AdminController::class, 'users_landing_add')->name('admin.landing-add');

    Route::get('/orders')->controller(AdminOrdersController::class)->name('admin.orders');
    Route::get('/order-add')->controller(AdminOrdersController::class, 'add_order')->name('admin.order-add');
    Route::get('/order-edit')->controller(AdminOrdersController::class, 'edit_order')->name('admin.order-edit');
    Route::post('/order-edit-status')
        ->protect()
        ->controller(AdminOrdersController::class, 'edit_order_status')
        ->name('admin.order-edit-status');
    Route::post('/settings-post')
        ->protect()
        ->controller(AdminController::class, 'site_settings');
Route::endGroup();

Route::toGroup()->prefix('dashboard')->middleware(DashboardMiddleware::class);
    Route::get('/')->controller(AdminController::class, 'dashboard')->name('dashboard.generale');
    // Route::get('/settings')->controller(AdminController::class, 'dashboard_settings')->name('dashboard.settings');
    Route::get('/user-settings')->controller(AdminController::class, 'user_settings_dashboard')->name('dashboard.user-settings');
    Route::get('/users')->controller(UsersController::class)->name('dashboard.users');
    Route::get('/user-add')->controller(UserAddController::class)->name('dashboard.user-add');
    Route::get('/products')->controller(AdminProductsController::class, 'dashboard')->name('dashboard.products');
    Route::get('/product-add')->controller(ProductAddController::class, 'dashboard')->name('dashboard.product-add');
    Route::get('/product-edit')->controller(ProductEditController::class, 'dashboard')->name('dashboard.product-edit');

    Route::get('/landing')->controller(AdminController::class, 'user_landing_dashboard')->name('admin.landing');

    Route::get('/orders')->controller(AdminOrdersController::class, 'dashboard')->name('dashboard.orders');
    Route::get('/order-add')->controller(AdminOrdersController::class, 'add_order')->name('dashboard.order-add');
    Route::get('/order-edit')->controller(AdminOrdersController::class, 'edit_order')->name('dashboard.order-edit');
    Route::post('/order-edit-status')
        ->protect()
        ->controller(AdminOrdersController::class, 'edit_order_status')
        ->name('dashboard.order-edit-status');
Route::endGroup();

Route::toGroup()->middleware(AuthMiddleware::class);
    Route::get('/login')->controller(LoginController::class)->name('login');
    // Route::get('/signin')->controller(SigninController::class)->name('signin');
    // Route::get('/verify')->controller(VerifyController::class)->name('verify');
    // Route::get('/forgot-password')->controller(ForgotPassController::class, 'showPasswordForm')->name('forgot.password');

    Route::post('/login')->controller(AuthController::class);
    // Route::post('/signin')->controller(RegController::class);
    // Route::post('/forgot-password')->controller(ForgotPassController::class, 'passReset');
Route::endGroup();

Route::toGroup()->protect();
    Route::post('/users-admin')->controller(UsersController::class);
    Route::post('/user-admin-add')->controller(UserAddController::class, 'addUser');
    Route::post('/user-admin-edit')->controller(UserEditController::class, 'editUser');
    Route::post('/user-meta-edit')->controller(UserEditController::class, 'editUserMeta');
    Route::post('/user-pass-edit')->controller(UserEditController::class, 'editUserPass');
    Route::post('/user-pass-edit-admin')->controller(UserEditController::class, 'adminEditUserPass');
    Route::post('/product-admin-add')->controller(ProductAddController::class, 'addProduct');
    Route::post('/product-admin-edit')->controller(ProductEditController::class, 'editProduct');

    Route::post('/admin/upload')->controller(UploadController::class, 'uploadFiles');
    Route::post('/admin/delete')->controller(UploadController::class, 'deleteFiles');

    Route::post('/admin/front')->controller(FrontFetchController::class);

    Route::post('/promt')->controller(FrontFetchController::class);
Route::endGroup();

Route::post('/logout')->controller(LogoutController::class);

// Route::get('/admin-test')->controller(DefaultController::class)->name('admin-test');
// Route::post('/admin-test')->controller(DefaultController::class);
