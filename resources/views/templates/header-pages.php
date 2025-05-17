<?php
$currUser = userAllData();
$home_link = '/';
if ($data['mod'] == 'home') {
    $home_link = 'javascript:void(0)';
}
$bg = home_url() . '/public/images/1.jpg';
?>
<header id="topnav" class="defaultscroll sticky">
    <div class="container">
        <a class="logo" href="<?php echo $home_link;?>">
            <span class="logo-light-mode">
                <img src="https://traveling-best.ru/wp-content/themes/traveling-best/assets/images/alogo/logo-new1.png" class="l-dark" height="24" alt="">
                <img src="https://traveling-best.ru/wp-content/themes/traveling-best/assets/images/alogo/logo-new1-l.png" class="l-light" height="24" alt="">
                <span class="logo-text">Путешественник</span>
            </span>
            <img src="https://traveling-best.ru/wp-content/themes/traveling-best/assets/images/logo-light.png" height="24" class="logo-dark-mode" alt="">
        </a>
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
            <li class="list-inline-item mb-0 pe-1">
                <div class="dropdown">
                    <button type="button" class="btn dropdown-toggle p-0 header-search-btn" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="uil uil-search fs-5 align-middle"></i>
                    </button>
                    <div class="dropdown-menu dd-menu dropdown-menu-end bg-white shadow rounded border-0 mt-3 p-0" style="width: 300px;">
                        <div class="search-bar">
                            <div id="itemSearch" class="menu-search mb-0">
                                <form role="search" method="get" id="searchItemform" class="searchform">
                                    <input type="text" class="form-control border rounded" name="s" id="searchItem" placeholder="Search...">
                                    <input type="submit" id="searchItemsubmit" value="Search">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <div id="navigation">
            <?php echo navigation_primary_html();?>
        </div>
    </div>
</header>

<?php if ( $data['mod'] != 'home' && $data['mod'] != '404' ) { ?>
    <section class="bg-half-40 d-table w-100" style="background: url('<?php echo $bg; ?>'); background-repeat: no-repeat; background-size: cover;">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-lg-12 text-center">
                    <div class="pages-heading title-heading">
                        <h2 class="text-white title-dark"><?php echo $data['title'];?></h2>
                        <p class="text-white-50 para-desc mb-0 mx-auto"><?php echo $data['description'];?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="position-relative">
        <div class="shape overflow-hidden text-color-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>

    <div class="container">
        <?php echo $data['breadcrumbs']; ?>
    </div>
<?php }
