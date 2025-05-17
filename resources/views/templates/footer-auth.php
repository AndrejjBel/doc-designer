<?php
$site_settings = json_decode(site_settings('site_settings'));
$copyright = '<script>document.write(new Date().getFullYear())</script> © Site - Site.com';
if ($site_settings) {
    if (isset($site_settings->copyright)) {
        $copyright = $site_settings->copyright;
    }
}
?>
<footer class="footer footer-alt fw-medium">
    <span class="bg-body"><?php echo $copyright;?></span>
</footer>
<!-- Vendor js -->
<script src="../public/js/admin/vendor.min.js"></script>

<!-- App js -->
<script src="../public/js/admin/app.min.js"></script>
