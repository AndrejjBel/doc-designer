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
                                <li class="breadcrumb-item"><a href="/admin/pages">Страницы</a></li>
                                <li class="breadcrumb-item active">Создать страницу</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Создать страницу</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form id="add-edit-page" class="mb-5" enctype="multipart/form-data">
                        <ul class="nav nav-tabs nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#general"
                                data-bs-toggle="tab"
                                aria-expanded="false"
                                class="nav-link active">Основное</a>
                            </li>
                            <li class="nav-item">
                                <a href="#text"
                                data-bs-toggle="tab"
                                aria-expanded="true"
                                class="nav-link">Структура страницы</a>
                            </li>
                        </ul>

                        <?php if ($data['duplicate']) { ?>
                            <div class="tab-content mb-5">
                                <div class="tab-pane show active" id="general">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/page-general', ['mod' => $data['mod'], 'page' => $data['page'], 'products_gr' => $data['products_gr'], 'duplicate' => $data['duplicate']]);?>
                                </div>
                                <div class="tab-pane" id="text">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/content-edit', ['mod' => $data['mod'], 'page' => $data['page'], 'product' => $data['product']]);?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="tab-content mb-5">
                                <div class="tab-pane show active" id="general">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/page-general-add', ['mod' => $data['mod'], 'products_gr' => $data['products_gr']]);?>
                                </div>
                                <div class="tab-pane" id="text">
                                    <?php insertTemplate('/templates/admin/content/tabs/edit/content-add', ['mod' => $data['mod']]);?>
                                </div>
                            </div>
                        <?php } ?>

                        <input type="hidden" name="action" value="add_page">
                        <input type="hidden" name="post_type" value="page">
                        <input type="hidden" name="page_id" id="page_id" value="<?php echo $data['duplicate'];?>">
                        <?php echo csrf_field();?>
                        <button type="submit" name="submit" data-type="add"  data-id="<?php //echo $data['product_id'];?>" class="btn btn-primary">Сохранить</button>
                    </form>

                </div>
            </div>

        </div>

    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);

    if ($data['duplicate']) {
        $blocks = json_decode($data['page']['blocks'], true);
        $modal_body = '';
        if ($blocks) {
            if (array_key_exists('ssi', $blocks)) {
                $ssi = json_decode($blocks['ssi']);
                $modal_body = blocks_modal_render($ssi);
            }
        }
    } else {
        $modal_body = '';
    }

    // $vars = [];
    // foreach ($data['varsProduct'] as $var) {
    //     $vars[] = $var['varid'];
    // }
    // $search = $vars;
    // $newVars = array_filter($data['vars'], function($_array) use ($search){
    //     return in_array($_array['id'], $search);
    // });

    // $is_post_slug = unicValueNotId('pages', 'slug', 8, 'testovaya-stranica-3');

    // echo '<pre>';
    // var_dump($data['duplicate']);
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

<div class="modal fade block-cont-edit" id="blockContEdit" tabindex="-1" aria-labelledby="blockContEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="blockContEditLabel"></h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button> -->
            </div>
            <div class="modal-body">
                <?php echo $modal_body;?>
            </div>
            <div class="modal-footer">
                <button id="blockContEditSubmit" type="button" class="btn btn-primary">Сохранить</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    varsAll = '<?php echo addslashes(json_encode($data['varsJson'], JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));?>';
</script>
