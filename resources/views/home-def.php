<?php
insertTemplate('/templates/header-home', ['data' => $data]);
$site_settings = json_decode(site_settings('site_settings'));
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
                            <?php echo csrf_field();?>
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
                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $site_settings->contact_phone);?>" class="link"><?php echo $site_settings->contact_phone;?></a>
                        </div>
                    </div>

                    <div class="d-flex features feature-primary feature-clean mt-4">
                        <div class="icons text-center mx-auto">
                            <i class="uil uil-envelope d-block rounded h4 mb-0"></i>
                        </div>

                        <div class="flex-1 ms-3">
                            <h5 class="mb-2">Email</h5>
                            <a href="mailto:<?php echo $site_settings->contact_front_email;?>" class="link"><?php echo $site_settings->contact_front_email;?></a>
                        </div>
                    </div>

                    <div class="d-flex features feature-primary feature-clean mt-4">
                        <div class="icons text-center mx-auto">
                            <i class="uil uil-map-marker d-block rounded h4 mb-0"></i>
                        </div>

                        <div class="flex-1 ms-3">
                            <h5 class="mb-2">Адрес</h5>
                            <p class="text-muted mb-2"><?php echo $site_settings->contact_adress;?></p>
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
