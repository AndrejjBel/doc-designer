<?php
insertTemplate('/templates/header-home', ['data' => $data]);
$site_settings = json_decode(site_settings('site_settings'));
?>

<section class="w-100 mt-74 mb-5">
    <div class="container position-relative pt-5">
        <div class="row align-items-center pt-5 pt-sm-0 mt-5 mt-sm-0">
            <div class="col-12">
                <div class="title-heading">
                    <h1 class="heading heading-lg fw-bold mb-3 title-dark text-center">Юридический конструктор:<br>создайте документ <span class="text-success">сейчас</span></h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mb-4">
    <?php insertTemplate('/templates/front/page-blocks/home-cards-three', ['location' => 'home']); ?>
</div>

<div class="container mt-5 mb-4">
    <div class="row">
        <div class="col-lg-12 nav-tab-my">
            <ul class="nav nav-pills nav-justified flex-column flex-sm-row flex-wrap rounded" id="pills-tab" role="tablist">
                <li class="nav-item" style="flex:none;">
                    <a class="rounded btn btn-outline-primary active" id="pills-cloud-tab" data-bs-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-cloud" aria-selected="false">
                        <div class="text-center py-2">
                            <h6 class="mb-0 text-secondary">1. Выберите документ</h6>
                        </div>
                    </a>
                </li>

                <li class="nav-item" style="flex:none;">
                    <a class="btn btn-outline-primary rounded" id="pills-smart-tab" data-bs-toggle="pill" href="#pills-2" role="tab" aria-controls="pills-smart" aria-selected="false">
                        <div class="text-center py-2">
                            <h6 class="mb-0 text-secondary">2. Создайте документ</h6>
                        </div>
                    </a>
                </li>

                <li class="nav-item" style="flex:none;">
                    <a class="btn btn-outline-primary rounded" id="pills-apps-tab" data-bs-toggle="pill" href="#pills-3" role="tab" aria-controls="pills-apps" aria-selected="false">
                        <div class="text-center py-2">
                            <h6 class="mb-0 text-secondary">3. Оплатите</h6>
                        </div>
                    </a>
                </li>

                <li class="nav-item" style="flex:none;">
                    <a class="btn btn-outline-primary rounded" id="pills-apps-tab" data-bs-toggle="pill" href="#pills-4" role="tab" aria-controls="pills-apps" aria-selected="false">
                        <div class="text-center py-2">
                            <h6 class="mb-0 text-secondary">4. Проверьте документ</h6>
                        </div>
                    </a>
                </li>

                <li class="nav-item" style="flex:none;">
                    <a class="btn btn-outline-primary rounded" id="pills-apps-tab" data-bs-toggle="pill" href="#pills-5" role="tab" aria-controls="pills-apps" aria-selected="false">
                        <div class="text-center py-2">
                            <h6 class="mb-0 text-secondary">5. Отправьте документ</h6>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-12">
            <div class="tab-content rounded bg-primary p-4" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-cloud-tab">
                    <div class="tab-pane-content d-flex">
                        <div class="tab-pane-content-text">
                            <h3 class="text-white mb-0">Воспользуйтесь поиском.</h3>
                            <ul>
                                <li class="fs-5 text-white">Воспользуйтесь поисковой строкой для быстрого нахождения нужного типа документа</li>
                                <li class="fs-5 text-white">Выберите шаблон из предложенных вариантов, соответствующий вашим потребностям</li>
                                <li class="fs-5 text-white">Проверьте актуальность выбранного шаблона перед продолжением работы</li>
                            </ul>
                        </div>

                        <div class="tab-pane-content-video flex-none d-flex p-40">
                            <video autoplay loop muted playsinline width="320" height="320" class="rounded">
                                <source src="../public/images/video/grok-video.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-cloud-tab">
                    <div class="tab-pane-content d-flex">
                        <div class="tab-pane-content-text">
                            <h3 class="text-white mb-0">Заполнение полей.</h3>
                            <p class="fs-5 text-white">Просмотрите форму и определите обязательные поля (отмечены специальным значком).</p>
                            <p class="fs-5 text-white">Заполните основную информацию:</p>
                            <ul>
                                <li class="fs-5 text-white">реквизиты сторон</li>
                                <li class="fs-5 text-white">даты и сроки</li>
                                <li class="fs-5 text-white">суммы и условия</li>
                            </ul>
                            <p class="fs-5 text-white">Проверьте корректность введенных данных.</p>
                            <p class="fs-5 text-white">Используйте подсказки системы для правильного заполнения сложных полей.</p>
                        </div>

                        <div class="tab-pane-content-video flex-none d-flex p-40">
                            <video autoplay loop muted playsinline width="320" height="320" class="rounded">
                                <source src="../public/images/video/grok-video.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-cloud-tab">
                    <div class="tab-pane-content d-flex">
                        <div class="tab-pane-content-text">
                            <h3 class="text-white mb-0">Оплата.</h3>
                            <p class="fs-5 text-white">Выберите способ оплаты из доступных вариантов:</p>
                            <ul>
                                <li class="fs-5 text-white">банковская карта</li>
                                <li class="fs-5 text-white">QR - код</li>
                                <li class="fs-5 text-white">безналичный расчет</li>
                            </ul>
                            <p class="fs-5 text-white">Проверьте итоговую сумму перед подтверждением платежа</p>
                            <p class="fs-5 text-white">Сохраните квитанцию или чек об оплате</p>
                        </div>

                        <div class="tab-pane-content-video flex-none d-flex p-40">
                            <video autoplay loop muted playsinline width="320" height="320" class="rounded">
                                <source src="../public/images/video/grok-video.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-cloud-tab">
                    <div class="tab-pane-content d-flex">
                        <div class="tab-pane-content-text">
                            <h3 class="text-white mb-0">Проверка документа.</h3>
                            <p class="fs-5 text-white">Перейдите в личный кабинет в раздел “Мои документы”</p>
                            <p class="fs-5 text-white">Откройте сформированный документ для проверки</p>
                            <p class="fs-5 text-white">Внимательно просмотрите:</p>
                            <ul>
                                <li class="fs-5 text-white">все заполненные поля</li>
                                <li class="fs-5 text-white">правильность расчетов</li>
                                <li class="fs-5 text-white">корректность форматирования</li>
                            </ul>
                            <p class="fs-5 text-white">При обнаружении ошибок сообщите в тех. поддержку.</p>
                        </div>

                        <div class="tab-pane-content-video flex-none d-flex p-40">
                            <video autoplay loop muted playsinline width="320" height="320" class="rounded">
                                <source src="../public/images/video/grok-video.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-5" role="tabpanel" aria-labelledby="pills-cloud-tab">
                    <div class="tab-pane-content d-flex">
                        <div class="tab-pane-content-text">
                            <h3 class="text-white mb-0">Отправка документа.</h3>
                            <p class="fs-5 text-white">Выберите способ отправки:</p>
                            <p class="fs-5 text-white">При отправке через электронный сервис “Электронные заказные письма” Почты России:</p>
                            <ul>
                                <li class="fs-5 text-white">укажите адрес получателя</li>
                                <li class="fs-5 text-white">выберите способ уведомления</li>
                                <li class="fs-5 text-white">подтвердите отправку</li>
                            </ul>
                            <p class="fs-5 text-white">При отправке почтой:</p>
                            <ul>
                                <li class="fs-5 text-white">распечатайте документ</li>
                                <li class="fs-5 text-white">заполните конверт</li>
                                <li class="fs-5 text-white">передайте в почтовое отделение</li>
                            </ul>
                        </div>

                        <div class="tab-pane-content-video flex-none d-flex p-40">
                            <video autoplay loop muted playsinline width="320" height="320" class="rounded">
                                <source src="../public/images/video/grok-video.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 mb-4">
    <div class="row align-items-center justify-content-between border border-primary rounded mx-1 p-4 bg-light helper-wrap">
        <div class="col-12 col-lg-8">
            <h3>Нужна помощь с выбором?</h3>
            <p class="fs-5">Юристы помогут подобрать необходимый документ, подходящий под Вашу жизненную ситуацию.</p>
        </div>
        <div class="col-12 col-sm-8 col-lg-3">
            <a href="#" class="btn btn-primary w-100">Получить консутальцию</a>
        </div>
    </div>
</div>

<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <div class="section-title mb-4 pb-2">
                <h4 class="title mb-4">Каталог документов</h4>
                <p class="fs-5">Выберите нужный документ для вашей ситуации</p>
            </div>
        </div>
        <?php insertTemplate('/templates/front/page-blocks/home-flip-cards', ['location' => 'home']); ?>
    </div>
</div>

<section class="mb-5">
    <div class="container position-relative pt-5">
        <div class="row align-items-center pt-5 pt-sm-0 mt-5 mt-sm-0">
            <div class="col-12">
                <div class="title-heading">
                    <h2 class="fw-bold mb-3 title-dark text-center">ОНЛАЙН КОНСТРУКТОР БЫСТРОГО СОЗДАНИЯ<br>ЮРИДИЧЕСКИХ ДОКУМЕНТОВ <span class="text-success">БЕЗ ОШИБОК</span></h2>
                </div>
            </div>
        </div>

        <div class="content-description-bg">
            <div class="description-bg">
                <div class="all" style="background-image: url('../public/images/photo.jpg.webp');"></div>
                <div class="map">
                    <img src="../public/images/photo.png.webp" alt="">
                </div>
                <div class="logo-bg">
                    <div class="logo-bg-img border border-primary">
                        <img src="../public/images/favicon/logo.png" alt="">
                    </div>
                </div>
            </div>

            <div class="cards-bg-wrap">
                <div class="cards-bg">
                    <div class="cards-bg-line cards-line1">
                        <div class="cards-bg-item border border-primary rounded p-2">
                            <span class="cards-bg-item-text">Все документы <br>соответствуют <br>законодательству.</span>
                            <span class="cards-bg-item-step border border-5 border-primary text-primary">3</span>
                        </div>
                        <div class="cards-bg-item border border-primary rounded p-2">
                            <span class="cards-bg-item-step border border-5 border-primary text-primary">4</span>
                            <span class="cards-bg-item-text">Актуальные шаблоны без <br>лишних затрат на <br>юридические компании.</span>
                        </div>
                    </div>

                    <div class="cards-bg-line cards-line2">
                        <div class="cards-bg-item border border-primary rounded p-2">
                            <span class="cards-bg-item-text">Подготовка документа <br>занимает несколько <br>минут.</span>
                            <span class="cards-bg-item-step border border-5 border-primary text-primary">2</span>
                        </div>
                        <div class="cards-bg-item border border-primary rounded p-2">
                            <span class="cards-bg-item-step border border-5 border-primary text-primary">5</span>
                            <span class="cards-bg-item-text">Список документов <br>пополняется. Шаблоны <br>проверены юристами.</span>
                        </div>
                    </div>

                    <div class="cards-bg-line">
                        <div class="cards-bg-item border border-primary rounded p-2">
                            <span class="cards-bg-item-text">Моментально создавайте <br>шаблонные документы, <br>не выходя из дома.</span>
                            <span class="cards-bg-item-step border border-5 border-primary text-primary">1</span>
                        </div>
                        <div class="cards-bg-item border border-primary rounded p-2">
                            <span class="cards-bg-item-step border border-5 border-primary text-primary">6</span>
                            <span class="cards-bg-item-text">Юридическая поддержка <br>при создании документа, <br>24/7.</span>
                        </div>
                    </div>
                </div>

                <div class="cards-bg-mobile">
                    <div class="cards-bg-item border border-primary rounded p-2">
                        <span class="cards-bg-item-step border border-5 border-primary text-primary">1</span>
                        <span class="cards-bg-item-text">Моментально создавайте шаблонные документы, не выходя из дома.</span>
                    </div>
                    <div class="cards-bg-item border border-primary rounded p-2">
                    <span class="cards-bg-item-step border border-5 border-primary text-primary">2</span>
                        <span class="cards-bg-item-text">Подготовка документа занимает несколько минут.</span>
                    </div>
                    <div class="cards-bg-item border border-primary rounded p-2">
                    <span class="cards-bg-item-step border border-5 border-primary text-primary">3</span>
                        <span class="cards-bg-item-text">Все документы соответствуют законодательству.</span>
                    </div>
                    <div class="cards-bg-item border border-primary rounded p-2">
                        <span class="cards-bg-item-step border border-5 border-primary text-primary">4</span>
                        <span class="cards-bg-item-text">Актуальные шаблоны без лишних затрат на юридические компании.</span>
                    </div>
                    <div class="cards-bg-item border border-primary rounded p-2">
                        <span class="cards-bg-item-step border border-5 border-primary text-primary">5</span>
                        <span class="cards-bg-item-text">Список документов пополняется. Шаблоны проверены юристами.</span>
                    </div>
                    <div class="cards-bg-item border border-primary rounded p-2">
                        <span class="cards-bg-item-step border border-5 border-primary text-primary">6</span>
                        <span class="cards-bg-item-text">Юридическая поддержка при создании документа, 24/7.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <div class="container mt-5">
    <?php //insertTemplate('/templates/front/page-blocks/faq'); ?>
</div> -->

<?php //insertTemplate('/templates/front/page-blocks/home-reviews'); ?>

<!-- <section class="section" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="section-title text-center mb-4 pb-2">
                    <h4 class="title mb-4">Не можете понять какая услуга нужна именно вам?</h4>
                    <p class="para-desc text-muted mx-auto mb-0">Оставьте заявку на консультацию и наши юристы подскажут вам, как проще всего решить вашу проблему</p>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6 col-12 mt-4 pt-2">
                <div class="card rounded shadow">
                    <div class="card-body card-body-form">
                        <form id="contactForm">
                            <p class="mb-0" id="error-msg"></p>
                            <div id="simple-msg"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ваше имя <span class="text-danger">*</span></label>
                                        <input id="name" name="name" type="text" class="form-control" placeholder="Имя :" required oninput="inputIsvalid(this)">
                                    </div>
                                </div>

                                <div class="col-md-6 screen-reader-text">
                                    <input id="email" name="email" type="text" class="form-control" placeholder="Email :" required oninput="inputIsvalid(this)">
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ваш телефон <span class="text-danger">*</span></label>
                                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Телефон :" required oninput="inputIsvalid(this)">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Сообщение <span class="text-danger">*</span></label>
                                        <textarea id="message" name="message" rows="4" class="form-control" placeholder="Сообщение :" required oninput="inputIsvalid(this)"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input id="privacy" name="privacy" class="form-check-input" type="checkbox" required onchange="inputIsvalid(this)">
                                        <label class="form-check-label fw-normal" for="privacy">Я принимаю условия <a href="/privacy-policy">Политики конфиденциальности</a> и даю согласие на обработку персональных данных</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button name="send" class="btn btn-primary">Отправить сообщение</button>
                                    </div>
                                </div>
                            </div>
                            <?php //echo csrf_field();?>
                        </form>
                        <div class="form-info-wrap d-flex align-items-center justify-content-center p-4 rounded bg-muted bg-gradient">
                            <div class="form-info-text fw-bolder text-white">Отправляем сообщение<span class="dots"></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-6 col-12 mt-4 pt-2">
                <div class="ms-lg-4">
                    <div class="d-flex features feature-primary feature-clean">
                        <div class="icons text-center mx-auto">
                            <i class="uil uil-phone d-block rounded h4 mb-0"></i>
                        </div>

                        <div class="flex-1 ms-3">
                            <h5 class="mb-2">Телефон</h5>
                            <a href="tel:<?php //echo preg_replace('/[^0-9+]/', '', $site_settings->contact_phone);?>" class="link"><?php //echo $site_settings->contact_phone;?></a>
                        </div>
                    </div>

                    <div class="d-flex features feature-primary feature-clean mt-4">
                        <div class="icons text-center mx-auto">
                            <i class="uil uil-envelope d-block rounded h4 mb-0"></i>
                        </div>

                        <div class="flex-1 ms-3">
                            <h5 class="mb-2">Email</h5>
                            <a href="mailto:<?php //echo $site_settings->contact_front_email;?>" class="link"><?php //echo $site_settings->contact_front_email;?></a>
                        </div>
                    </div>

                    <div class="d-flex features feature-primary feature-clean mt-4">
                        <div class="icons text-center mx-auto">
                            <i class="uil uil-map-marker d-block rounded h4 mb-0"></i>
                        </div>

                        <div class="flex-1 ms-3">
                            <h5 class="mb-2">Адрес</h5>
                            <p class="text-muted mb-2"><?php //echo $site_settings->contact_adress;?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<?php

// echo '<pre>';
// var_dump($data);
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);
