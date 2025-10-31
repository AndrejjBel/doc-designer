<?php
$currUser = userAllData();
$home_url = home_url();
?>
<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">
            <div class="logo-topbar">
                <a href="/" class="logo-light">
                    <span class="logo-lg">
                        <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" alt="logo">
                    </span>
                    <span class="logo-sm">
                        <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" alt="small logo">
                    </span>
                </a>
                <a href="/" class="logo-dark">
                    <span class="logo-lg">
                        <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" alt="small logo">
                    </span>
                </a>
            </div>
            <button class="button-toggle-menu">
                <i class="ri-menu-2-fill"></i>
            </button>
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">
            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode">
                    <i class="ri-moon-line fs-22"></i>
                </div>
            </li>


            <li class="d-none d-md-inline-block">
                <a class="nav-link" href="" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line fs-22"></i>
                </a>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="<?php echo $home_url;?>/public/images/no-avatar.png" alt="user-image" width="32" class="rounded-circle">
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0"><?php echo ($currUser['first_name'])? $currUser['first_name'] : $currUser['username'];?></h5>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Привет, <?php echo ($currUser['first_name'])? $currUser['first_name'] : $currUser['username'];?>!</h6>
                    </div>

                    <form action="/logout" method="post" accept-charset="utf-8" class="dropdown-item">
                        <input type="hidden" name="actions" value="logOut">
                        <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                        <button type="submit" class="dashboard-logout-btn">Выйти</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
