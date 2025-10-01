<?php
$home_url = home_url();
$home_link = '/';
if ($data['mod'] == 'home') {
    $home_link = 'javascript:void(0)';
}
$link_lk = '/dashboard';
if (is_admin_allowed()) {
    $link_lk = '/admin';
}
?>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-py-60">
                            <div class="row">
                                <div class="col-lg-4 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                                    <!-- <a href="<?php //echo $home_link;?>" class="logo-footer">
                                        <img src="<?php //echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" height="24" alt="">
                                    </a> -->
                                    <div class="mt-4"><span class="footer-logo-title">Верный метод</span><br>юридическая помощь<br>юристы И адвокаты</div>
                                    <!-- <ul class="list-unstyled social-icon foot-social-icon mb-0 mt-4">
                                        <li class="list-inline-item mb-0"><a href="javascript:void(0)" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
                                        <li class="list-inline-item mb-0"><a href="javascript:void(0)" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
                                        <li class="list-inline-item mb-0"><a href="javascript:void(0)" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                                        <li class="list-inline-item mb-0"><a href="mailto:support@support.in" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
                                    </ul> -->
                                </div>

                                <div class="col-lg-4 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                    <h5 class="footer-head">Информация</h5>
                                    <?php echo footer_nav_site_1();?>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                    <h5 class="footer-head">Полезное</h5>
                                    <?php echo footer_nav_site_2();?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-py-30 footer-bar">
                <div class="container text-center">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="text-sm-start">
                                <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Верный метод</p>
                            </div>
                        </div>

                        <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <ul class="list-unstyled text-sm-end mb-0">
                                <!-- <li class="list-inline-item"><a href="javascript:void(0)"><img src="../public/assets/images/payments/american-ex.png" class="avatar avatar-ex-sm" title="American Express" alt=""></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="../public/assets/images/payments/discover.png" class="avatar avatar-ex-sm" title="Discover" alt=""></a></li> -->
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="../public/assets/images/payments/master-card.png" class="avatar avatar-ex-sm" title="Master Card" alt=""></a></li>
                                <!-- <li class="list-inline-item"><a href="javascript:void(0)"><img src="../public/assets/images/payments/paypal.png" class="avatar avatar-ex-sm" title="Paypal" alt=""></a></li> -->
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="../public/assets/images/payments/visa.png" class="avatar avatar-ex-sm" title="Visa" alt=""></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <div class="offcanvas offcanvas-end shadow border-0" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header p-4 border-bottom">
                <h5 id="offcanvasRightLabel" class="mb-0">
                    <img src="../public/images/favicon/android-chrome-512x512.png" height="24" class="light-version" alt="">
                    <img src="../public/images/favicon/android-chrome-512x512.png" height="24" class="dark-version" alt="">
                </h5>
                <button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
            </div>
            <div class="offcanvas-body p-4">
                <div class="row">
                    <div class="col-12">
                        <img src="../public/assets/images/contact.svg" class="img-fluid d-block mx-auto" alt="">
                        <div class="card border-0 mt-4" style="z-index: 1">
                            <div class="card-body p-0">
                                <h4 class="card-title text-center">Login</h4>
                                <form class="login-form mt-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input type="email" class="form-control ps-5" placeholder="Email" name="email" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                                    <input type="password" class="form-control ps-5" placeholder="Password" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between">
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                                    </div>
                                                </div>
                                                <p class="forgot-pass mb-0"><a href="auth-cover-re-password.html" class="text-dark fw-bold">Forgot password ?</a></p>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary">Sign in</button>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-12 text-center">
                                            <p class="mb-0 mt-3"><small class="text-dark me-2">Don't have an account ?</small> <a href="auth-cover-signup.html" class="text-dark fw-bold">Sign Up</a></p>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas-footer p-4 border-top text-center">
                <ul class="list-unstyled social-icon social mb-0">
                    <li class="list-inline-item mb-0"><a href="javascript:void(0)" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="javascript:void(0)" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="javascript:void(0)" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="mailto:support@support.in" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
                </ul><!--end icon-->
            </div>
        </div>

    </body>
</html>
