<?php
insertTemplate('/templates/header-home', ['data' => $data]);
$site_settings = json_decode(site_settings('site_settings'));
?>

<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="page-title text-center mb-4 pb-2">
                <h1 class="mb-4">Контакты</h1>
            </div>
        </div>

        <div class="page-content contacts">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0 order-2 order-md-1">
                    <div class="card custom-form rounded border-0 shadow p-4">
                        <form name="myForm" id="myForm">
                            <p id="error-msg" class="mb-0"></p>
                            <div id="simple-msg"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ваше имя <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="name" id="name" type="text" class="form-control ps-5" placeholder="Имя :">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ваш Email <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="mail" class="fea icon-sm icons"></i>
                                            <input name="email" id="email" type="email" class="form-control ps-5" placeholder="Email :">
                                        </div>
                                    </div>
                                </div><!--end col-->

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Тема</label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="book" class="fea icon-sm icons"></i>
                                            <input name="subject" id="subject" class="form-control ps-5" placeholder="Тема :">
                                        </div>
                                    </div>
                                </div><!--end col-->

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Сообщение <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="message-circle" class="fea icon-sm icons clearfix"></i>
                                            <textarea name="comments" id="comments" rows="4" class="form-control ps-5" placeholder="Сообщение :"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" id="submit" name="send" class="btn btn-primary">Отправить</button>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </form>
                    </div><!--end custom-form-->
                </div><!--end col-->

                <div class="col-lg-7 col-md-6 order-1 order-md-2">
                    <div class="title-heading ms-lg-4">
                        <h4 class="mb-4">Контактная информация</h4>
                        <p class="text-muted">Оставьте заявку на консультацию и наши юристы подскажут вам, как проще всего решить вашу проблему.</p>
                        <div class="d-flex contact-detail mt-3">
                            <div class="icon">
                                <i data-feather="mail" class="fea icon-m-md text-dark me-3"></i>
                            </div>
                            <div class="flex-1 content">
                                <h6 class="title fw-bold mb-0">Email</h6>
                                <a href="mailto:<?php echo $site_settings->contact_front_email;?>" class="text-primary"><?php echo $site_settings->contact_front_email;?></a>
                            </div>
                        </div>

                        <div class="d-flex contact-detail mt-3">
                            <div class="icon">
                                <i data-feather="phone" class="fea icon-m-md text-dark me-3"></i>
                            </div>
                            <div class="flex-1 content">
                                <h6 class="title fw-bold mb-0">Телефон</h6>
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $site_settings->contact_phone);?>" class="text-primary"><?php echo $site_settings->contact_phone;?></a>
                            </div>
                        </div>

                        <div class="d-flex contact-detail mt-3">
                            <div class="icon">
                                <i data-feather="map-pin" class="fea icon-m-md text-dark me-3"></i>
                            </div>
                            <div class="flex-1 content">
                                <h6 class="title fw-bold mb-0">Адрес</h6>
                                <p><?php echo $site_settings->contact_adress;?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
insertTemplate('/templates/footer-new', ['data' => $data]);
