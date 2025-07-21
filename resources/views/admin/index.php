<?php
use App\Models\{
    VarsModel,
    ProductsModel
};
$userRoles = getUserRoles();
$vars = VarsModel::getVarsAll();
$varsJson = VarsModel::getVarsAllJson();
$products_gr = ProductsModel::getProductsNav();
$data['userRoles'] = array_slice($userRoles, 0, 1)[0];
$data['site_settings'] = SITE_SETTINGS;
$data['vars'] = $vars;
$data['varsJson'] = $varsJson;
$data['products_gr'] = $products_gr;
insertTemplate('/templates/admin/header', ['data' => $data]);
insertTemplate('/templates/admin/navbar', ['data' => $data]);
insertTemplate('/templates/admin/leftside-menu', ['data' => $data]);
insertTemplate('/templates/admin/content/' . $data['temp'], ['data' => $data]);
insertTemplate('/templates/admin/footer', ['data' => $data]);
