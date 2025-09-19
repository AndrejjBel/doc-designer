<?php
$currUser = userAllData();
$home_url = home_url();
$home_link = '/';
if ($data['mod'] == 'home') {
    $home_link = 'javascript:void(0)';
}
$link_lk = '/dashboard';
$link_lk_text = 'В личный кабинет';
if (is_admin_allowed()) {
    $link_lk = '/admin';
    $link_lk_text = 'В админку';
}
$site_settings = json_decode(site_settings('site_settings'));
?>

<header id="topnav" class="defaultscroll sticky">
    <div class="container">
        <div class="header-container">
            <a class="logo" href="<?php echo $home_link;?>">
                <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" height="24" class="logo-light-mode" alt="">
                <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" height="24" class="logo-dark-mode" alt="">
                <div class="text-logo">
                    <span class="d-block fw-bolder text-logo-top">ВЕРНЫЙ МЕТОД</span>
                    <span class="d-block fs-6 fw-medium text-logo-bottom">юридическая помощь</span>
                    <span class="d-block fs-6 fw-medium text-logo-bottom">юристы И адвокаты</span>
                </div>
            </a>

            <div id="navigation">
                <ul class="navigation-menu nav-light">
                    <li><a href="javascript:void(0)" class="sub-menu-item">Услуги</a></li>
                    <li><a href="javascript:void(0)" class="sub-menu-item">Документы</a></li>
                    <li><a href="javascript:void(0)" class="sub-menu-item">Сервисы</a></li>

                </ul>
            </div>

            <div class="menu-extras">
                <div class="menu-item">
                    <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                </div>
            </div>
            <ul class="buy-button list-inline mb-0">
                <li class="list-inline-item mb-0">
                    <div class="btn-group dropdown-center">
                        <a href="javascript:void(0)" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="btn btn-icon btn-pills btn-soft-primary">
                                <i data-feather="user" class="fea icon-sm"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu mt-2">
                            <?php if (is_login()) { ?>
                                <a class="dropdown-item d-flex align-items-center text-dark pb-3" href="/dashboard/">
                                    <img src="<?php echo $home_url;?>/public/assets/images/no-avatar.png" class="avatar avatar-md-sm rounded-circle border shadow" alt="">
                                    <div class="flex-1 ms-2">
                                        <span class="d-block"><?php echo ($currUser['first_name'])? $currUser['first_name'] : $currUser['username'];?></span>
                                        <small class="text-muted"><?php echo rolesMaskTranslate($currUser['roles_mask']);?></small>
                                    </div>
                                </a>
                                <a href="<?php echo $link_lk;?>" class="dropdown-item"><i data-feather="user" class="fea icon-sm"></i> <?php echo $link_lk_text;?></a>
                                <form action="/logout" method="post" accept-charset="utf-8" class="dropdown-item">
                                    <input type="hidden" name="actions" value="logOut">
                                    <button type="submit" class="dropdown-item dashboard-logout-btn"><i data-feather="log-out" class="fea icon-sm"></i> Выйти</button>
                                </form>
                            <?php } else { ?>
                                <a href="/login/" class="dropdown-item">Авторизация</a>
                                <?php if (isset($site_settings->signin_vision)) { ?>
                                    <a href="/signin/" class="dropdown-item">Регистрация</a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</header>

<!-- <div class="header-fixed-height"></div> -->
