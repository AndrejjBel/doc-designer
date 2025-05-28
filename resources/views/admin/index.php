<?php
use App\Models\{
    VarsModel
};
$vars = VarsModel::getVarsAll();
$data['site_settings'] = json_decode(site_settings('site_settings'));
$data['vars'] = $vars;
insertTemplate('/templates/admin/header', ['data' => $data]);
insertTemplate('/templates/admin/navbar', ['data' => $data]);
insertTemplate('/templates/admin/leftside-menu', ['data' => $data]);
insertTemplate('/templates/admin/content/' . $data['temp'], ['data' => $data]);
insertTemplate('/templates/admin/footer', ['data' => $data]);
