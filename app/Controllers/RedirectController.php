<?php

namespace App\Controllers;

class RedirectController extends \MainController
{
    /**
     * Редирект по имени маршрута.
     *
     * @param $name - название целевого маршрута.
     * @param array $params - параметры для подстановки в динамический маршрут.
     * @param int $code - HTTP-код редиректа.
     */
    public function index(string $name, array $params = [], int $code = 301) {
        redirect(getUrlByName($name, $params), $code);
    }
}

// Route::get("/page/2", "New page")->name('target');
//
// Route::get('/page/1')->controller('RedirectController', ['target']);
