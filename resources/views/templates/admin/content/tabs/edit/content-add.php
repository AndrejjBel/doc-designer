<div class="content">

    <div class="container-fluid">

        <div class="row mb-2">
            <div class="col-12 col-md-6">
                <h4 class="page-title">Блоки контента</h4>

                <div class="blocks-contents d-flex gap-1 flex-column">
                    <button type="button"
                        class="btn btn-outline-secondary w-100 text-start btn-blok"
                        data-block="product"
                        onclick="btnBlockCont(this)">
                        <strong>Шаблон</strong>
                        <span class="btn-bloks-del inactive float-end"
                            data-block="product"
                            title="Удалить блок"
                            onclick="btnBlocksContsDel(this)">
                            <i class="ri-delete-bin-line text-danger"></i>
                        </span>
                    </button>

                    <button type="button"
                        class="btn btn-outline-secondary w-100 text-start btn-blok"
                        data-block="ssi"
                        onclick="btnBlockCont(this)">
                        <strong>Этапы решения вопроса</strong>
                        <span class="btn-bloks-del inactive float-end"
                            data-block="ssi"
                            title="Удалить блок"
                            onclick="btnBlocksContsDel(this)">
                            <i class="ri-delete-bin-line text-danger"></i>
                        </span>
                    </button>

                    <button type="button"
                        class="btn btn-outline-secondary w-100 text-start btn-blok"
                        data-block="situations"
                        onclick="btnBlockCont(this)">
                        <strong>Ситуации</strong>
                        <span class="btn-bloks-del inactive float-end"
                            data-block="situations"
                            title="Удалить блок"
                            onclick="btnBlocksContsDel(this)">
                            <i class="ri-delete-bin-line text-danger"></i>
                        </span>
                    </button>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <h4 class="page-title">Блоки на странице</h4>

                <div class="page-contents d-flex gap-1 flex-column"></div>
            </div>
        </div>
    </div>
</div>
