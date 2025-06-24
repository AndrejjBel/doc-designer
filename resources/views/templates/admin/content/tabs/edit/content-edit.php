<div class="content">

    <div class="container-fluid">

        <div class="row mb-2">
            <div class="col-12 col-md-6">
                <h4 class="page-title">Блоки контента</h4>

                <div class="blocks-contents d-flex gap-1 flex-column">
                    <button type="button"
                        class="btn btn-outline-secondary w-100 text-start btn-blok"
                        data-blok="1"
                        onclick="btnBlockCont(this)">
                        <strong>Этапы 1</strong>
                        <span class="btn-bloks-del inactive float-end"
                            data-block="1"
                            title="Удалить блок"
                            onclick="btnBlocksContsDel(this)">
                            <i class="ri-delete-bin-line text-danger"></i>
                        </span>
                    </button>

                    <button type="button"
                        class="btn btn-outline-secondary w-100 text-start btn-blok"
                        data-block="2"
                        onclick="btnBlockCont(this)">
                        <strong>Этапы 2</strong>
                        <span class="btn-bloks-del inactive float-end"
                            data-blok="2"
                            title="Удалить блок"
                            onclick="btnBlocksContsDel(this)">
                            <i class="ri-delete-bin-line text-danger"></i>
                        </span>
                    </button>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <h4 class="page-title">Блоки на странице</h4>

                <div class="page-contents d-flex gap-1 flex-column">
                    <button type="button"
                        class="btn btn-outline-secondary w-100 text-start btn-blok"
                        data-block="product">
                        <strong>Шаблон</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

// echo '<pre>';
// var_dump($product);
// echo '</pre>';
