<?php
$site_settings = $data['site_settings'];
$site_title = '';
if ($site_settings) {
    if (isset($site_settings->site_title)) {
        $site_title = $site_settings->site_title;
    }
}
$home_url = home_url();
?>
<div class="leftside-menu">
    <a href="/" class="logo logo-light" target="_blank">
        <span class="logo-lg">
            <span class="logo-lg d-flex gap-2 align-items-center">
                <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" alt="logo">
                <span class="text-logo"><?php echo $site_title;?></span>
            </span>
        </span>
        <span class="logo-sm">
            <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" alt="small logo">
        </span>
    </a>

    <a href="/" class="logo logo-dark" target="_blank">
        <span class="logo-lg d-flex gap-2 align-items-center">
            <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" alt="dark logo">
        </span>
        <span class="logo-sm d-flex gap-2 align-items-center">
            <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" alt="small logo">
        </span>
    </a>

    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <?php echo navigation_admin_left_html($data['mod'], $data['vars'], $data['userRoles']);?>
        <div class="clearfix"></div>
    </div>
</div>
