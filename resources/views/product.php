<?php
insertTemplate('/templates/header', ['data' => $data]);
$user = $data['user'];
?>

<h4 class="text-center mb-5"><?php echo $data['product']['title'];?></h4>

<div class="d-flex gap-2 justify-content-between product-btn">
    <button class="btn btn-sm btn-primary mt-2 mt-md-0"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasFields"
    aria-controls="offcanvasVars">Поля</button>

    <button
        class="btn btn-sm btn-primary mt-2 mt-md-0"
        type="button"
        name="button"
        onclick="payAction(this)">Купить за <?php echo $data['product']['price'];?>руб.</button>
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

<div id="warning-form-modal" class="modal fade" tabindex="-1" aria-labelledby="warning-form-modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-colored-header">
                <h4 class="modal-title" id="warning-form-modal-modalLabel"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-3 mb-3">
                <h4 class="modal-title" id="warning-form-modal-modalLabel">Заполните все поля формы!</h4>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                <button id="delete-product" type="button" class="btn btn-success" data-bs-dismiss="modal" data-id="0" onclick="productDelete(this)">Да, удалить</button>
            </div> -->
        </div>
    </div>
</div>

<div id="success-form-modal" class="modal fade" tabindex="-1" aria-labelledby="success-form-modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-colored-header">
                <h4 class="modal-title" id="success-form-modal-modalLabel">Документ сформирован</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-3 mb-3">
                <!-- <h4 class="modal-title" id="warning-form-modal-modalLabel">Заполните все поля формы!</h4> -->
                <p>Документ сформирован и отправлен на указанный Вами адрес E-mail</p>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                <button id="delete-product" type="button" class="btn btn-success" data-bs-dismiss="modal" data-id="0" onclick="productDelete(this)">Да, удалить</button>
            </div> -->
        </div>
    </div>
</div>

<div id="modal-buy-doc" class="modal fade" tabindex="-1" aria-labelledby="modal-buy-doc-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-colored-header">
                <h4 class="modal-title" id="modal-buy-doc-modalLabel">
                    <?php echo $data['product']['title'];?>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-3 mb-3">
                <h5 class="modal-title" id="modal-buy-doc-modalLabel">
                    К оплате <?php echo $data['product']['price'];?>руб.
                </h5>
                <form id="buy_doc_form">
                    <h5 class="modal-title">Информация о заказе:</h5>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="user_fio" class="form-label">Ф.И.О.</label>
                            <input type="text" id="user_fio" name="user_fio" class="form-control" value="<?php echo ext_user_meta($user, 'fio');?>">
                        </div>
                        <!-- <div class="col-12 col-md-6 mb-3 pass-buy">
                            <input type="text" id="user_passw" name="user_passw" class="form-control">
                        </div> -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="user_email" class="form-label">E-mail</label>
                            <input type="text" id="user_email" name="user_email" class="form-control" value="<?php echo ext_user_meta($user, 'email');?>">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="user_phone" class="form-label">Телефон</label>
                            <input type="text" id="user_phone" name="user_phone" class="form-control phone_mask" value="<?php echo ext_user_meta($user, 'phone');?>">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="user_cbaccept" name="user_cbaccept" required>
                                <label class="form-check-label" for="user_cbaccept">
                                    Соглашаюсь с <a id="lnk_cbaccept" href="#">политикой конфиденциальности и обработкой
                                    персональных данных</a>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="user_cbaccept_ret" name="user_cbaccept_ret" required>
                                <label class="form-check-label" for="user_cbaccept_ret">
                                    Соглашаюсь с <a id="lnk_cbaccept" href="#">условиями возврата</a>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <a id="lnk_cbaccept" href="#">Условия оплаты</a>
                        </div>
                    </div>

                    <div class="col-12 mt-3 text-center">
                        <button
                            class="btn btn-primary"
                            type="button"
                            name="button"
                            data-id="<?php echo $data['product']['id'];?>"
                            onclick="buyDocument(this)">
                            Оплатить банковской картой <?php echo $data['product']['price'];?>руб.
                        </button>
                    </div>
                </form>
            </div>
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
            <input type="hidden" name="productid" value="<?php echo $data['product']['id'];?>">
            <input type="hidden" name="summ" value="<?php echo $data['product']['price'];?>">
            <?php echo csrf_field();?>
        </form>
    </div>

    <!-- <div id="warning-wrap-offcanvas" class="alert-container-offcanvas position-fixed bottom-0 end-0 p-3"></div> -->
</div>

<script type="text/javascript">
    prodCalc = '<?php echo addslashes($data['product']['calc']);?>';
</script>

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

// if (array_key_exists('email', $user)) {
//     $email = $user['email'];
// }

// echo ext_user_meta($user, 'email');
//
// echo '<pre>';
// var_dump($user);
// echo '</pre>';

insertTemplate('/templates/footer-pages', ['data' => $data]);
