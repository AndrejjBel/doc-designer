<?php
$currUser = userAllData();
$home_url = home_url();
$home_link = '/';
if ($data['mod'] == 'home') {
    $home_link = 'javascript:void(0)';
}
$link_lk = '/dashboard';
if (is_admin_allowed()) {
    $link_lk = '/admin';
}
// $user_balance = $currUser['balance'] - $currUser['expenses']; //($currUser['c_tokens']/1000*0.144 + $currUser['p_tokens']/1000*0.432);
?>

<header id="masthead" class="header-page">
    <div class="container-fluid d-flex gap-1 align-items-center justify-content-between w-100 pt-2 pb-2 border-bottom">
        <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
            <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" class="logo-img me-2" alt="logo">
            <!-- <img src="../public/images/logo-txtgen1.png" class="logo-img me-2" alt=""> -->
            <div class="text-logo">
                <span class="d-block fs-28 fw-bolder">ВЕРНЫЙ МЕТОД</span>
                <span class="d-block fs-6 fw-medium">юридическая помощь</span>
                <span class="d-block fs-6 fw-medium">юристы И адвокаты</span>
            </div>
        </a>
        <?php if (is_login()) { ?>
            <div class="header-right d-flex gap-2 align-items-center">
                <div class="user-name">
                    <a href="<?php echo $link_lk;?>">
                        <h6 class="mb-0"><?php echo ($currUser['first_name'])? $currUser['first_name'] : $currUser['username'];?></h6>
                    </a>
                </div>
                <form action="/logout" method="post" accept-charset="utf-8" class="dropdown-item">
                    <input type="hidden" name="actions" value="logOut">
                    <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                    <button type="submit" class="dashboard-logout-btn btn btn-primary btn-sm">Выйти</button>
                </form>

                <div class="btn-group">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Действие
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Действие</a></li>
                        <li><a class="dropdown-item" href="#">Другое действие</a></li>
                        <li><a class="dropdown-item" href="#">Что-то еще здесь</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="/logout" method="post" accept-charset="utf-8" class="dropdown-item">
                                <input type="hidden" name="actions" value="logOut">
                                <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                                <button type="submit" class="dashboard-logout-btn btn btn-link">Выйти</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</header>

<div class="header-fixed-height"></div>
