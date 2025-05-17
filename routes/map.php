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

// require_once __DIR__ . '/admin/map.php';
// require_once __DIR__ . '/dashboard/map.php';
// require_once __DIR__ . '/front/map.php';

use App\Middlewares\{
    DashboardMiddleware,
    Auth\AuthMiddleware,
    Auth\SigninMiddleware,
    Admin\AdminMiddleware
};

use App\Controllers\{
    HomeController,
    DefaultController,
    GlampingsFrontController,
    AdminFetchController,
    FrontFetchController,
    LocationFrontController,
    Admin\AdminController,
    Admin\UsersController,
    Admin\UserAddController,
    Admin\UserEditController,

    Admin\GlampingsController,
    Admin\GlampingAddController,
    Admin\GlampingEditController,
    Admin\LocationsController,

    Admin\AdminPostsController,
    Admin\PostAddController,
    Admin\PostEditController,

    Admin\ReviewsAdminController,
    Admin\ReviewsAddController,
    Admin\ReviewsEditController,

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
Route::get('/about/')->controller(HomeController::class, 'about')->name('about');
Route::get('/services/')->controller(HomeController::class, 'services')->name('services');
Route::get('/contact/')->controller(HomeController::class, 'contact')->name('contact');

Route::get('/glampings/')->controller(GlampingsFrontController::class)->name('glampings');
Route::get('/glampings/page/{page}/')->controller(GlampingsFrontController::class)->name('glampings-page');

Route::get('/location/')->controller(LocationFrontController::class)->name('location');
Route::get('/location/page/{page}/')->controller(LocationFrontController::class)->name('location-page');

Route::get('/location/{slug}/')->controller(LocationFrontController::class, 'location_item')->name('location-item');
Route::get('/location/{slug}/page/{page}/')->controller(LocationFrontController::class, 'location_item')->name('location-item-page');

// Route::get('/products/{post_slug}')->controller(ProductsController::class, 'product')->name('product');
// Route::get('/cart')->controller(HomeController::class, 'cart')->name('cart');

Route::toGroup()->prefix('admin')->middleware(AdminMiddleware::class);
    Route::get('/')->controller(AdminController::class)->name('admin.generale');
    Route::get('/settings')->controller(AdminController::class, 'admin_settings')->name('admin.settings');
    Route::get('/user-settings')->controller(AdminController::class, 'user_settings')->name('admin.user-settings');
    Route::get('/users')->controller(UsersController::class)->name('admin.users');
    Route::get('/user-add')->controller(UserAddController::class)->name('admin.user-add');

    Route::get('/glampings')->controller(GlampingsController::class)->name('admin.glampings');
    Route::get('/glamping-add')->controller(GlampingAddController::class)->name('admin.glamping-add');
    Route::get('/glamping-edit')->controller(GlampingEditController::class)->name('admin.glamping-edit');
    Route::get('/location')->controller(LocationsController::class)->name('admin.location');

    Route::get('/landings')->controller(AdminController::class, 'users_landings')->name('admin.landings');
    Route::get('/landing-add')->controller(AdminController::class, 'users_landing_add')->name('admin.landing-add');

    Route::get('/posts')->controller(AdminPostsController::class)->name('admin.posts');
    Route::get('/post-add')->controller(AdminPostsController::class, 'add_post')->name('admin.post-add');
    Route::get('/post-edit')->controller(AdminPostsController::class, 'edit_post')->name('admin.post-edit');
    Route::get('/post-category')->controller(AdminPostsController::class, 'category')->name('admin.post-category');

    Route::get('/reviews')->controller(ReviewsAdminController::class)->name('admin.reviews');
    Route::get('/review-add')->controller(ReviewsAdminController::class, 'add_review')->name('admin.review-add');
    Route::get('/review-edit')->controller(ReviewsAdminController::class, 'edit_review')->name('admin.review-edit');

    Route::post('/order-edit-status')
        ->protect()
        ->controller(AdminOrdersController::class, 'edit_order_status')
        ->name('admin.order-edit-status');
    Route::post('/settings-post')
        ->protect()
        ->controller(AdminController::class, 'site_settings');

    Route::post('/location-add')
        ->protect()
        ->controller(LocationsController::class, 'add_location');
    Route::post('/location-edit')
        ->protect()
        ->controller(LocationsController::class, 'edit_location');
    Route::post('/fetch')
        ->protect()
        ->controller(AdminFetchController::class);
Route::endGroup();

Route::toGroup()->prefix('dashboard')->middleware(DashboardMiddleware::class);
    Route::get('/')->controller(AdminController::class, 'dashboard')->name('dashboard.generale');
    Route::get('/user-settings')->controller(AdminController::class, 'user_settings_dashboard')->name('dashboard.user-settings');
    Route::get('/users')->controller(UsersController::class)->name('dashboard.users');
    Route::get('/user-add')->controller(UserAddController::class)->name('dashboard.user-add');

    Route::get('/glampings')->controller(GlampingsController::class, 'dashboard')->name('dashboard.glampings');
    Route::get('/glamping-add')->controller(GlampingAddController::class, 'dashboard')->name('dashboard.glamping-add');
    Route::get('/glamping-edit')->controller(GlampingEditController::class, 'dashboard')->name('dashboard.glamping-edit');

    Route::get('/posts')->controller(AdminPostsController::class, 'dashboard')->name('dashboard.posts');
    Route::get('/post-add')->controller(AdminPostsController::class, 'add_post_dashboard')->name('dashboard.post-add');
    Route::get('/post-edit')->controller(AdminPostsController::class, 'edit_post_dashboard')->name('dashboard.post-edit');

    Route::get('/reviews')->controller(ReviewsAdminController::class, 'dashboard')->name('dashboard.reviews');
    Route::get('/review-add')->controller(ReviewsAdminController::class, 'add_review_dashboard')->name('dashboard.review-add');
    Route::get('/review-edit')->controller(ReviewsAdminController::class, 'edit_review_dashboard')->name('dashboard.review-edit');
Route::endGroup();

Route::toGroup()->middleware(AuthMiddleware::class);
    Route::get('/login')->controller(LoginController::class)->name('login');
    Route::get('/verify')->controller(VerifyController::class)->name('verify');
    Route::get('/forgot-password')->controller(ForgotPassController::class, 'showPasswordForm')->name('forgot.password');

    Route::post('/login')->controller(AuthController::class);
    Route::post('/signin')->controller(RegController::class);
    Route::post('/forgot-password')->controller(ForgotPassController::class, 'passReset');
Route::endGroup();

Route::toGroup()->middleware(SigninMiddleware::class);
    Route::get('/signin')->controller(SigninController::class)->name('signin');
Route::endGroup();

Route::toGroup()->protect();
    Route::post('/users-admin')->controller(UsersController::class);
    Route::post('/user-admin-add')->controller(UserAddController::class, 'addUser');
    Route::post('/user-admin-edit')->controller(UserEditController::class, 'editUser');
    Route::post('/user-meta-edit')->controller(UserEditController::class, 'editUserMeta');
    Route::post('/user-pass-edit')->controller(UserEditController::class, 'editUserPass');
    Route::post('/user-pass-edit-admin')->controller(UserEditController::class, 'adminEditUserPass');
    Route::post('/glamping-admin-add')->controller(GlampingAddController::class, 'addGlamping');
    Route::post('/glamping-admin-edit')->controller(GlampingEditController::class, 'editGlamping');

    Route::post('/post-admin-add')->controller(PostAddController::class, 'addPost');
    Route::post('/post-admin-edit')->controller(PostEditController::class, 'editPost');

    Route::post('/review-add')->controller(ReviewsAddController::class, 'addPost');
    Route::post('/review-edit')->controller(ReviewsEditController::class, 'editPost');

    Route::post('/admin/upload')->controller(UploadController::class, 'uploadFiles');
    Route::post('/admin/delete')->controller(UploadController::class, 'deleteFiles');

    Route::post('/admin/front')->controller(FrontFetchController::class);
Route::endGroup();

Route::post('/logout')->controller(LogoutController::class);
