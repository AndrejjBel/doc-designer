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
    console.dir(pageTermSelect.value);
    console.dir(pageTermSelect.dataset.pr);
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

    const warningWrap = document.querySelector('#warning-wrap');
    const btn = form.elements.submit;
    console.dir(btn);
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        btn.style.pointerEvents = 'none';

        let formData = new FormData(form);
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
    let btn = `<button type="button" class="btn btn-outline-secondary w-100 text-start btn-blok"
        data-blok="${elem.dataset.blok}">
        <strong>${elem.innerText}</strong>
        <span class="btn-var-del-prod float-end" data-blok="${elem.dataset.blok}" title="Удалить блок" onclick="btnBlocksContsDel(this)">
        <i class="ri-delete-bin-line text-danger"></i>
        </span>
        </button>`;
    wrapPageCont.insertAdjacentHTML(
        "beforeend",
        btn
    );
    elem.disabled = true;
}

function btnBlocksContsDel(elem) {
    elem.parentElement.remove();
    document.querySelector('button[data-blok="'+elem.dataset.blok+'"]').disabled = false;
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
