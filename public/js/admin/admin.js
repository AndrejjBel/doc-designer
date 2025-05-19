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
    let typeActions = btn.dataset.type

    const quillWrap = document.querySelector('#snow-editor');
    const quill = new Quill(quillWrap, {
        modules: {
            toolbar: toolbarOptions()
        },
        placeholder: 'Описание...',
        theme: 'snow',
        bounds: quillWrap,
    });

    const postThumbnail = document.querySelector('input#post_thumbnail');
    const postGallery = document.querySelector('input#post_gallery');
    const postTitle = document.querySelector('input#post_title');
    const postSlug = document.querySelector('input#post_slug');
    const postLink = document.querySelector('#post-link a');
    const postMetaTitle = document.querySelector('input#post_meta_title');
    const postMetaDescription = document.querySelector('input#post_meta_description');

    const thumbnail = document.querySelector('.post-thumbnail-wrap');
    if (!thumbnail.children.length) {
        thumbnail.nextElementSibling.classList.add('activate');
    }
    console.dir(thumbnail);

    const galeryPath = document.querySelector('input[name="add-gallery-imgs"]');

    if (typeActions == 'add') {
        postTitle.addEventListener('blur', (e) => {
            postMetaTitle.value = postTitle.value;
        });

        quill.on('editor-change', (eventName) => {
            if (eventName === 'text-change') {
                let length = quill.getLength();
                postMetaDescription.value = quill.getText(0, length).replace(/\r?\n|\r/g, ' ');
            }
        });
    }

    const dataThumbnail = document.querySelector('.post-thumbnail input[type="file"]');
    const dataGallery = document.querySelector('.post-gallery input[type="file"]');

    // FilePond.registerPlugin(
    //     FilePondPluginImagePreview,
    //     FilePondPluginImageExifOrientation,
    //     FilePondPluginFileValidateSize,
    //     FilePondPluginImageEdit,
    //     FilePondPluginImageResize,
    //     // FilePondPluginFileEncode
    // );

    // const thumbnail = FilePond.create(postThumbnail,
    //     {
    //         labelIdle: 'Перетащите файлы или <span class="filepond--label-action"> Загрузите </span>',
    //         imagePreviewHeight: 150
    //     }
    // );
    // const gallery = FilePond.create(postGallery,
    //     {
    //         labelIdle: 'Перетащите файлы или <span class="filepond--label-action"> Загрузите </span>',
    //         imagePreviewHeight: 150
    //     }
    // );

    btn.addEventListener('click', (e) => {
        e.preventDefault();
        btn.style.pointerEvents = 'none';
        let url = '/product-admin-add';
        if (typeActions == 'edit') {
            url = '/product-admin-edit';
        }
        const length = quill.getLength();
        const html = quill.getSemanticHTML(0, length);
        // console.dir(html);

        // let thumbnailFiles = thumbnail.getFiles();
        // let galleryFiles = gallery.getFiles();
        // console.dir(galleryFiles);

        let imagesWrap = document.querySelector('.post-gallery-img');

        console.dir(images('.post-gallery-img'));
        let thumbnail = JSON.stringify(images('.post-thumbnail-wrap'));
        let imagesItems = JSON.stringify(images('.post-gallery-img'));

        let formData = new FormData(form);
        formData.append('action', 'edit_product');
        formData.append('post_id', btn.dataset.id);
        formData.append('editor_html', html);
        formData.append('thumbnail', thumbnail);
        formData.append('imagesItems', imagesItems);

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
            btn.style.pointerEvents = '';
            console.dir(data);
            if (data.type == 'success') {
                alertAction(warningWrap, data.success.text, 'success', ' onclick="locRel()"');
                if (typeActions == 'add') {
                    setTimeout(function(){
                        location.reload();
                    }, 6000);
                }
            }
            if (data.type == 'error') {
                if (data.error.user) {
                    window.location.href = '/';
                }
                if (data.error.post_title) {
                    postTitle.classList.add('is-invalid');
                    alertAction(warningWrap, data.error.post_title, 'danger');
                    btn.style.pointerEvents = '';
                }
            }
        })
        .catch(error => {
            btn.style.pointerEvents = '';
            console.dir(error);
        });
    });
}
productAddEdit();

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
        [{ 'align': [] }]
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
