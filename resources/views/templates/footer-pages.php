<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-py-60">
                    <div class="row">
                        <div class="col-lg-4 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                            <a href="#" class="logo-footer">
                                <img src="https://traveling-best.ru/wp-content/themes/traveling-best/assets/images/alogo/logo-new1-l.png" height="36" alt="">
                                <span class="logo-text">Путешественник</span>
                            </a>
                            <p class="mt-4">Путешественник — это не просто ресурс для поиска информации о путешествиях,
                            а полноценная платформа для путешественников, которые ценят качество, безопасность и вдохновение.</p>
                            <p style="font-size: 12px;font-style: italic;">Информация не является публичной офертой, которая определяется положениями Статьи 437 ГК РФ</p>
                        </div>

                        <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <h5 class="footer-head">Популярные регионы</h5>
                            <ul class="list-unstyled footer-list mt-4">
                                <?php location_list_footer_auto();?>
                            </ul>
                        </div>

                        <div class="col-lg-2 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <h5 class="footer-head">Полезное</h5>
                            <ul class="list-unstyled footer-list mt-4">
                                <li><a href="/glampings/" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Каталог</a></li>
                                <li><a href="/location/" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Регионы</a></li>
                                <li><a href="/blog/" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Блог о путешествиях</a></li>
                                <li><a href="/o-proekte/" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> О проекте</a></li>
                                <li><a href="/contacts/" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Контакты</a></li>
                                <li><a href="/privacy-and-cookies/" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Политика конфиденциальности</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <h5 class="footer-head">Подписаться</h5>
                            <p class="mt-4">Зарегистрируйтесь и получайте новости по электронной почте.</p>
                            <form>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="foot-subscribe mb-3">
                                            <label class="form-label">Введите свой E-mail <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="mail" class="fea icon-sm icons"></i>
                                                <input type="email" name="email" id="emailsubscribe" class="form-control ps-5 rounded" placeholder="Ваш E-mail : " required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-grid">
                                            <input type="submit" id="submitsubscribe" name="send" class="btn btn-soft-primary" value="Подписаться">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-py-30 footer-bar">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="text-center">
                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Путешественник</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="overlay js-overlay-modal"></div>

<!-- Cookies Start -->
<div class="card cookie-popup cookie-popup-accepted shadow rounded py-3 px-4">
    <p class="text-muted mb-0">Этот веб-сайт использует файлы cookies, чтобы обеспечить удобную работу пользователей с сайтом. Используя сайт, вы принимаете условия использования файлов cookies <a href="/privacy-policy" target="_blank" class="text-success h6">Политикой конфиденциальности</a></p>
    <div class="cookie-popup-actions text-end">
        <button><i class="uil uil-times text-dark fs-4"></i></button>
    </div>
</div>
<!-- Cookies End -->

<!-- Back to top -->
<a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle"></i></a>
<!-- Back to top -->
