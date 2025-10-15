<?php
insertTemplate('/templates/header-home', ['data' => $data]);
// $user = $data['user'];
?>

<section class="bg-half-100 pb-0 d-table w-100 mb-5 lawyer-wrapper" style="background: url('/public/assets/images/lawyer/bg.jpg') center center;">
    <div class="bg-overlay bg-black" style="opacity: 0.9;"></div>
    <div class="bg-overlay bg-linear-gradient-primary" style="opacity: 0.7;"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center pt-5 pt-sm-0 mt-5 mt-sm-0">
            <div class="col-md-6">
                <div class="title-heading">
                    <!-- <h4 class="heading heading-lg fw-bold text-white mb-3 title-dark">Все виды<br>документов <span class="text-primary">уголовного и гражданского</span> права.</h4>
                    <p class="para-desc text-white-50">Онлайн конструктор быстрого создания юридических документов без ошибок</p> -->

                    <h1 class="heading heading-lg fw-bold text-white mb-3 title-dark">Онлайн конструктор<br>быстрого создания<br><span class="text-primary">юридических документов</span><br>без ошибок.</h1>
                    <p class="para-desc text-white-50">Все виды документов уголовного, гражданского и административного права.</p>
                    <!-- <div class="mt-4 pt-2">
                        <a href="javascript:void(0)" class="btn btn-lg btn-primary">Get In Touch</a>
                    </div> -->
                </div>
            </div>

            <div class="col-md-6 mt-md-5">
                <img src="assets/images/lawyer/avatar.png" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>

<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <div class="section-title mb-4 pb-2">
                <h4 class="title mb-4">Ситуации</h4>
            </div>
        </div>
    </div>
    <?php insertTemplate('/templates/front/page-blocks/home-flip-cards', ['location' => 'home']); ?>
</div>

<div class="container">
    <?php insertTemplate('/templates/front/page-blocks/faq'); ?>
</div>

<?php insertTemplate('/templates/front/page-blocks/home-reviews'); ?>

<section class="section" id="contact">
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
                    <div class="card-body">
                        <form name="myForm" id="myForm">
                            <p class="mb-0" id="error-msg"></p>
                            <div id="simple-msg"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ваше имя <span class="text-danger">*</span></label>
                                        <input name="name" id="name" type="text" class="form-control" placeholder="Имя :">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ваш телефон <span class="text-danger">*</span></label>
                                        <input name="phone" id="phone" type="text" class="form-control" placeholder="Телефон :">
                                    </div>
                                </div>

                                <!-- <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Сообщение</label>
                                        <input name="subject" id="subject" class="form-control" placeholder="Subject :">
                                    </div>
                                </div> -->

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Сообщение <span class="text-danger">*</span></label>
                                        <textarea name="comments" id="comments" rows="4" class="form-control" placeholder="Сообщение :"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" id="submit" name="send" class="btn btn-primary">Отправить сообщение</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                            <a href="tel:+79288808629" class="link">+7 (928) 880-86-29</a>
                        </div>
                    </div>

                    <div class="d-flex features feature-primary feature-clean mt-4">
                        <div class="icons text-center mx-auto">
                            <i class="uil uil-envelope d-block rounded h4 mb-0"></i>
                        </div>

                        <div class="flex-1 ms-3">
                            <h5 class="mb-2">Email</h5>
                            <a href="mailto:info@vernyj-metod.ru" class="link">info@vernyj-metod.ru</a>
                        </div>
                    </div>

                    <div class="d-flex features feature-primary feature-clean mt-4">
                        <div class="icons text-center mx-auto">
                            <i class="uil uil-map-marker d-block rounded h4 mb-0"></i>
                        </div>

                        <div class="flex-1 ms-3">
                            <h5 class="mb-2">Адрес</h5>
                            <p class="text-muted mb-2">Россия, Краснодарский край г. Краснодар, ул.Красная, д.149, оф.№1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

// echo '<pre>';
// var_dump($data);
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);
