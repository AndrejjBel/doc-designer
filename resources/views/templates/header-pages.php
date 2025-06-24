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
<header class="d-flex gap-1 align-items-center justify-content-between pb-3 mb-5 border-bottom">
    <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
        <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" class="logo-img me-2" alt="logo">
        <!-- <img src="../public/images/logo-txtgen1.png" class="logo-img me-2" alt=""> -->
        <span class="fs-4">ВЕРНЫЙ МЕТОД</span>
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
        </div>
    <?php } ?>
</header>
