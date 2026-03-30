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

<header id="topnav" class="defaultscroll sticky navbar-white-bg">
    <div class="container">
        <div class="header-container">
            <a class="logo" href="<?php echo $home_link;?>">
                <img src="../public/images/favicon/logo.png" height="24" class="logo-light-mode" alt="">
                <img src="../public/images/favicon/logo.png" height="24" class="logo-dark-mode" alt="">
                <!-- <div class="text-logo">
                    <span class="d-block fw-bolder text-logo-top">ВЕРНЫЙ МЕТОД</span>
                    <span class="d-block fs-6 fw-medium text-logo-bottom">юридическая помощь</span>
                    <span class="d-block fs-6 fw-medium text-logo-bottom">юристы И адвокаты</span>
                </div> -->
            </a>

            <div class="catalog-list dropdown-center d-none d-lg-block">
                <button type="button" class="btn btn-primary border border-white btn-catalog-list d-flex" data-bs-toggle="dropdown">
                    <span class="mdi mdi-content-paste"></span>
                    <span>Документы</span>
                    <i data-feather="chevron-down" class="chevron-down icon-sm"> </i>
                </button>
                <div class="catalog-list-content dropdown-menu">
                    <div class="d-flex">
                        <ul class="list">
                            <li><a class="dropdown-item" href="#">Претензии</a></li>
                            <li><a class="dropdown-item" href="#">Заявления</a></li>
                            <li><a class="dropdown-item" href="#">Требования</a></li>
                            <li><a class="dropdown-item" href="#">Жалобы</a></li>
                        </ul>

                        <ul class="list">
                            <li><a class="dropdown-item" href="#">Исковые заявления</a></li>
                            <li><a class="dropdown-item" href="#">Административные иски</a></li>
                            <li><a class="dropdown-item" href="#">Прочие документы</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center subcribe-form w-100 d-none d-lg-block">
                <form style="max-width: 800px; width: 100%;">
                    <div class="mb-0">
                        <input type="search" id="search" name="search" class="border rounded bg-white-color" required="" placeholder="Поиск по сайту">
                        <button type="submit" class="btn btn-primary">Поиск</button>
                    </div>
                </form>
            </div>

            <div id="navDocs" class="nav-docs pt-3  pb-3" style="display: none;">
                <div class="container">
                    <div class="text-center subcribe-form w-100">
                        <form style="max-width: 100%; width: 100%;">
                            <div class="mb-0">
                                <input type="search" id="search" name="search" class="border rounded bg-white-color" required="" placeholder="Поиск по сайту">
                                <button type="submit" class="btn btn-primary">Поиск</button>
                            </div>
                        </form>
                    </div>
                    <div class="ul-list mt-3">
                        <ul class="list">
                            <li><a class="dropdown-item" href="#">Претензии</a></li>
                            <li><a class="dropdown-item" href="#">Заявления</a></li>
                            <li><a class="dropdown-item" href="#">Требования</a></li>
                            <li><a class="dropdown-item" href="#">Жалобы</a></li>
                            <li><a class="dropdown-item" href="#">Исковые заявления</a></li>
                            <li><a class="dropdown-item" href="#">Административные иски</a></li>
                            <li><a class="dropdown-item" href="#">Прочие документы</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="navigation">
                <?php //echo top_nav_site('');?>
            </div>

            <div class="menu-extras">
                <div class="menu-item">
                    <a class="navbar-toggle" id="isToggle" onclick="toggleMenu('navDocs')">
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
                                    <img src="../public/assets/images/no-avatar.png" class="avatar avatar-md-sm rounded-circle border shadow" alt="">
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
