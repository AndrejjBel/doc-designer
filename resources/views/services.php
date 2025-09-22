<?php
insertTemplate('/templates/header-home', ['data' => $data]);
// $user = $data['user'];
?>

<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="page-title text-center mb-4 pb-2">
                <h1 class="mb-4">Сервисы</h1>
            </div>
        </div>

        <div class="page-content service-items">
            <div class="d-flex features feature-primary key-feature mb-4 p-3 rounded shadow service-item">
                <a href="#" class="service-item-link" title="Перейти на сайт"></a>
                <div class="icon text-center rounded-circle me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor fea icon-ex-md">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="service-item-title mb-0">Запрос в Федеральную службу судебных приставов</h3>
                    <p class="service-item-description">на предмет не закрытых судебных производств</p>
                </div>
            </div>

            <div class="d-flex features feature-primary key-feature mb-4 p-3 rounded shadow service-item">
                <a href="#" class="service-item-link" title="Перейти на сайт"></a>
                <div class="icon text-center rounded-circle me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor fea icon-ex-md">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="service-item-title mb-0">Проверка штрафов ГИБДД</h3>
                    <p class="service-item-description">официальный сайт ГИБДД МВД России</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

// echo '<pre>';
// var_dump($data);
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);
