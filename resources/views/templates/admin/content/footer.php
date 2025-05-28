<?php
$site_settings = $data['site_settings'];
$copyright = '<script>document.write(new Date().getFullYear())</script> © Site - Site.com';
if ($site_settings) {
    if (isset($site_settings->copyright)) {
        $copyright = $site_settings->copyright;
    }
}
?>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <?php echo $copyright;?>
            </div>
        </div>
    </div>
</footer>

<div id="warning-wrap" class="alert-container position-fixed bottom-0 end-0 p-3"></div>
