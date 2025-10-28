<?php
insertTemplate('/templates/header-new', ['data' => $data]);
$user = $data['user'];
$link_lk = '/login';
if (is_login()) {
    $link_lk = '/dashboard/user-orders';
}
?>
<div class="container">
    <div class="row">

        <div class="col-12 p-4 py-md-5">

            <h1 class="text-center mb-5"><?php echo $data['product']['title'];?></h1>

            <div class="description mb-4">
                <?php echo htmlspecialchars_decode($data['product']['description'], ENT_NOQUOTES);?>

                <div class="description-bottom mt-2">
                    <p>После заполнения всех полей и оплаты, документ будет полностью сформирован и отправлен в форме файла .pdf на указанный Вами e-mail.</p>
                    <p>После оплаты файл с текстом документа будет доступен для скачивания в <a href="<?php echo $link_lk;?>" target="_blank">Личном кабинете</a>.</p>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-between product-btn">
                <button id="btn-fields" class="btn btn-primary mt-2 mt-md-0 d-inline-block d-lg-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasFields"
                aria-controls="offcanvasVars">Поля</button>

                <button
                    class="btn btn-primary mt-2 mt-md-0 pay-action"
                    type="button"
                    name="button"
                    onclick="payAction(this)">Купить за <?php echo $data['product']['price'];?>руб.</button>
            </div>
            <div class="row mt-3">
                <div class="col-lg-4 d-none d-lg-flex fields-list-col">
                    <div class="bg-white p-3 py-md-4 rounded shadow-sm w-100">
                        <h5 id="offcanvasFieldsLabel">Поля</h5>
                        <form id="fields-list" class="fields-list">
                            <?php echo fields_list_content($data['product']['descr'], $data['product']['vars'], $data['vars']);?>
                            <input type="hidden" name="productid" value="<?php echo $data['product']['id'];?>">
                            <input type="hidden" name="summ" value="<?php echo $data['product']['price'];?>">
                            <?php echo csrf_field();?>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-lg-8 p-4 py-md-4 bg-white rounded shadow-sm">
                    <div class="product-block ql-editor bg-white">
                        <?php echo replace_vars_content($data['vars'], $data['product']['descr']);?>
                    </div>
                </div>
            </div>

        </div>
    </div>
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
                <h4 class="modal-title" id="warning-form-modal-modalLabel">Не все поля формы заполнены!</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Заполнить поля</button>
                <!-- <button id="buy-product" type="button" class="btn btn-warning"
                    data-bs-dismiss="modal"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-buy-doc">Все равно купить</button> -->
            </div>
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
                                    Соглашаюсь с <a id="lnk_cbaccept" href="/privacy-policy">политикой конфиденциальности и обработкой
                                    персональных данных</a>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="user_cbaccept_ret" name="user_cbaccept_ret" required>
                                <label class="form-check-label" for="user_cbaccept_ret">
                                    Соглашаюсь с <a id="lnk_cbaccept" href="/payment-return-terms">условиями возврата</a>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <a id="lnk_cbaccept" href="/payment-return-terms">Условия оплаты</a>
                        </div>

                        <div class="mb-3">
                            <p>После оплаты документ будет полностью сформирован, файл с текстом документа отправлен на указанный Вами e-mail, также будет доступен для скачивания в <a href="<?php echo $link_lk;?>" target="_blank">Личном кабинете</a>.</p>
                        </div>
                    </div>
                    <?php echo csrf_field();?>

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
        </div>
    </div>
</div>

<div id="offcanvasFields" class="offcanvas offcanvas-start offcanvas-fields" tabindex="-1" aria-labelledby="offcanvasFieldsLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasFieldsLabel">Поля</h5>
    </div>
    <button type="button" class="btn-close text-reset btn-close-custom" data-bs-dismiss="offcanvas" aria-label="Close"></button>

    <div class="offcanvas-body syncscroll" name="pageSync">
        <form id="fields-list-mob" class="fields-list">
            <?php echo fields_list_content($data['product']['descr'], $data['product']['vars'], $data['vars']);?>
            <input type="hidden" name="productid" value="<?php echo $data['product']['id'];?>">
            <input type="hidden" name="summ" value="<?php echo $data['product']['price'];?>">
            <?php echo csrf_field();?>
        </form>
    </div>

    <!-- <div id="warning-wrap-offcanvas" class="alert-container-offcanvas position-fixed bottom-0 end-0 p-3"></div> -->
</div>

<script type="text/javascript">
    varsAll = '<?php echo addslashes(json_encode($data['varsJson'], JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));?>';
    prodCalc = '<?php echo addslashes($data['product']['calc']);?>';
</script>

<?php

// echo '<pre>';
// var_dump($data);
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);
