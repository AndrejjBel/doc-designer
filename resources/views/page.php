<?php
insertTemplate('/templates/header', ['data' => $data]);
?>

<h4 class="text-center mb-5"><?php echo $data['page_data']['title'];?></h4>

<div class="product-btn">
    <button class="btn btn-sm btn-primary mt-2 mt-md-0"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasFields"
    aria-controls="offcanvasVars">Поля</button>
</div>

<div class="product-block ql-editor">
    <?php echo replace_vars_content($data['vars'], $data['product']['descr']);?>
</div>

<div id="edit-var-text-modal" class="modal fade" tabindex="-1" aria-labelledby="edit-var-text-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-colored-header">
                <h4 class="modal-title" id="edit-var-text-modalLabel"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-3 mb-3"></div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                <button id="delete-product" type="button" class="btn btn-success" data-bs-dismiss="modal" data-id="0" onclick="productDelete(this)">Да, удалить</button>
            </div> -->
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start offcanvas-fields" tabindex="-1" id="offcanvasFields" aria-labelledby="offcanvasFieldsLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasFieldsLabel">Поля</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body syncscroll" name="pageSync">
        <form id="fields-list" class="fields-list">
            <?php echo fields_list_content($data['product']['descr'], $data['product']['vars'], $data['vars']);?>
        </form>
    </div>

    <div id="warning-wrap-offcanvas" class="alert-container-offcanvas position-fixed bottom-0 end-0 p-3"></div>
</div>

<?php

// preg_match_all("/#(.+?)#/", $data['product']['descr'], $matches);
//
// $searchArr = [];
// foreach ($matches[0] as $value) {
//     $searchArr[] = str_replace('#', '', $value);
// }

// $search = [251];
// $newVars = array_shift(array_filter($data['vars'], function($_array) use ($search){
//     return in_array($_array['id'], $search);
// }));

// $tt = fields_list($data['product']['descr'], $data['vars']);
// $vars = [];
// foreach ($tt as $var) {
//     foreach ($var as $value) {
//         $vars[] = $value;
//     }
// }

// $vars = explode(',', $data['product']['vars']);

// echo '<pre>';
// var_dump($data);
// echo '</pre>';

// $html = '<style type="text/css">
// body {
//     font-family: DejaVu Serif;
//     margin-top: 10px;
//     margin-bottom: 10px;
//     position: relative;
//     line-height: 1.2;
// }
// .ql-editor .ql-align-justify {
//     text-align: justify;
// }
// .ql-editor p {
//     margin: 0;
//     padding-top: 0;
//     padding-bottom: 0;
// }
// .ql-editor .ql-align-center {
//     text-align: center;
// }
// .ql-indent-8 {
//     padding-left: 25em;
// }
// .ql-align-justify {
//     text-indent: 30px;
// }
// .ql-editor .ql-align-right {
//     text-align: right;
// }
// </style>
// <div class="product-block ql-editor">' . replace_vars_content($data['vars'], $data['product']['descr']) . '</div>';
// $fname = 'test1';
// html_to_pdf($html, $fname);

insertTemplate('/templates/footer-pages', ['data' => $data]);
