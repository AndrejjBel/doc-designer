<div class="accordion type-dispute mb-2" id="typeDispute">
    <div class="accordion-item acc-item">
        <h2 class="accordion-header position-relative" id="headingOne">
            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tdi1" aria-expanded="false" aria-controls="collapseOne">
                <span class="acc-item-title">Таб 1</span>
                <button class="btn btn-link mx-1 p-0 js-acc-item-delete" type="button" name="button" onclick="accItemDelete(this)" title="Удалить">
                    <i class="ri-delete-bin-line text-danger"></i>
                </button>
            </button>
        </h2>
        <div id="tdi1" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#typeDispute" style="">
            <div class="accordion-body">
                <div class="btn_text mb-2">
                    <label for="btn_text1" class="form-label">Текст кнопки</label>
                    <input type="text" id="btn_text1" name="btn_text" class="form-control btn_text" oninput="accItemTitleAction(this)">
                </div>
                <div class="tab_title mb-2">
                    <label for="tab_title1" class="form-label">Заголовок таба</label>
                    <input type="text" id="tab_title1" name="tab_title" class="form-control tab_title">
                </div>
                <div class="tab_text mb-2">
                    <label for="tab_text" class="form-label">Текст таба</label>
                    <textarea class="form-control tab_text" id="tab_text" name="tab_text" rows="4"></textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Этапы</label>
                    <div class="accordion stages mb-2" id="stages">
                        <div class="accordion-item stages-item">
                            <h2 class="accordion-header position-relative" id="headingOne">
                                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stage1" aria-expanded="false" aria-controls="collapseOne">
                                    <span class="stages-item-title">Этап 1</span>
                                    <button class="btn btn-link mx-1 p-0 js-stages-item-delete" type="button" name="button" onclick="stagesItemDelete(this)" title="Удалить">
                                        <i class="ri-delete-bin-line text-danger"></i>
                                    </button>
                                </button>
                            </h2>
                            <div id="stage1" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#stages" style="">
                                <div class="accordion-body">
                                    <div class="stage_text mb-2">
                                        <label for="stage_text1" class="form-label">Текст этапа</label>
                                        <textarea class="form-control stage_text" id="stage_text1" name="stage_text" rows="4"></textarea>
                                    </div>

                                    <div class="stage-buttons mb-2">
                                        <label class="form-label">Кнопки</label>
                                        <div class="accordion mb-2 stage-btns" id="stage-btns"></div>

                                        <div class="mb-2 text-end">
                                            <button type="button" class="btn btn-primary" onclick="addBtnTab(this)">Добавить кнопку</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 text-end">
                        <button type="button" class="btn btn-primary" onclick="addStagesItem(this)">Добавить этап</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-2 text-end">
    <button type="button" class="btn btn-primary" onclick="addAccItem(this)">Добавить таб</button>
</div>
