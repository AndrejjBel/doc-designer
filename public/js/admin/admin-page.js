function pageTermChenge(elem) {
    const pageProductSelect = document.querySelector('#product');
    console.dir(elem.value);
    if (elem.value == 'cont_page') {
        pageProductSelect.disabled = true;
    } else {
        pageProductSelect.disabled = false;
        filterProductsChange(elem, pageProductSelect);
    }
}

const pageTermStart = () => {
    const pageTermSelect = document.querySelector('#page_gr');
    const pageProductSelect = document.querySelector('#product');
    if (!pageTermSelect) return;
    if (pageTermSelect.value == 'cont_page') {
        pageProductSelect.disabled = true;
    } else {
        filterProductsChange(pageTermSelect, pageProductSelect, pageTermSelect.dataset.pr);
    }
}
pageTermStart();

function filterProductsChange(elem, selectEl, chapterId=0) {
    const chapter = document.querySelector('#productСhapter');
    let formData = new FormData();
    formData.append('action', 'filterGroupChange');
    formData.append('group', elem.value);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    url = '/admin/fetch';

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Ошибка запроса');
        }
        return response.json();
    })
    .then(data => {
        console.dir(data);
        selectEl.innerHTML = '';
        if (data.length) {
            let select = 0;
            selectEl.insertAdjacentHTML(
                'beforeEnd',
                `<option value="0">Выберите шаблон</option>`
            );
            data.forEach((item) => {
                if (Number(chapterId) == item.id) {
                    select = ' selected';
                } else {
                    select = '';
                }
                selectEl.insertAdjacentHTML(
                    'beforeEnd',
                    `<option value="${item.id}"${select}>${item.title}</option>`
                );
            });
        } else {
            selectEl.insertAdjacentHTML(
                'beforeEnd',
                `<option value="0">Выберите шаблон</option>`
            );
        }
    })
    .catch(error => {
        console.dir(error);
    });
}

function pageProductChenge(elem) {
    elem.classList.remove('is-invalid');
    elem.parentElement.nextElementSibling.children[1].value = elem.selectedOptions[0].innerText;
}

const pageAddEdit = () => {
    const form = document.querySelector('#add-edit-page');
    if (!form) return;

    const pageBloks = document.querySelector('.page-contents').children;
    console.dir(pageBloks);

    const warningWrap = document.querySelector('#warning-wrap');
    const btn = form.elements.submit;
    // console.dir(btn);
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        btn.style.pointerEvents = 'none';

        const pageBloks = document.querySelector('.page-contents').children;
        const typeDispute = document.querySelector('#typeDispute');
        let ssiValue = '';
        if (typeDispute) {
            ssiValue = JSON.stringify(ssiValueAction(typeDispute.children));
        }
        let bloks = [];

        for (var variable of pageBloks) {
            bloks.push(variable.dataset.block);
        }

        let formData = new FormData(form);
        formData.append('ssi', ssiValue);
        formData.append('product', '');
        formData.append('situations', '');
        formData.append('bloks', bloks.join(','));
        url = '/admin/fetch';

        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка запроса');
            }
            return response.json();
        })
        .then(data => {
            console.dir(data);
            btn.style.pointerEvents = '';
            if (data.error.title) {
                document.querySelector('form#add-edit-page input#title').classList.add('is-invalid');
                alertAction(warningWrap, data.error.title, 'danger');
                setTimeout(function(){
                    warningWrap.innerHTML = '';
                }, 5000);
            }
            if (data.error.product) {
                document.querySelector('form#add-edit-page #product').classList.add('is-invalid');
                alertAction(warningWrap, data.error.product, 'danger');
                setTimeout(function(){
                    warningWrap.innerHTML = '';
                }, 5000);
            }
            if (data.message.result == 'success') {
                alertAction(warningWrap, data.message.text, 'success', ' onclick="locUrlAddProd()"');
                setTimeout(function(){
                    window.location = '/admin/pages';
                }, 5000);
            }
            if (data.message.result == 'successEdit') {
                alertAction(warningWrap, data.message.text, 'success', ' onclick="locUrlAddProd()"');
                setTimeout(function(){
                    warningWrap.innerHTML = '';
                }, 5000);
            }
        })
        .catch(error => {
            console.dir(error);
        });
    });
}
pageAddEdit();

function pageStatusChange(elem) {
    const warningWrap = document.querySelector('#warning-wrap');
    let id = elem.dataset.id;
    let status = elem.dataset.status;
    let text = elem.innerText;
    let newStatus = '';

    if (status == 1) {
        newStatus = 0;
    } else if (status == 0) {
        newStatus = 1;
    }

    let formData = new FormData();
    formData.append('action', 'pageStatusChange');
    formData.append('page_id', id);
    formData.append('status', newStatus);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    url = '/admin/fetch';

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Ошибка запроса');
        }
        return response.json();
    })
    .then(data => {
        console.dir(data);
        if (data.result = 'success') {
            alertAction(warningWrap, 'Статус изменен', 'success');
            if (text == 'Активен') {
                elem.innerText = 'Выкл';
                elem.classList.remove('btn-soft-success');
                elem.classList.add('btn-soft-danger');
                elem.dataset.status = 0;
            } else if (text == 'Выкл') {
                elem.innerText = 'Активен';
                elem.classList.remove('btn-soft-danger');
                elem.classList.add('btn-soft-success');
                elem.dataset.status = 1;
            }
            setTimeout(function(){
                warningWrap.innerHTML = '';
            }, 5000);
        } else {
            alertAction(warningWrap, 'Произошла ошибка, попробуйте позже', 'danger');
            setTimeout(function(){
                warningWrap.innerHTML = '';
            }, 5000);
        }
    })
    .catch(error => {
        console.dir(error);
    });
}

function pageTableDelete(elem) {
    const deleteVarModal = document.getElementById('delete-page-modal');
    const deleteVarTitle = document.querySelectorAll('.delete-page-title');
    const deleteVarBtn = document.querySelector('#delete-page');
    if (deleteVarBtn) {
        deleteVarBtn.dataset.id = elem.dataset.id;
        if (elem.dataset.par) {
            deleteVarBtn.dataset.par = elem.dataset.par;
        }
        deleteVarModal.addEventListener('hidden.bs.modal', (e) => {
            deleteVarBtn.dataset.id = 0;
            deleteVarBtn.dataset.par = '';
        })
    }
    if (deleteVarTitle.length) {
        deleteVarTitle.forEach((item) => {
            item.innerText = document.getElementById('title'+elem.dataset.id).innerText;
        });
        deleteVarModal.addEventListener('hidden.bs.modal', (e) => {
            deleteVarTitle.forEach((item) => {
                item.innerText = '';
            });
        })
    }
}

function pageDelete(elem) {
    const warningWrap = document.querySelector('#warning-wrap');
    console.dir(elem.dataset.id);

    let formData = new FormData();
    formData.append('action', 'delete_page');
    formData.append('page_id', elem.dataset.id);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    url = '/admin/fetch';

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Ошибка запроса');
        }
        return response.json();
    })
    .then(data => {
        console.dir(data);
        alertAction(warningWrap, data.message.text, 'success');
        document.querySelector('#prod'+elem.dataset.id).remove();
        setTimeout(function(){
            warningWrap.innerHTML = '';
        }, 5000);
    })
    .catch(error => {
        console.dir(error);
    });
}

function sortableBloksInit() {
    const contPage = document.querySelector('.page-contents');
    const contBloks = document.querySelector('.blocks-contents');
    if (contPage) {
        new Sortable(contPage, {
            sort: true,
            animation: 150
        });
    }
}
sortableBloksInit();

function btnBlockCont(elem) {
    let wrapPageCont = document.querySelector('.page-contents');
    let modalData = `data-block="${elem.dataset.block}"`;
    if (elem.dataset.block == 'ssi') {
        modalData = `data-bs-toggle="modal"
        data-bs-target="#blockContEdit"
        data-block="${elem.dataset.block}"
        onclick="btnContRender(this)"`;
        // modalData = `data-block="${elem.dataset.block}"
        // onclick="btnContRender(this)"`;
    }
    let btn = `<div class="button-block" data-block="${elem.dataset.block}">
        <button type="button" class="btn btn-outline-secondary w-100 text-start btn-blok"
        ${modalData}>
        <strong>${elem.innerText}</strong>
        </button>
        <span class="btn-blok-del" data-block="${elem.dataset.block}" title="Удалить блок" onclick="btnBlocksContsDel(this)">
        <i class="ri-delete-bin-line text-danger"></i>
        </span>
        </div>`;
    wrapPageCont.insertAdjacentHTML(
        "beforeend",
        btn
    );
    elem.disabled = true;
}

function btnBlocksContsDel(elem) {
    elem.parentElement.remove();
    document.querySelector('button[data-block="'+elem.dataset.block+'"]').disabled = false;
}

function numberCharacters(elem) {
    elem.nextElementSibling.children[1].innerText = elem.value.length;
    let count = Number(elem.nextElementSibling.children[0].innerText);
    if (elem.value.length > count) {
        elem.nextElementSibling.children[1].classList.remove('text-success');
        elem.nextElementSibling.children[1].classList.add('text-danger');
    } else {
        elem.nextElementSibling.children[1].classList.remove('text-danger');
        elem.nextElementSibling.children[1].classList.add('text-success');
    }
}

function numberCharactersStart(elemSel) {
    const elem = document.querySelector(elemSel);
    if ( !elem ) return;
    elem.nextElementSibling.children[1].innerText = elem.value.length;
    let count = Number(elem.nextElementSibling.children[0].innerText);
    if (elem.value.length > count) {
        elem.nextElementSibling.children[1].classList.remove('text-success');
        elem.nextElementSibling.children[1].classList.add('text-danger');
    } else {
        elem.nextElementSibling.children[1].classList.remove('text-danger');
        elem.nextElementSibling.children[1].classList.add('text-success');
    }
}
numberCharactersStart('#seo_title');
numberCharactersStart('#seo_description');

function btnContRender(elem) {
    const modalTitle = document.querySelector('.block-cont-edit .modal-title');
    const modalBody = document.querySelector('.block-cont-edit .modal-body');
    modalTitle.innerText = elem.children[0].innerText;

    let formData = new FormData();
    formData.append('action', 'block_cont_render');
    formData.append('block_name', elem.dataset.block);
    formData.append('page_id', document.querySelector('input[name="page_id"]').value);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    url = '/admin/fetch';

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Ошибка запроса');
        }
        return response.json();
    })
    .then(data => {
        // console.dir(data);
        if (!modalBody.children.length) {
            modalBody.innerHTML = data.modal_html;
        }
    })
    .catch(error => {
        console.dir(error);
    });
}

function addBtnTab(elem) {
    elem.parentElement.previousElementSibling.insertAdjacentHTML(
        "beforeend",
        `<div class="accordion-item stage-btns-item stage-btns-${elem.parentElement.previousElementSibling.children.length+1}">
            <h2 class="accordion-header position-relative" id="headingOne">
                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stage-btns${elem.parentElement.previousElementSibling.children.length+1}" aria-expanded="false" aria-controls="collapseOne">
                    <span class="stages-item-title">Кнопка ${elem.parentElement.previousElementSibling.children.length+1}</span>
                    <button class="btn btn-link mx-1 p-0 js-stage-item-delete" type="button" name="button" onclick="stageBtnDelete(this)" title="Удалить">
                        <i class="ri-delete-bin-line text-danger"></i>
                    </button>
                </button>
            </h2>
            <div id="stage-btns${elem.parentElement.previousElementSibling.children.length+1}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#${elem.parentElement.previousElementSibling.id}" style="">
                <div class="accordion-body">
                    <div class="stage-buttons-item">
                        <div class="stage_btn_text mb-2">
                            <label for="stage_btn_text${elem.parentElement.previousElementSibling.children.length+1}" class="form-label">Текст кнопки</label>
                            <input type="text" id="stage_btn_text${elem.parentElement.previousElementSibling.children.length+1}" name="stage_btn_text${elem.parentElement.previousElementSibling.children.length+1}" class="form-control stage_btn_text">
                        </div>
                        <div class="stage_btn_link mb-2">
                            <label for="stage_btn_link${elem.parentElement.previousElementSibling.children.length+1}" class="form-label">Ссылка кнопки</label>
                            <input type="text" id="stage_btn_link${elem.parentElement.previousElementSibling.children.length+1}" name="stage_btn_link${elem.parentElement.previousElementSibling.children.length+1}" class="form-control stage_btn_link">
                        </div>
                    </div>
                </div>
            </div>
        </div>`
    );
}

function stageBtnDelete(elem) {
    let wrap = elem.parentElement.parentElement.parentElement.children;
    elem.parentElement.parentElement.remove();
    let i = 1;
    for (var variable of wrap) {
        variable.querySelector('.accordion-button').dataset.bsTarget = '#stage-btns'+i;
        variable.querySelector('.accordion-collapse').id = 'stage-btns'+i;
        variable.querySelector('.stages-item-title').innerText = 'Кнопка '+i;
        variable.querySelector('.stage_btn_text').children[0].attributes.for.value = 'stage_btn_text'+i;
        variable.querySelector('.stage_btn_text').children[1].id = 'stage_btn_text'+i;
        variable.querySelector('.stage_btn_text').children[1].name = 'stage_btn_text'+i;

        variable.querySelector('.stage_btn_link').children[0].attributes.for.value = 'stage_btn_link'+i;
        variable.querySelector('.stage_btn_link').children[1].id = 'stage_btn_link'+i;
        variable.querySelector('.stage_btn_link').children[1].name = 'stage_btn_link'+i;
        i++;
    }
}

function addStagesItem(elem) {
    elem.parentElement.previousElementSibling.insertAdjacentHTML(
        "beforeend",
        `<div class="accordion-item stages-item">
            <h2 class="accordion-header position-relative" id="headingOne">
                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stage${elem.parentElement.previousElementSibling.children.length+1}" aria-expanded="false" aria-controls="collapseOne">
                    <span class="stages-item-title">Этап ${elem.parentElement.previousElementSibling.children.length+1}</span>
                    <button class="btn btn-link mx-1 p-0 js-stages-item-delete" type="button" name="button" onclick="stagesItemDelete(this)" title="Удалить">
                        <i class="ri-delete-bin-line text-danger"></i>
                    </button>
                </button>
            </h2>
            <div id="stage${elem.parentElement.previousElementSibling.children.length+1}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#${elem.parentElement.previousElementSibling.id}" style="">
                <div class="accordion-body">
                    <div class="stage_text mb-2">
                        <label for="stage_text${elem.parentElement.previousElementSibling.children.length+1}" class="form-label">Текст этапа</label>
                        <textarea class="form-control stage_text" id="stage_text${elem.parentElement.previousElementSibling.children.length+1}" name="stage_text${elem.parentElement.previousElementSibling.children.length+1}" rows="4"></textarea>
                        <span class="help-block">
                            <small>Допускается любой HTML</small>
                        </span>
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
        </div>`
    );
}

function stagesItemDelete(elem) {
    let wrap = elem.parentElement.parentElement.parentElement.children;
    elem.parentElement.parentElement.remove();
    let i = 1;
    for (var variable of wrap) {
        variable.querySelector('.accordion-button').dataset.bsTarget = '#stage'+i;
        variable.querySelector('.accordion-collapse').id = 'stage'+i;
        variable.querySelector('.stages-item-title').innerText = 'Этап '+i;
        variable.querySelector('.stage_text').children[0].attributes.for.value = 'stage_text'+i;
        variable.querySelector('.stage_text').children[1].id = 'stage_text'+i;
        variable.querySelector('.stage_text').children[1].name = 'stage_text'+i;
        i++;
    }
}

function addAccItem(elem) {
    elem.parentElement.previousElementSibling.insertAdjacentHTML(
        "beforeend",
        `<div class="accordion-item acc-item">
            <h2 class="accordion-header position-relative" id="headingOne">
                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tdi${elem.parentElement.previousElementSibling.children.length+1}" aria-expanded="false" aria-controls="collapseOne">
                    <span class="acc-item-title">Таб ${elem.parentElement.previousElementSibling.children.length+1}</span>
                    <button class="btn btn-link mx-1 p-0 js-acc-item-delete" type="button" name="button" onclick="accItemDelete(this)" title="Удалить">
                        <i class="ri-delete-bin-line text-danger"></i>
                    </button>
                </button>
            </h2>
            <div id="tdi${elem.parentElement.previousElementSibling.children.length+1}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#typeDispute" style="">
                <div class="accordion-body">
                    <div class="btn_text mb-2">
                        <label for="btn_text${elem.parentElement.previousElementSibling.children.length+1}" class="form-label">Текст кнопки</label>
                        <input type="text" id="btn_text${elem.parentElement.previousElementSibling.children.length+1}" name="btn_text[${elem.parentElement.previousElementSibling.children.length+1}]" class="form-control btn_text" oninput="accItemTitleAction(this)">
                    </div>
                    <div class="tab_title mb-2">
                        <label for="tab_title${elem.parentElement.previousElementSibling.children.length+1}" class="form-label">Заголовок таба</label>
                        <input type="text" id="tab_title${elem.parentElement.previousElementSibling.children.length+1}" name="tab_title[${elem.parentElement.previousElementSibling.children.length+1}]" class="form-control tab_title">
                    </div>
                    <div class="tab_text mb-2">
                        <label for="tab_text${elem.parentElement.previousElementSibling.children.length+1}" class="form-label">Текст таба</label>
                        <textarea class="form-control tab_text" id="tab_text${elem.parentElement.previousElementSibling.children.length+1}" name="tab_text[${elem.parentElement.previousElementSibling.children.length+1}]" rows="4"></textarea>
                        <span class="help-block">
                            <small>Допускается любой HTML</small>
                        </span>
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
                                            <textarea class="form-control stage_text" id="stage_text1" name="stage_text1" rows="4"></textarea>
                                            <span class="help-block">
                                                <small>Допускается любой HTML</small>
                                            </span>
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
        </div>`
    );
}

function accItemDelete(elem) {
    let wrap = elem.parentElement.parentElement.parentElement.children;
    elem.parentElement.parentElement.remove();
    let i = 1;
    for (var variable of wrap) {
        let accItemTitle = variable.querySelector('.acc-item-title').innerText;
        let ait = accItemTitle.replace(/[^a-zа-яё]/gi, '');
        if (ait == 'Таб') {
            variable.querySelector('.acc-item-title').innerText = 'Таб '+i;
        }
        variable.querySelector('.accordion-button').dataset.bsTarget = '#tdi'+i;
        variable.querySelector('.accordion-collapse').id = 'tdi'+i;

        variable.querySelector('.btn_text').children[0].attributes.for.value = 'btn_text'+i;
        variable.querySelector('.btn_text').children[1].id = 'btn_text'+i;
        variable.querySelector('.btn_text').children[1].name = 'btn_text'+i;

        variable.querySelector('.tab_title').children[0].attributes.for.value = 'tab_title'+i;
        variable.querySelector('.tab_title').children[1].id = 'tab_title'+i;
        variable.querySelector('.tab_title').children[1].name = 'tab_title'+i;

        variable.querySelector('.tab_text').children[0].attributes.for.value = 'tab_text'+i;
        variable.querySelector('.tab_text').children[1].id = 'tab_text'+i;
        variable.querySelector('.tab_text').children[1].name = 'tab_text'+i;
        i++;
    }
}

function  accItemTitleAction(elem) {
    elem.parentElement.parentElement.parentElement.previousElementSibling.children[0].children[0].innerText = elem.value;
}

function blockContAddEditAction() {
    const btn = document.querySelector('#blockContEditSubmit');
    if (!btn) return;
    const blockContEditModal = new bootstrap.Modal('#blockContEdit', {
        keyboard: false
    });
    btn.addEventListener('click', (e) => {
        let ssi = localStorage.getItem('ssi');
        const typeDispute = document.querySelector('#typeDispute');
        let ssiValue = ssiValueAction(typeDispute.children);

        // localStorage.setItem('ssi', JSON.stringify(ssiValue));

        console.dir(ssiValue);

        let formData = new FormData();
        formData.append('action', 'ssi_save');
        formData.append('block_id', 'ssi');
        formData.append('block_value', JSON.stringify(ssiValue));
        formData.append('page_id', document.querySelector('input[name="page_id"]').value);
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        url = '/admin/fetch';

        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка запроса');
            }
            return response.json();
        })
        .then(data => {
            console.dir(data);
        })
        .catch(error => {
            console.dir(error);
        });

        blockContEditModal.hide();
    });
}
blockContAddEditAction();

function ssiValueAction(items) {
    let dataObj = [];
    let i = 0;
    for (var variable of items) {
        let stagesItem = variable.querySelectorAll('.stages .stages-item');
        let stagesObj = stagesValue(stagesItem);
        dataObj[i] = {
            'btn_text': variable.querySelector('input.btn_text').value,
            'tab_title': variable.querySelector('input.tab_title').value,
            'tab_text': variable.querySelector('textarea.tab_text').value,
            'stages' : stagesObj
        };
        i++;
    }
    return dataObj;
}

function stagesValue(stages) {
    let dataObj = [];
    let i = 0;
    for (var variable of stages) {
        let stagesItem = variable.querySelectorAll('.stage-btns .stage-btns-item');
        let btnsStagesObj = btnsStagesValue(stagesItem);
        dataObj[i] = {
            'stage_text': variable.querySelector('textarea.stage_text').value,
            'btnsStages' : btnsStagesObj
        };
        i++;
    }
    return dataObj;
}

function btnsStagesValue(btnsStages) {
    let dataObj = [];
    let i = 0;
    for (var variable of btnsStages) {
        dataObj[i] = {
            'stage_btn_text': variable.querySelector('input.stage_btn_text').value,
            'stage_btn_link': variable.querySelector('input.stage_btn_link').value
        };
        i++;
    }
    return dataObj;
}
