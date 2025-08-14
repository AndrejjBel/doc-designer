<?php
// $br_gen = 'Консоль';
// if ($data['mod'] == 'dashboard') {
//     $br_gen = 'Личный кабинет';
// }
?>
<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/admin">Консоль</a></li>
                                <li class="breadcrumb-item"><a href="/admin/products">Шаблоны</a></li>
                                <li class="breadcrumb-item active">Создать шаблон</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Создать шаблон</h4>
                        <!-- <h4 class="product-title"><?php //echo $data['product']['title'];?></h4> -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form id="add-edit-product" class="mb-5" enctype="multipart/form-data">
                        <ul class="nav nav-tabs nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#general"
                                data-bs-toggle="tab"
                                aria-expanded="false"
                                class="nav-link active">Основное</a>
                            </li>
                            <li class="nav-item">
                                <a href="#vars"
                                data-bs-toggle="tab"
                                aria-expanded="true"
                                class="nav-link">Переменные</a>
                            </li>
                            <li class="nav-item">
                                <a href="#text"
                                data-bs-toggle="tab"
                                aria-expanded="true"
                                class="nav-link">Текст шаблона</a>
                            </li> <!-- onclick="tabContentText()" -->
                            <li class="nav-item">
                                <a href="#calc"
                                data-bs-toggle="tab"
                                aria-expanded="true"
                                class="nav-link">Калькулятор</a>
                            </li>
                        </ul>

                        <?php if ($data['duplicate']) { ?>
                            <div class="tab-content mb-5">
                                <div class="tab-pane show active" id="general">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/general', ['mod' => $data['mod'], 'product' => $data['product'], 'products_gr' => $data['products_gr']]);?>
                                </div>
                                <div class="tab-pane" id="vars">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/vars', ['product' => $data['product'], 'product_id' => $data['duplicate'], 'vars' => $data['vars'], 'varsProduct' => $data['varsProduct']]);?>
                                </div>
                                <div class="tab-pane" id="text">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/text', ['product' => $data['product']]);?>
                                </div>
                                <div class="tab-pane" id="calc">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/calc', ['product' => $data['product'], 'vars' => $data['vars']]);?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="tab-content mb-5">
                                <div class="tab-pane show active" id="general">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/general-add', ['mod' => $data['mod'], 'products_gr' => $data['products_gr']]);?>
                                </div>
                                <div class="tab-pane" id="vars">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/vars-add', ['vars' => $data['vars']]);?>
                                </div>
                                <div class="tab-pane" id="text">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/text-add', ['mod' => $data['mod']]);?>
                                </div>
                                <div class="tab-pane" id="calc">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/calc-add', ['mod' => $data['mod']]);?>
                                </div>
                            </div>
                        <?php } ?>

                        <input type="hidden" name="action" value="add_product">
                        <input type="hidden" name="post_type" value="products">
                        <input type="hidden" name="product_id" id="product_id" value="<?php //echo $data['product_id'];?>">
                        <?php echo csrf_field();?>
                        <button type="submit" name="submit" data-type="add"  data-id="<?php //echo $data['product_id'];?>" class="btn btn-primary">Сохранить</button>
                    </form>

                </div>
            </div>

        </div>

    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);

    // $vars = [];
    // foreach ($data['varsProduct'] as $var) {
    //     $vars[] = $var['varid'];
    // }
    // $search = $vars;
    // $newVars = array_filter($data['vars'], function($_array) use ($search){
    //     return in_array($_array['id'], $search);
    // });

    // echo '<pre>';
    // var_dump($data);
    // echo '</pre>';
    ?>

</div>

<div class="offcanvas offcanvas-end offcanvas-vars" tabindex="-1" id="offcanvasVars" aria-labelledby="offcanvasVarsLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasVarsLabel">Переменные</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="vars-list">
            <?php
            if ($data['duplicate']) {
                varsForProduct($data['product']['vars'], $data['vars']);
            }
            ?>
        </div>
    </div>

    <div id="warning-wrap-offcanvas" class="alert-container-offcanvas position-fixed bottom-0 end-0 p-3"></div>
</div>

<script type="text/javascript">
    varsAll = '<?php echo addslashes(json_encode($data['varsJson'], JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));?>';
    // varsYes = '<?php //echo json_encode($data['varsProduct'], JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);?>';
</script>
