function userAdd() {
    const form = document.querySelector('form#add-user');
    if ( !form ) return;
    const warningWrap = document.querySelector('#warning-wrap');
    const btn = form.elements.submit;
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        btn.style.pointerEvents = 'none';
        let formData = new FormData(form);
        formData.append('action', 'add_user');

        const searchParams = new URLSearchParams();
        for (const [key, value] of formData) {
            searchParams.append(key, value);
        }

        fetch("/user-admin-add", {
            method: "POST",
            body: searchParams
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка запроса');
            }
            return response.json();
        })
        .then(data => {
            if (data) {
                console.dir(data);
                if (data.class == 'error') {
                    document.querySelector('form#add-user input#name').classList.remove('is-invalid');
                    document.querySelector('form#add-user input#email').classList.remove('is-invalid');
                    for (var input of data.inputs) {
                        document.querySelector('form#add-user input#'+input).classList.add('is-invalid');
                    }
                    warningWrap.innerHTML = '';
                    alertAction(warningWrap, data.text, 'danger');
                    btn.style.pointerEvents = '';
                } else if (data.class == 'success') {
                    document.querySelector('form#add-user input#name').classList.remove('is-invalid');
                    document.querySelector('form#add-user input#email').classList.remove('is-invalid');
                    // document.querySelector('form#add-user input#name').classList.add('is-valid');
                    // document.querySelector('form#add-user input#email').classList.add('is-valid');
                    warningWrap.innerHTML = '';
                    alertAction(warningWrap, data.text, 'success');
                    form.reset();
                }
                btn.style.pointerEvents = '';
            }
        })
        .catch(error => {
            console.dir(error);
        });
    });
}
userAdd();

function toastViews(wrap, title) {
    wrap.insertAdjacentHTML(
        'beforeend',
        `<div id="liveToast"
            class="toast fade show bg-primary mb-4"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-delay="2000">
            <div class="toast-body text-white">
                <div class="toast-title">${title}</div>
                <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                    <button type="button" class="btn btn-light btn-sm">Все пользователи</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Закрыть</button>
                </div>
            </div>
        </div>`
    );
}

function alertAction(wrap, message, type, jsAct='') {
    wrap.insertAdjacentHTML(
        'afterBegin',
        `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
        <strong>${message}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"${jsAct} aria-label="Закрыть"></button>
        </div>`
    );
}

function userEdit() {
    const userEditBtns = document.querySelectorAll('.js-user-edit');
    if ( !userEditBtns.length ) return;
    const warningWrap = document.querySelector('#warning-wrap');
    userEditBtns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            // console.dir(btn);
            if (btn.dataset.state == 'def') {
                btn.dataset.state = 'act';
                btn.title = 'Сохранить';
                btn.children[0].classList.remove('ri-edit-2-line');
                btn.children[0].classList.add('ri-save-3-fill');
                let inputs = btn.parentElement.parentElement.querySelectorAll('input');
                let select = btn.parentElement.parentElement.querySelector('select');

                for (var input of inputs) {
                    input.readOnly = false;
                    input.classList.add('border-1');
                    input.classList.remove('border-0');
                }

                select.disabled = false;
                select.classList.add('border-1');
                select.classList.remove('border-0');
            } else if (btn.dataset.state == 'act') {
                let wr = document.querySelector('tr#'+btn.dataset.id);
                const searchParams = new URLSearchParams();
                searchParams.append('email', wr.querySelector('input[name="email"]').value);
                searchParams.append('first_name', wr.querySelector('input[name="first_name"]').value);
                searchParams.append('roles_mask', wr.querySelector('select[name="roles_mask"]').value);
                searchParams.append('action', 'user_edit');
                searchParams.append('user_id', btn.dataset.id);
                searchParams.append('_token', document.querySelector('input[name="_token"]').value);

                fetch("/user-admin-edit", {
                    method: "POST",
                    body: searchParams
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Ошибка запроса');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        if (data.class == 'error') {
                            warningWrap.innerHTML = '';
                            alertAction(warningWrap, data.text, 'danger');
                        } else if (data.class == 'success') {
                            warningWrap.innerHTML = '';
                            alertAction(warningWrap, data.text, 'success');

                            btn.dataset.state = 'def';
                            btn.title = 'Редактировать';
                            btn.children[0].classList.add('ri-edit-2-line');
                            btn.children[0].classList.remove('ri-save-3-fill');
                            let inputs = btn.parentElement.parentElement.querySelectorAll('input');
                            let select = btn.parentElement.parentElement.querySelector('select');

                            for (var input of inputs) {
                                input.readOnly = true;
                                input.classList.remove('border-1');
                                input.classList.add('border-0');
                            }

                            select.disabled = true;
                            select.classList.remove('border-1');
                            select.classList.add('border-0');
                        }
                    }
                })
                .catch(error => {
                    console.dir(error);
                });
            }
        });
    });
}
userEdit();

function userEditAction(searchParams, warningWrap) {
    fetch("/user-admin-edit", {
        method: "POST",
        body: searchParams
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Ошибка запроса');
        }
        return response.json();
    })
    .then(data => {
        if (data) {
            console.dir(data);
            if (data.class == 'error') {

                if (data.email) {}
                warningWrap.innerHTML = '';
                alertAction(warningWrap, data.text, 'danger');
            } else if (data.class == 'success') {
                warningWrap.innerHTML = '';
                alertAction(warningWrap, data.text, 'success');
            }
        }
    })
    .catch(error => {
        console.dir(error);
    });
}

function productAddEdit() {
    const form = document.querySelector('form#add-edit-product');
    if ( !form ) return;
    const btn = form.elements.submit;
    const warningWrap = document.querySelector('#warning-wrap');
    let typeActions = btn.dataset.type;

    const quillWrap = document.querySelector('#snow-editor');
    const quill = new Quill(quillWrap, {
        modules: {
            history: {
                delay: 2000,
                maxStack: 500,
                userOnly: true
            },
            toolbar: toolbarOptions()
        },
        // placeholder: 'Описание...',
        theme: 'snow',
        bounds: quillWrap,
    });

    const undoButton = document.querySelector('.ql-undo');
    const redoButton = document.querySelector('.ql-redo');
    const iconLeft = `<svg viewBox="0 0 512 512" width="16" height="16">
    <path class="ql-fill" d="M48.5 224L40 224c-13.3 0-24-10.7-24-24L16 72c0-9.7 5.8-18.5 14.8-22.2s19.3-1.7 26.2 5.2L98.6 96.6c87.6-86.5 228.7-86.2 315.8 1c87.5 87.5 87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3c-62.2-62.2-162.7-62.5-225.3-1L185 183c6.9 6.9 8.9 17.2 5.2 26.2s-12.5 14.8-22.2 14.8L48.5 224z"/>
    </svg>`;
    const iconRight = `<svg viewBox="0 0 512 512" width="16" height="16">
    <path class="ql-fill" d="M463.5 224l8.5 0c13.3 0 24-10.7 24-24l0-128c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8l119.5 0z"/>
    </svg>`;

    undoButton.innerHTML = iconLeft;
    redoButton.innerHTML = iconRight;

    undoButton.addEventListener('click', () => {
        quill.history.undo();
    });

    redoButton.addEventListener('click', () => {
        quill.history.redo();
    });

    const varsItems = document.querySelectorAll('.vars-product button');
    let vars = [];
    for (var item of varsItems) {
        vars.push(item.dataset.varidPr);
    }

    document.querySelector('form#add-edit-product input#title').addEventListener('input', (e) => {
        document.querySelector('form#add-edit-product input#title').classList.remove('is-invalid');
    });

    btn.addEventListener('click', (e) => {
        e.preventDefault();
        btn.style.pointerEvents = 'none';
        const varsItems = document.querySelectorAll('.vars-product button');
        let vars = [];
        for (var item of varsItems) {
            vars.push(item.dataset.varidPr);
        }

        let url = '/admin/fetch';
        const length = quill.getLength();
        const html = quill.getSemanticHTML(0, length);

        let formData = new FormData(form);
        formData.append('descr', html);
        formData.append('vars', vars.join());

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
            if (data.message.result == 'success') {
                let url = '/admin/products';
                alertAction(warningWrap, data.message.text, 'success', ' onclick="locUrlAddProd()"');
                setTimeout(function(){
                    window.location = '/admin/products';
                }, 6000);
            }
            if (data.message.result == 'error') {
                btn.style.pointerEvents = '';
                alertAction(warningWrap, data.error.text, 'danger');
                document.querySelector('form#add-edit-product input#'+data.error.type).classList.add('is-invalid');
                setTimeout(function(){
                    warningWrap.innerHTML = '';
                }, 6000);
            }
        })
        .catch(error => {
            btn.style.pointerEvents = '';
            console.dir(error);
        });
    });
}
productAddEdit();

function locUrlAddProd() {
    window.location = '/admin/products';
}

function images(items) {
    let images = document.querySelector(items);
    let obj = {};
    if (images) {
        let i = 0;
        for (var item of images.children) {
            obj[i] = {
                'id': item.children[1].dataset.id,
                'link': item.children[1].dataset.path,
                'order': i
            };
            i++;
        }
    }
    return obj;
}

function uploadImages(elem, form) {
    let images = document.querySelector('.post-gallery-img');
    let thumbnail = document.querySelector('.post-thumbnail-wrap');
    let wrap = '';
    let loadingType = '';
    if (elem.id == 'post_thumbnail') {
        wrap = thumbnail;
        loadingType = 'one';
    } else if (elem.id == 'post_gallery') {
        wrap = images;
        loadingType = 'multi';
    }
    console.dir(elem);
    console.dir(form);
    console.dir(elem.id);

    let url = '/admin/upload';

    let formData = new FormData(form);
    formData.append('action', elem.id);
    formData.append('loadingType', loadingType);

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

        if (data.type == 'success') {
            if (data.files) {
                data.files.forEach((file, i) => {
                    wrap.insertAdjacentHTML(
                        'beforeEnd',
                        `<div class="post-gallery-edit-item" data-fname="${file.file_name}" data-order="${i}">
                        <img id="${file.id}" src="${file.link}" alt="">
                        <button type="button" class="btn btn-danger thumbnail-remove js-gallery-remove" data-id="${file.id}" data-path="${file.link}" onclick="removeGallery(this,form)">
                            <i class="ri-close-line"></i>
                        </button>
                        </div>`
                    );
                });
            } else if (data.file) {
                elem.previousElementSibling.classList.remove('activate');
                wrap.insertAdjacentHTML(
                    'beforeEnd',
                    `<div class="post-thumbnail-img" data-fname="${data.file.file_name}">
                    <img id="${data.file.id}" src="${data.file.link}" alt="">
                    <button type="button" class="btn btn-danger thumbnail-remove js-thumbnail-remove" data-id="${data.file.id}" data-path="${data.file.link}" onclick="removeGallery(this,form)">
                        <i class="ri-close-line"></i>
                    </button>
                    </div>`
                );
            }
        }
    })
    .catch(error => {
        console.dir(error);
    });
}

function toolbarOptions() {
    const options = [
        // [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        ['undo', 'redo'],

        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

        [{ 'font': [] }],

        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'link'],
        // ['link', 'formula'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'align': [] }],
        ['image']
    ];
    return options;
}

const tagsActions = () => {
    const tagsinput = document.querySelector('input#tags');
    if ( !tagsinput ) return;
    const tagitemsWrap = document.querySelector('.tagitems__wrap');
    const tagAdd = document.querySelector('input#tag_add');
    if (tagsinput.value) {
        let tags = tagsinput.value.split(',');
        tags.forEach((tag) => {
            tagRend(tagitemsWrap, tag);
        });
    }

    tagAdd.addEventListener('blur', (e) => {
        if (tagAdd.value) {
            if (tagsinput.value) {
                let tagsNew = tagsinput.value.split(',');
                tagsNew.push(tagAdd.value);
                console.dir(tagsNew);
                // console.dir(tagsF);
                tagsinput.value = tagsNew.join(',');
            } else {
                tagsinput.value = tagAdd.value;
            }
            tagRend(tagitemsWrap, tagAdd.value);
            // tagsinput.value = tagAdd.value;
            tagAdd.value = '';
            console.dir(tagsinput.value);
        }
    });
}
tagsActions();

function tagRend(wrap, tag) {
    wrap.insertAdjacentHTML(
        'beforeend',
        `<div class="btn btn-sm btn-outline-primary flex-row p-1 lh-1 tagitem">
            <span>${tag}</span>
            <i class="ri-close-line" data-tag="${tag}" onclick="removeTag(this, tags)"></i>
        </div>`
    );
}

function removeTag(elem, tagsinput) {
    elem.parentElement.remove();
    let tags = tagsinput.value.split(',');
    let newTags = tags.filter((tag) => tag !== elem.dataset.tag);
    tagsinput.value = newTags.join(',');
}

function removeThumb(elem) {
    elem.parentElement.nextElementSibling.value = elem.dataset.id;
    elem.parentElement.remove();
}

function removeGallery(elem, form) {
    let file = {};
    file.file_id = elem.dataset.id;
    file.file_path = elem.dataset.path;
    let url = '/admin/delete';
    let formData = new FormData(form);
    formData.append('action', 'delete_files');
    formData.append('file', JSON.stringify(file));
    deleteImageServer(url, formData);
    if (elem.classList.contains('js-thumbnail-remove')) {
        elem.parentElement.parentElement.nextElementSibling.classList.add('activate');
    }
    elem.parentElement.remove();
}

function deleteImageServer(url, formData) {
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
}

function deleteImgs(file) {
    location.reload();
}

function locRel() {
    location.reload();
}

function sortableInit() {
    const galleryItems = document.querySelector('.post-gallery-img');
    if (galleryItems) {
        new Sortable(galleryItems, {
            animation: 150,
            // ghostClass: 'blue-background-class',

            onEnd: function (/**Event*/evt) {
        		var itemEl = evt.item;  // dragged HTMLElement
        		evt.to;    // target list
        		evt.from;  // previous list
        		evt.oldIndex;  // element's old index within old parent
        		evt.newIndex;  // element's new index within new parent
        		evt.oldDraggableIndex; // element's old index within old parent, only counting draggable elements
        		evt.newDraggableIndex; // element's new index within new parent, only counting draggable elements
        		evt.clone // the clone element
        		evt.pullMode;  // when item is in another sortable: `"clone"` if cloning, `true` if moving

                console.dir(evt.from.children);

                // console.dir(orderImgs(document.querySelector('.post-gallery-img')));

                let img = 0;
                for (var item of evt.from.children) {
                    item.dataset.order = img;
                    img++;
                }
        	},
        });
    }
}
sortableInit();

function myFunc(input) {
    var files = input.files || input.currentTarget.files;
    var reader = [];
    var images = document.getElementById('images');
    var name;
    for (var i in files) {
        if (files.hasOwnProperty(i)) {
            name = 'file' + i;
            reader[i] = new FileReader();
            reader[i].readAsDataURL(input.files[i]);
            images.innerHTML += `<div class="post-gallery-edit-item" data-fname="${name}">
            <img id="${name}" src="" alt="">
            <button type="button" class="btn btn-danger thumbnail-remove js-thumbnail-remove" onclick="removeGallery(this)">
                <i class="ri-close-line"></i>
            </button>
            </div>`;
            (function (name) {
                reader[i].onload = function (e) {
                    console.log(document.getElementById(name));
                    document.getElementById(name).src = e.target.result;
                };
            })(name);
            console.log(files[i]);
        }
    }
}

function handleFileSelect(input) {
    var images = document.getElementById('images');
    var files = input.files;
    for (var i = 0, f; f = files[i]; i++) {
        if (!f.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
        reader.fileName = f.name
        reader.fileOrder = i
        reader.onload = (function(theFile) {
            return function(e) {
                images.innerHTML += `<div class="post-gallery-edit-item border" data-fname="${e.target.fileName}" data-order="${e.target.fileOrder}">
                <img src="${e.target.result}" alt="">
                <button type="button" class="btn btn-danger thumbnail-remove js-thumbnail-remove" data-fname="${e.target.fileName}" onclick="removeGallery(this)">
                    <i class="ri-close-line"></i>
                </button>
                </div>`;
                console.dir(e.target);
            };
        })(f);
        reader.readAsDataURL(f);
    }
}

function changeStatusOrder(elem) {
    const warningWrap = document.querySelector('#warning-wrap');
    let orderId = elem.dataset.id;
    let orderStatus = elem.value;
    console.dir(orderStatus);

    let url = '/dashboard/order-edit-status';
    let formData = new FormData();
    formData.append('action', 'order_edit_status');
    formData.append('order_id', orderId);
    formData.append('order_status', orderStatus);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    fetchGenerale(url, formData);

    elem.classList.remove('text-warning');
    elem.classList.remove('text-success');
    elem.classList.remove('text-dark');

    elem.classList.add(selected_order_status(orderStatus));

    warningWrap.innerHTML = '';
    alertAction(warningWrap, 'Статус заказа изменен', 'success');

    setTimeout(function(){
        warningWrap.innerHTML = '';
    }, 5000);
}

function fetchGenerale(url, formData) {
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
}

function selected_order_status(value)  {
    let elClass = '';
	if (value == 'created') {
		elClass = 'text-warning';
	} else if (value == 'processed') {
        elClass = 'text-success';
    } else if (value == 'completed') {
        elClass = 'text-dark';
    }
    return elClass;
}

function userSettings()  {
    const formSettings = document.querySelector('form.user-settings');
    const formPassword = document.querySelector('form.user-password');
    const warningWrap = document.querySelector('#warning-wrap');
    let url = '';
    if ( formSettings ) {
        const btnSet = formSettings.elements.submit;
        btnSet.addEventListener('click', (e) => {
            e.preventDefault();
            btnSet.style.pointerEvents = 'none';
            let formData = new FormData(formSettings);
            formData.append('action', 'user_settings');
            url = '/user-meta-edit';
            fetchGenerale(url, formData);
            warningWrap.innerHTML = '';
            alertAction(warningWrap, 'Профиль изменен', 'success');
            setTimeout(function(){
                warningWrap.innerHTML = '';
                btnSet.style.pointerEvents = '';
            }, 5000);
        });
    }

    if ( formPassword ) {
        const btnPass = formPassword.elements.submit;
        btnPass.addEventListener('click', (e) => {
            e.preventDefault();
            btnPass.style.pointerEvents = 'none';
            let fv = formValidate(formPassword);
            let fvp = formValidatePass();
            if (fv+fvp > 0) {
                console.dir('No');
            } else {
                let formData = new FormData(formPassword);
                formData.append('action', 'user_password');
                url = '/user-pass-edit';
                fetchGenerale(url, formData);
                warningWrap.innerHTML = '';
                alertAction(warningWrap, 'Пароль изменен', 'success');
                formReset(formPassword);
                setTimeout(function(){
                    warningWrap.innerHTML = '';
                    btnPass.style.pointerEvents = '';
                }, 5000);
            }
        });
    }
}
userSettings();

function formValidate(form) {
    let f = 0;
    for (var input of form.elements) {
        if (input.required == true) {
            if (!input.value) {
                input.classList.add('is-invalid');
                if (input.id == 'password_new' || input.id == 'password_re') {
                    input.nextElementSibling.nextElementSibling.style.display = 'none';
                }
                f++;
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }
        }
    }
    return f;
}

function formValidatePass() {
    const passNew = document.querySelector('input#password_new');
    const passRe = document.querySelector('input#password_re');
    let f = 0;
    if (passNew.value != passRe.value) {
        passNew.classList.add('is-invalid');
        passRe.classList.add('is-invalid');

        passNew.nextElementSibling.nextElementSibling.style.display = '';
        passRe.nextElementSibling.nextElementSibling.style.display = '';
        f++;
    }
    return f;
}

function formReset(form) {
    for (var input of form.elements) {
        if (input.required == true) {
            input.classList.remove('is-valid');
            input.classList.remove('is-invalid');
        }
    }
    form.reset();
}

function admEditUserPass(elem) {
    const warningWrap = document.querySelector('#warning-wrap');
    let formData = new FormData();
    formData.append('action', 'adm_edit_user_pass');
    formData.append('user_id', elem.dataset.id);
    formData.append('password_new', elem.previousElementSibling.children[1].value);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    let url = '/user-pass-edit-admin';
    fetchGenerale(url, formData);
    elem.previousElementSibling.children[1].value = '';
    warningWrap.innerHTML = '';
    alertAction(warningWrap, 'Пароль пользователя изменен', 'success');
    setTimeout(function(){
        warningWrap.innerHTML = '';
    }, 5000);
    // console.dir(elem.dataset.id);
    // console.dir(elem.previousElementSibling.children[1].value);
}

function formSiteSettings(elem) {
    const warningWrap = document.querySelector('#warning-wrap');
    let url = '/admin/settings-post';
    let formData = new FormData(elem.form);
    fetchGenerale(url, formData);
    warningWrap.innerHTML = '';
    alertAction(warningWrap, 'Настройки сохранены', 'success');
    setTimeout(function(){
        warningWrap.innerHTML = '';
    }, 5000);
}

function formUserLanding(elem) {
    const warningWrap = document.querySelector('#warning-wrap');
    let url = '/admin/settings-post';
    let formData = new FormData(elem.form);
    // fetchGenerale(url, formData);
    // warningWrap.innerHTML = '';
    // alertAction(warningWrap, 'Настройки сохранены', 'success');
    // setTimeout(function(){
    //     warningWrap.innerHTML = '';
    // }, 5000);

    console.dir(elem);
}

function sidebarLanding() {
    const html = document.querySelector('html');
    const url = new URL(window.location.href);
    if (url.pathname == '/dashboard/landing') {
        html.classList.remove("sidebar-enable");
        html.setAttribute("data-sidenav-size", 'condensed');

        window.addEventListener("resize", function(e) {
            if (window.innerWidth > 1140) {
                html.classList.remove("sidebar-enable");
                html.setAttribute("data-sidenav-size", 'condensed');
            }
        });
    }
}
sidebarLanding();

function sectionsVarsLink(elem) {
    document.querySelector('.vars-title').innerText = elem.children[0].children[0].innerText;
    const collapseVar = new bootstrap.Collapse('#collapseVar', {toggle: false});
    collapseVar.hide();
    let formData = new FormData();
    formData.append('action', 'change_vars');
    formData.append('var_id', elem.dataset.id);
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
        varsTableChange(data);
        elem.classList.add("active");
    })
    .catch(error => {
        console.dir(error);
    });
}

function varsTableChange(vars) {
    const listVars = document.querySelectorAll('.list-vars a');
    const tbody = document.querySelector('.vars-table tbody');
    if ( !listVars.length ) return;
    for (var variable of listVars) {
        variable.classList.remove("active");
    }
    tbody.innerHTML = '';
    if (vars.length) {
        vars.forEach((item) => {
            tbody.insertAdjacentHTML(
                'beforeend',
                `<tr id="var${item.id}">
                <td>${item.id}</td>
                <td>${item.title}</td>
                <td style="width: 40%;">${item.descr}</td>
                <td>...</td>
                <td><a href="javascript: void(0);"
                class="text-reset fs-16 px-1 js-var-edit"
                data-id="${item.id}"
                onclick="varsTableEdit(this)"
                title="Редактировать">
                    <i class="ri-edit-2-line"></i>
                </a><a href="javascript: void(0);"
                class="text-reset fs-16 px-1 ms-1 js-var-delete"
                data-id="${item.id}"
                onclick="varsTableDelete(this)"
                data-bs-toggle="modal"
                data-bs-target="#delete-var-modal"
                title="Удалить">
                    <i class="ri-delete-bin-line text-danger"></i>
                </a></td>
                </tr>`
            );
        });
    } else {
        let text = `<tr>
            <td></td>
            <td></td>
            <td><h4 class="fs-16 mt-3 fl-upp">Переменные еще не созданы</h4></td>
            <td></td>
            <td></td>
        </tr>`;
        tbody.innerHTML = text;
    }
}

function selectChange(elem) {
    elem.classList.remove('is-invalid');
}

function inputChange(elem) {
    elem.classList.remove('is-invalid');
}

function myModal(modaiId) {
    const modal = document.getElementById(modaiId);
    const myModal = new bootstrap.Modal(modal, {
        keyboard: false
    });
    return myModal;
}

function formReset(modalId, formId) {
    let form = document.getElementById(formId);
    let modal = document.getElementById(modalId);
    if (modal) {
        modal.addEventListener('hidden.bs.modal', (e) => {
            form.reset();
            for (var variable of form.elements) {
                variable.classList.remove('is-invalid');
            }
        });
    }
}
formReset('modal-vargr-add', 'group_section');
formReset('modal-var-add', 'form_var_add');

function varsGrAdd() {
    const grAddBtn = document.querySelector('#grAddBtn');
    if (grAddBtn) {
        const grAddModal = myModal('modal-vargr-add');
        const warningWrap = document.querySelector('#warning-wrap');
        const form = document.getElementById('group_section');

        grAddBtn.addEventListener('click', (e) => {
            grAddBtn.style.pointerEvents = 'none';
            let formData = new FormData(form);
            formData.append('action', 'create_vargr');
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
                if (data.type == 'success') {
                    grAddModal.hide();
                    alertAction(warningWrap, 'Раздел создан', 'success');
                    grAddBtn.style.pointerEvents = '';
                    setTimeout(function(){
                        warningWrap.innerHTML = '';
                    }, 5000);
                } else {
                    if (data.parentid) {
                        form.elements.parentid.classList.add('is-invalid');
                        grAddBtn.style.pointerEvents = '';
                        alertAction(warningWrap, data.parentid, 'danger');
                        setTimeout(function(){
                            warningWrap.innerHTML = '';
                        }, 5000);
                    }
                    if (data.title) {
                        form.elements.title.classList.add('is-invalid');
                        grAddBtn.style.pointerEvents = '';
                        alertAction(warningWrap, data.title, 'danger');
                        setTimeout(function(){
                            warningWrap.innerHTML = '';
                        }, 5000);
                    }
                }
            })
            .catch(error => {
                console.dir(error);
            });
        });
    }
}
varsGrAdd();

function varAdd() {
    const varAddBtn = document.querySelector('#varAddBtn');

    if (varAddBtn) {
        const varAddModal = myModal('modal-var-add');
        const warningWrap = document.querySelector('#warning-wrap');
        const form = document.getElementById('form_var_add');

        varAddBtn.addEventListener('click', (e) => {
            varAddBtn.style.pointerEvents = 'none';
            let formData = new FormData(form);
            formData.append('action', 'create_var');
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
                if (data.type == 'success') {
                    varAddModal.hide();
                    alertAction(warningWrap, 'Переменная создана', 'success');
                    varAddBtn.style.pointerEvents = '';
                    setTimeout(function(){
                        warningWrap.innerHTML = '';
                    }, 5000);
                } else {
                    if (data.parentid) {
                        form.elements.parentid.classList.add('is-invalid');
                        varAddBtn.style.pointerEvents = '';
                        alertAction(warningWrap, data.parentid, 'danger');
                        setTimeout(function(){
                            warningWrap.innerHTML = '';
                        }, 5000);
                    }
                    if (data.title) {
                        form.elements.title.classList.add('is-invalid');
                        varAddBtn.style.pointerEvents = '';
                        alertAction(warningWrap, data.title, 'danger');
                        setTimeout(function(){
                            warningWrap.innerHTML = '';
                        }, 5000);
                    }
                }
            })
            .catch(error => {
                console.dir(error);
            });
        });
    }
}
varAdd();

function grPrAdd() {
    const grPrAddBtn = document.querySelector('#grPrAddBtn');

    if (grPrAddBtn) {
        const myModalPrAdd = document.getElementById('modal-productsgr-add');
        const prAddModal = myModal('modal-productsgr-add');
        const warningWrap = document.querySelector('#warning-wrap');
        const form = document.querySelector('#group_prod_section');

        myModalPrAdd.addEventListener('hidden.bs.modal', event => {
            form.reset();
        });

        grPrAddBtn.addEventListener('click', (e) => {
            grPrAddBtn.style.pointerEvents = 'none';
            let formData = new FormData(form);
            formData.append('action', 'create_group_prod');
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
                grPrAddBtn.style.pointerEvents = '';
                if (data.type == 'success') {
                    prAddModal.hide();
                    alertAction(warningWrap, 'Группа шаблонов создана', 'success');
                    setTimeout(function(){
                        warningWrap.innerHTML = '';
                    }, 5000);
                } else {
                    if (data.parentid) {
                        form.elements.parentid.classList.add('is-invalid');
                        alertAction(warningWrap, data.parentid, 'danger');
                        setTimeout(function(){
                            warningWrap.innerHTML = '';
                        }, 5000);
                    }
                    if (data.title) {
                        form.elements.title.classList.add('is-invalid');
                        alertAction(warningWrap, data.title, 'danger');
                        setTimeout(function(){
                            warningWrap.innerHTML = '';
                        }, 5000);
                    }
                }
            })
            .catch(error => {
                console.dir(error);
            });
        });
    }
}
grPrAdd();

function varsTableDelete(elem) {
    const deleteVarModal = document.getElementById('delete-var-modal');
    const deleteVarTitle = document.querySelectorAll('.delete-var-title');
    const deleteVarBtn = document.querySelector('#delete-var');
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

function productTableDelete(elem) {
    const deleteVarModal = document.getElementById('delete-product-modal');
    const deleteVarTitle = document.querySelectorAll('.delete-product-title');
    const deleteVarBtn = document.querySelector('#delete-product');
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

function varsDelete(elem) {
    const warningWrap = document.querySelector('#warning-wrap');
    console.dir(elem.dataset.id);
    console.dir(elem.dataset.par);

    let formData = new FormData();
    formData.append('action', 'delete_var');
    formData.append('var_id', elem.dataset.id);
    if (elem.dataset.par) {
        formData.append('root', elem.dataset.par);
    }
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
        document.querySelector('#var'+elem.dataset.id).remove();
        setTimeout(function(){
            warningWrap.innerHTML = '';
        }, 5000);
    })
    .catch(error => {
        console.dir(error);
    });
}

function productDelete(elem) {
    const warningWrap = document.querySelector('#warning-wrap');
    console.dir(elem.dataset.id);
    console.dir(elem.dataset.par);

    let formData = new FormData();
    formData.append('action', 'delete_product');
    formData.append('product_id', elem.dataset.id);
    if (elem.dataset.par) {
        formData.append('root', elem.dataset.par);
    }
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

function varsTableEdit(elem) {
    console.dir(elem.dataset.id);
}

function productStatusChange(elem) {
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
    formData.append('action', 'productStatusChange');
    formData.append('product_id', id);
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

function filtrProdBtn() {
    const group = document.querySelector('#productGroup');
    const chapter = document.querySelector('#productСhapter');
    setCookie('docDesProd', {group: group.value, chapter: chapter.value});
    location.reload();
}

function btnFilterClose() {
    deleteCookie('docDesProd');
    location.reload();
}

function filterActions() {
    const group = document.querySelector('#productGroup');
    if (!group) return;
    let ddp = getCookie('docDesProd', true);
    const btnFilterClose = document.querySelector('.btn-filter-close');
    if (ddp) {
        if (Number(ddp.group) || Number(ddp.chapter)) {
            btnFilterClose.classList.add('active');
            filterGroupChange(group, Number(ddp.chapter));
        }
    }
    // else {
    //     console.dir('No');
    // }
}
filterActions();

function filterGroupChange(elem, chapterId=0) {
    const chapter = document.querySelector('#productСhapter');
    let formData = new FormData();
    formData.append('action', 'filterGroupChange');
    formData.append('group', elem.value);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    url = '/admin/fetch';

    if (elem.value == 0) {
        chapter.innerHTML = '';
        chapter.insertAdjacentHTML(
            'beforeEnd',
            `<option value="0">Все разделы</option>`
        );
    } else {
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
            chapter.innerHTML = '';
            if (data.length) {
                let select = 0;
                chapter.insertAdjacentHTML(
                    'beforeEnd',
                    `<option value="0">Все разделы</option>`
                );
                data.forEach((item) => {
                    if (Number(chapterId) == item.id) {
                        select = ' selected';
                    } else {
                        select = '';
                    }
                    chapter.insertAdjacentHTML(
                        'beforeEnd',
                        `<option value="${item.id}"${select}>${item.title}</option>`
                    );
                });
            } else {
                chapter.insertAdjacentHTML(
                    'beforeEnd',
                    `<option value="0">Все разделы</option>`
                );
            }
        })
        .catch(error => {
            console.dir(error);
        });
    }
}

function tabContentText() {
    document.querySelector('html').dataset.sidenavSize = 'condensed';
}

function radioActions(elem) {
    console.dir(elem.value);
    let editor = document.querySelector('#snow-editor');
    editor.classList.remove('h600');
    editor.classList.remove('h-full');
    if (elem.value != 'h400') {
        editor.classList.add(elem.value);
        localStorage.setItem('hEditor', elem.value);
    } else {
        localStorage.removeItem('hEditor');
    }
}

function editorHeight() {
    const editor = document.querySelector('#snow-editor');
    const hEditor = localStorage.getItem('hEditor');
    if (hEditor) {
        editor.classList.add(hEditor);
        document.querySelector('input#'+hEditor).checked = true;
    }
}
editorHeight();

function clipboardActions(elemClass) {
    const warningWrap = document.querySelector('#warning-wrap-offcanvas');
    const clipboard = new ClipboardJS(elemClass, {
        container: document.getElementById('offcanvasVars'),
    });

    clipboard.on('success', function (e) {
        // console.info('Action:', e.action);
        // console.info('Text:', e.text);
        // console.info('Trigger:', e.trigger);

        e.clearSelection();
        warningWrap.innerHTML = '';
        alertAction(warningWrap, 'Скопирован текст: '+e.text, 'success');
        setTimeout(function(){
            warningWrap.innerHTML = '';
        }, 5000);
    });
}
clipboardActions('.vars-item .btn');

function filtrItemsSearch(inputId, items, itemClass) {
    const itemDiv = document.querySelector(itemClass);
    let arr = [];
    for (var item in items) {
        if (items.hasOwnProperty(item)) {
            arr.push(items[item]);
        }
    }
    let arrYes = [];
    if (varsYes) {
        for (var item in JSON.parse(varsYes)) {
            if (JSON.parse(varsYes).hasOwnProperty(item)) {
                arrYes.push(JSON.parse(varsYes)[item]);
            }
        }
    }
    const inputIt = document.querySelector('#'+inputId);
    if (inputId) {
        inputIt.addEventListener('input', (e) => {
            const newItems = arr.filter((item) => {
                return (item.title.toLowerCase().includes(e.target.value.toLowerCase()) || item.descr.toLowerCase().includes(e.target.value.toLowerCase()));
            })
            renderFiltrItems(arr, newItems, arrYes, itemDiv);
            // console.dir(arr);
            // console.dir(newItems);
            // console.dir(arrYes);
        })
    }
}
if (varsAll) {
    filtrItemsSearch('search-vars', JSON.parse(varsAll), '.vars-all');
}

function renderFiltrItems(arr, items, itemsYes, itemDiv) {
    const arrYes = [];
    for (var item in itemsYes) {
        if (itemsYes.hasOwnProperty(item)) {
            arrYes.push(itemsYes[item]);
        }
    }
    let arrYesNew = [];
    arrYes.forEach((item) => {
        arrYesNew.push(item['varid']);
    });

    arr.sort((a,b) => a.title.localeCompare(b.title));
    let content = '';
    arr.forEach((item) => {
        if (item.parentid != 0 && item.isgr == 1) {
            if (count_var(items, item.id)) {
                content += `<div id="cr${item.id}" class="gr-vars" data-grid-cr="${item.parentid}">`;
                content += `<div class="h4 mt-2">${item.title}</div>`;

                items.forEach((item_par) => {
                    if (item_par.parentid == item.id && item_par.isgr == 0) {
                        if (in_array(item_par.id, arrYesNew)) {
                            content += `<button type="button"
                                class="btn btn-outline-secondary w-100 text-start btn-var-prod"
                                data-varid-cr="${item_par.id}"
                                data-parid-cr="${item_par.parentid}"
                                disabled>`;
                            content += `<strong>${item_par.title}</strong> - `;
                            content += `${item_par.descr}`;
                            content += `</button>`;
                        } else {
                            content += `<button type="button"
                                class="btn btn-outline-secondary w-100 text-start btn-var-prod"
                                data-varid-cr="${item_par.id}"
                                data-parid-cr="${item_par.parentid}"
                                onclick="btnVarAddProd(this)">`;
                            content += `<strong>${item_par.title}</strong> - `;
                            content += `${item_par.descr}`;
                            content += `</button>`;
                        }
                    }
                });
                content += `</div>`;
            }
        }
    });

    itemDiv.innerHTML = '';
    itemDiv.insertAdjacentHTML(
        "beforeend",
        content
    );
}

function btnVarAddProd(elem) {
    let wrapProd = document.querySelector('.vars-product');
    let wrap = document.querySelector('#pr'+elem.dataset.paridCr);
    let varsList = document.querySelector('.vars-list');
    let btn = `<button type="button" class="btn btn-outline-secondary w-100 text-start btn-var-prod"
        data-varid-pr="${elem.dataset.varidCr}" data-parid-pr="${elem.dataset.paridCr}">
        ${elem.innerHTML}
        <span class="btn-var-del-prod float-end" data-varid-pr="${elem.dataset.varidCr}" data-parid-pr="${elem.dataset.paridCr}" data-prodid-pr="${getUrlSearch('id')}" title="Удалить переменную" onclick="btnVarDelProd(this)">
        <i class="ri-delete-bin-line text-danger"></i>
        </span>
        </button>`;
    if (wrap) {
        wrap.insertAdjacentHTML(
            "beforeend",
            btn
        );
    } else {
        let newWrap = `<div id="pr${elem.dataset.paridCr}" class="gr-vars"><div class="h4 mt-2">${elem.parentElement.children[0].innerText}</div></div>`;
        wrapProd.insertAdjacentHTML(
            "beforeend",
            newWrap
        );
        document.querySelector('#pr'+elem.dataset.paridCr).insertAdjacentHTML(
            "beforeend",
            btn
        );
    }
    elem.disabled = true;

    const vars = JSON.parse(varsAll);
    const varsArr = [];
    for (var item in vars) {
        if (vars.hasOwnProperty(item)) {
            varsArr.push(vars[item]);
        }
    }
    const newVar = varsArr.filter((item) => {
        return (item.id == elem.dataset.varidCr);
    })[0];

    varsList.insertAdjacentHTML(
        "beforeend",
        `<div class="vars-item d-flex gap-2 align-items-start mb-1" data-vit="${newVar.id}">
        <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-0 flex-shrink-0 text-truncate" data-clipboard-text="#${newVar.title}#">
        #${newVar.title}#
        </button>
        <span>${newVar.descr}</span>
        </div>`
    );
}

function btnVarDelProd(elem) {
    let countBtn = 0;
    countBtn = elem.parentElement.parentElement.querySelectorAll('button').length-1;
    elem.parentElement.remove();
    document.querySelector('button[data-varid-cr="'+elem.dataset.varidPr+'"]').disabled = false;
    if (!countBtn) {
        document.querySelector('#pr'+elem.dataset.paridPr).remove();
    }
    document.querySelector('.vars-item[data-vit="'+elem.dataset.varidPr+'"]').remove();
}

// if (varsAll) {
//     console.dir(JSON.parse(varsAll));
// }

function getUrlSearch(name){
   if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      return decodeURIComponent(name[1]);
}
// console.dir(getUrlSearch('id'));

function count_var(vars, var_id) {
    const arr = [];
    for (var item in vars) {
        if (vars.hasOwnProperty(item)) {
            arr.push(vars[item]);
        }
    }
    let count = 0;
    arr.forEach((item) => {
        if (item.parentid == var_id) {
            count++;
        }
    });
    return count;
}

function count_var_root(vars, root_id) {
    const arr = [];
    for (var item in vars) {
        if (vars.hasOwnProperty(item)) {
            arr.push(vars[item]);
        }
    }
    let parents = [];
    let count = 0;
    arr.forEach((item) => {
        if (item.parentid == root_id) {
            parents.push(item.id);
        }
    });
    arr.forEach((item) => {
        if (inArray(item.parentid, parents)) {
            count++;
        }
    });
    return count;
}

function in_array(value, array) {
    for(var i=0; i<array.length; i++){
        if(value == array[i]) return true;
    }
    return false;
}


function arrayCompare(a1, a2) {
    if (a1.length != a2.length) return false;
    var length = a2.length;
    for (var i = 0; i < length; i++) {
        if (a1[i] !== a2[i]) return false;
    }
    return true;
}
function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(typeof haystack[i] == 'object') {
            if(arrayCompare(haystack[i], needle)) return true;
        } else {
            if(haystack[i] == needle) return true;
        }
    }
    return false;
}

document.addEventListener("DOMContentLoaded", function () {
    var eventCalllback = function (e) {
        var el = e.target,
        clearVal = el.dataset.phoneClear,
        pattern = el.dataset.phonePattern,
        matrix_def = "+7(___) ___-__-__",
        matrix = pattern ? pattern : matrix_def,
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = e.target.value.replace(/\D/g, "");
        if (clearVal !== 'false' && e.type === 'blur') {
            if (val.length < matrix.match(/([\_\d])/g).length) {
                e.target.value = '';
                return;
            }
        }
        if (def.length >= val.length) val = def;
        e.target.value = matrix.replace(/./g, function (a) {
            return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? "" : a
        });
    }
    //var phone_inputs = document.querySelectorAll('[data-phone-pattern]');
    var phone_inputs = document.querySelectorAll('.phone_mask');
    for (let elem of phone_inputs) {
        for (let ev of ['input', 'blur', 'focus']) {
            elem.addEventListener(ev, eventCalllback);
        }
    }
});

// function translit(word) {
// 	var converter = {
// 		'а': 'a',    'б': 'b',    'в': 'v',    'г': 'g',    'д': 'd',
// 		'е': 'e',    'ё': 'e',    'ж': 'zh',   'з': 'z',    'и': 'i',
// 		'й': 'y',    'к': 'k',    'л': 'l',    'м': 'm',    'н': 'n',
// 		'о': 'o',    'п': 'p',    'р': 'r',    'с': 's',    'т': 't',
// 		'у': 'u',    'ф': 'f',    'х': 'h',    'ц': 'c',    'ч': 'ch',
// 		'ш': 'sh',   'щ': 'sch',  'ь': '',     'ы': 'y',    'ъ': '',
// 		'э': 'e',    'ю': 'yu',   'я': 'ya'
// 	};
// 	word = word.toLowerCase();
// 	var answer = '';
// 	for (var i = 0; i < word.length; ++i ) {
// 		if (converter[word[i]] == undefined){
// 			answer += word[i];
// 		} else {
// 			answer += converter[word[i]];
// 		}
// 	}
// 	answer = answer.replace(/[^-0-9a-z]/g, '-');
// 	answer = answer.replace(/[-]+/g, '-');
// 	answer = answer.replace(/^\-|-$/g, '');
// 	return answer;
// }
