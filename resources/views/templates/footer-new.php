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
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="../public/images/payments-logos/paykeeper.png" class="avatar avatar-ex-sm" title="American Express" alt=""></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="../public/images/payments-logos/mastercard.png" class="avatar avatar-ex-sm" title="Master Card" alt=""></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="../public/images/payments-logos/visa.png" class="avatar avatar-ex-sm" title="Paypal" alt=""></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)"><img src="../public/images/payments-logos/sbp.png" class="avatar avatar-ex-sm" title="Visa" alt=""></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
