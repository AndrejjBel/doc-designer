jQuery(document).ready( function($){
    if ($('#add-edit-review').length) {
        $ ('[data-toggle="select2-hide-search"]').select2 ({
            minimumResultsForSearch : Infinity
        });
    }
});

window.addEventListener('load', function() {
    const status = document.querySelector('#status');
    const preloader = document.querySelector('#preloader');
    fadeOut(status);
    fadeOut(preloader);
});

function fadeOut(el) {
    el.style.opacity = 1;
    (function fade() {
        if ((el.style.opacity -= .1) < 0) {
            el.style.display = "none";
        } else {
            requestAnimationFrame(fade);
        }
    })();
};

function fadeIn(el, display) {
    el.style.opacity = 0;
    el.style.display = display || "block";
    (function fade() {
        var val = parseFloat(el.style.opacity);
        if (!((val += .1) > 1)) {
            el.style.opacity = val;
            requestAnimationFrame(fade);
        }
    })();
};

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

function glampingAddEdit() {
    const form = document.querySelector('form#add-edit-glamping');
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
    const postMetaTitle = document.querySelector('#post_meta_title');
    const postMetaDescription = document.querySelector('#post_meta_description');

    const thumbnail = document.querySelector('.post-thumbnail-wrap');
    if (!thumbnail.children.length) {
        thumbnail.nextElementSibling.classList.add('activate');
    }

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

    const status = document.querySelector('#status');
    const preloader = document.querySelector('#preloader');

    btn.addEventListener('click', (e) => {
        e.preventDefault();
        fadeIn(status);
        fadeIn(preloader);
        btn.style.pointerEvents = 'none';
        let url = '/glamping-admin-add';
        if (typeActions == 'edit') {
            url = '/glamping-admin-edit';
        }
        const length = quill.getLength();
        const html = quill.getSemanticHTML(0, length);

        let thumbnail = JSON.stringify(images('.post-thumbnail-wrap'));
        let imagesItems = JSON.stringify(images('.post-gallery-img'));

        let accGalleryes = document.querySelectorAll('.acc-post-gallery-img');
        let accImagesItems = [];
        accGalleryes.forEach((item, i) => {
            accImagesItems.push(accImages(item));
        });

        console.dir(accImagesItems);

        let formData = new FormData(form);
        formData.append('post_id', btn.dataset.id);
        formData.append('editor_html', html);
        formData.append('thumbnail', thumbnail);
        formData.append('imagesItems', imagesItems);
        formData.append('acc_imagesItems', JSON.stringify(accImagesItems));

        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка запроса');
            }
            fadeOut(status);
            fadeOut(preloader);
            return response.json();
        })
        .then(data => {
            btn.style.pointerEvents = '';
            console.dir(data);
            if (data.type == 'success') {
                fadeOut(status);
                fadeOut(preloader);
                alertAction(warningWrap, data.success.text, 'success', ' onclick="locRel()"');
                if (typeActions == 'add') {
                    setTimeout(function(){
                        window.location = `/${btn.dataset.mod}/glampings`;
                        // location.reload();
                    }, 4000);
                }
            }
            if (data.type == 'error') {
                fadeOut(status);
                fadeOut(preloader);
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
glampingAddEdit();

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

function accImages(images) {
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
    let wrap = elem.previousElementSibling.previousElementSibling;
    const spinnerThumb = document.querySelector('.js-spinner-thumb');
    const spinnerGallery = document.querySelector('.js-spinner-gallery');
    let loadingType = '';
    if (elem.multiple == false) {
        loadingType = 'one';
        elem.previousElementSibling.children[0].style.display = 'inline-block';
    } else if (elem.multiple == true) {
        loadingType = 'multi';
        elem.previousElementSibling.children[0].style.display = 'inline-block';
    }
    // console.dir(elem);

    let en = elem.id;
    let act = en.replace(/\[.+|\]/g, '');
    let url = '/admin/upload';

    let formData = new FormData(form);
    formData.append('action', en);
    formData.append('loadingType', loadingType);

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Ошибка запроса');
        } else {
            return response.json();
        }
    })
    .then(data => {
        console.dir(data);

        if (data.type == 'success') {
            if (data.files) {
                let dFiles = data.files;
                dFiles.forEach((file, i) => {
                    wrap.insertAdjacentHTML(
                        'beforeEnd',
                        `<div class="post-thumbnail-img border" data-fname="${file.file_name}" data-order="${i}">
                        <img id="${file.id}" src="/${file.link}" class="p-1" alt="">
                        <button type="button" class="btn btn-danger thumbnail-remove js-gallery-remove" data-position="gallery" data-id="${file.id}" data-path="${file.link}" onclick="removeGallery(this,form)">
                            <i class="ri-close-line"></i>
                        </button>
                        </div>`
                    );
                });
                elem.previousElementSibling.children[0].style.display = '';
            } else if (data.file) {
                elem.previousElementSibling.classList.remove('activate');
                wrap.insertAdjacentHTML(
                    'beforeEnd',
                    `<div class="post-thumbnail-img border" data-fname="${data.file.file_name}">
                    <img id="${data.file.id}" src="/${data.file.link}" class="p-1" alt="">
                    <button type="button" class="btn btn-danger thumbnail-remove js-thumbnail-remove" data-position="thumbnail" data-id="${data.file.id}" data-path="${data.file.link}" onclick="removeGallery(this,form)">
                        <i class="ri-close-line"></i>
                    </button>
                    </div>`
                );
                elem.previousElementSibling.children[0].style.display = '';
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
    if (elem.classList.contains('js-thumbnail-remove')) {
        elem.parentElement.parentElement.nextElementSibling.classList.add('activate');
    }
    elem.parentElement.remove();

    let file = {};
    file.file_id = elem.dataset.id;
    file.file_path = elem.dataset.path;
    file.file_position = elem.dataset.position;
    let thumbnail = JSON.stringify(images('.post-thumbnail-wrap'));
    let imagesItems = JSON.stringify(images('.post-gallery-img'));
    let accGalleryes = document.querySelectorAll('.acc-post-gallery-img');
    let accImagesItems = [];
    accGalleryes.forEach((item, i) => {
        accImagesItems.push(accImages(item));
    });
    let url = '/admin/delete';
    let formData = new FormData(form);
    formData.append('action', 'delete_files');
    formData.append('file', JSON.stringify(file));
    formData.append('thumbnail', thumbnail);
    formData.append('imagesItems', imagesItems);
    formData.append('acc_imagesItems', JSON.stringify(accImagesItems));
    deleteImageServer(url, formData);
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

function sortableInitAcc(elems) {
    const elemsSort = document.querySelector(elems);
    if (elemsSort) {
        new Sortable(elemsSort, {
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

                let it = 0;
                for (var item of evt.from.children) {
                    item.dataset.order = it;
                    it++;
                }
        	},
        });
    }
}
sortableInitAcc('.acc-options');

function sortableInitAll(elems) {
    const elemsSort = document.querySelectorAll(elems);
    if (elemsSort.length) {
        elemsSort.forEach((item) => {
            new Sortable(item, {
                animation: 150,
                onEnd: function (evt) {
                    let it = 0;
                    for (var item of evt.from.children) {
                        item.dataset.order = it;
                        it++;
                    }
            	},
            });
        });
    }
}
sortableInitAll('.acc-post-gallery-img');

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

function checkAll(elem) {
    // const inputs = document.querySelectorAll('.'+elem.dataset.check+' input');
    const inputs = elem.parentElement.nextElementSibling.querySelectorAll('input');
    if (+elem.dataset.checked) {
        for (var input of inputs) {
            input.checked = false;
            elem.dataset.checked = 0;
        }
    } else {
        for (var input of inputs) {
            input.checked = true;
            elem.dataset.checked = 1;
        }
    }
}

function accAdd(el) {
    const warningWrap = document.querySelector('#warning-wrap');
    let parent = document.querySelector('.acc-options');
    let titles = parent.querySelectorAll('input.acc_type_title');
    let t = 0;
    for (var title of titles) {
        if (!title.value) {
            t++;
        }
    }
    if (t) {
        warningWrap.innerHTML = '';
        alertAction(warningWrap, 'Заполните название варианта', 'danger');
        setTimeout(function(){
            warningWrap.innerHTML = '';
        }, 4000);
    } else {
        let elem = el.parentElement.previousElementSibling.children[0];
        let clone = elem.cloneNode(true);
        clone.querySelector('.accordion-button').innerText = 'Вариант размещения';
        clone.querySelector('.acc-post-gallery-img').innerHTML = '';
        clone.querySelector('textarea').value = '';
        let inputs = clone.querySelectorAll('input');
        for (var input of inputs) {
            if (input.type == 'checkbox') {
                input.checked = false;
            } else {
                input.value = '';
            }
        }
        parent.appendChild(clone);
        accAddNumber(parent.children);
        sortableInitAll('.acc-post-gallery-img');
    }
}

function accDelete(el) {
    el.parentElement.parentElement.remove();
    let parent = document.querySelector('.acc-options');
    accAddNumber(parent.children);
}

function accAddNumber(items) {
    // if (!items.length) return;
    let i = 0;
    for (var item of items) {
        item.dataset.order = i;
        item.children[0].children[0].dataset.bsTarget = '#acc-option'+i;
        item.children[1].id = 'acc-option'+i;

        let inputs = item.querySelectorAll('input');
        for (var input of inputs) {
            let n = input.name;
            let v = input.value;
            let dn = input.dataset.name;
            n = n.replace(/\[.+|\]/g, '');
            if (input.type == 'checkbox' || input.type == 'file') {
                let atrn = `${n}${i}`;
                let atrv = `${v}${i+1}`;
                // input.id = atrv;
                // input.setAttribute('name', n+'['+i+'][]');
                if (input.type == 'checkbox') {
                    input.setAttribute('name', n+'['+i+'][]');
                    input.id = atrv;
                    input.nextElementSibling.setAttribute('for', atrv);
                } else if (input.type == 'file') {
                    input.setAttribute('name', dn+'-'+i+'[]');
                    input.id = dn+'-'+i;
                    input.previousElementSibling.setAttribute('for', dn+'-'+i);
                }
            } else {
                input.setAttribute('name', n+'['+i+']');
            }
        }
        item.querySelector('textarea').setAttribute('name','acc_type_text['+i+']');
        i++;
    }
}
if (document.querySelector('.acc-options')) {
    accAddNumber(document.querySelector('.acc-options').children);
}

function accTitle(el) {
    if (el.value) {
        el.parentElement.parentElement.parentElement.previousElementSibling.children[0].innerText = el.value;
    } else {
        el.parentElement.parentElement.parentElement.previousElementSibling.children[0].innerText = 'Вариант размещения';
    }
}

function addLocation() {
    let form = document.querySelector('form#add_location');
    if (!form) return;

    let btnSubmit = form.elements.submit;
    btnSubmit.addEventListener('click', (e) => {
        e.preventDefault();
        let url = '/admin/location-add';

        let formData = new FormData(form);
        let img = JSON.stringify(images('.post-thumbnail-wrap'));
        formData.append('action', btnSubmit.dataset.type);
        formData.append('img', img);
        formData.append('loc_id', btnSubmit.dataset.id);

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

        // if (btnSubmit.dataset.type == 'add') {
        //     fetch(url, {
        //         method: "POST",
        //         body: formData
        //     })
        //     .then(response => {
        //         if (!response.ok) {
        //             throw new Error('Ошибка запроса');
        //         }
        //         return response.json();
        //     })
        //     .then(data => {
        //         console.dir(data);
        //     })
        //     .catch(error => {
        //         console.dir(error);
        //     });
        // }
    });
}
addLocation();

function editStatus(btn) {
    const warningWrap = document.querySelector('#warning-wrap');
    let url = '/admin/fetch';
    let token = document.querySelector('input[name="_token"]').value;

    let st = btn.previousElementSibling.children[1].value;

    let formData = new FormData();
    formData.append('_token', token);
    formData.append('action', 'edit_status');
    formData.append('post_type', btn.dataset.type);
    formData.append('id', btn.dataset.id);
    formData.append('status', st);

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
        if (data == 'success') {
            btn.parentElement.parentElement.previousElementSibling.innerHTML = postStatus(btn.previousElementSibling.children[1].value);
            warningWrap.innerHTML = '';
            alertAction(warningWrap, 'Статус изменен', 'success');
            setTimeout(function(){
                warningWrap.innerHTML = '';
            }, 4000);
        }
    })
    .catch(error => {
        console.dir(error);
    });
}

function postStatus(status) {
    const statusOptions = {
        publish: 'Опубликован',
        pending: 'На утверждении',
        draft: 'Черновик',
        private: 'Private'
    };
    return `<span class="status-value ${status}">${statusOptions[status]}</span>`;
}

function postAddEdit() {
    const form = document.querySelector('form#add-edit-post');
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
    const postMetaTitle = document.querySelector('#post_meta_title');
    const postMetaDescription = document.querySelector('#post_meta_description');

    const thumbnail = document.querySelector('.post-thumbnail-wrap');
    if (!thumbnail.children.length) {
        thumbnail.nextElementSibling.classList.add('activate');
    }

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

    const status = document.querySelector('#status');
    const preloader = document.querySelector('#preloader');

    btn.addEventListener('click', (e) => {
        e.preventDefault();
        fadeIn(status);
        fadeIn(preloader);
        btn.style.pointerEvents = 'none';
        let url = '/post-admin-add';
        if (typeActions == 'edit') {
            url = '/post-admin-edit';
        }
        const length = quill.getLength();
        const html = quill.getSemanticHTML(0, length);

        let thumbnail = JSON.stringify(images('.post-thumbnail-wrap'));
        let imagesItems = JSON.stringify(images('.post-gallery-img'));

        let formData = new FormData(form);
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
            fadeOut(status);
            fadeOut(preloader);
            return response.json();
        })
        .then(data => {
            btn.style.pointerEvents = '';
            console.dir(data);
            if (data.type == 'success') {
                fadeOut(status);
                fadeOut(preloader);
                alertAction(warningWrap, data.success.text, 'success', ' onclick="locRel()"');
                if (typeActions == 'add') {
                    setTimeout(function(){
                        window.location = `/${btn.dataset.mod}/posts`;
                        // location.reload();
                    }, 4000);
                }
            }
            if (data.type == 'error') {
                fadeOut(status);
                fadeOut(preloader);
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
postAddEdit();

function reviewAddEdit() {
    const form = document.querySelector('form#add-edit-review');
    if ( !form ) return;
    const btn = form.elements.submit;
    const warningWrap = document.querySelector('#warning-wrap');
    let typeActions = btn.dataset.type

    const quillWrap = document.querySelector('#snow-editor');
    const quill = new Quill(quillWrap, {
        modules: {
            toolbar: toolbarOptions()
        },
        placeholder: 'Содержание отзыва...',
        theme: 'snow',
        bounds: quillWrap,
    });

    const postThumbnail = document.querySelector('input#post_thumbnail');
    const postGallery = document.querySelector('input#post_gallery');
    const postTitle = document.querySelector('input#post_title');
    const postSlug = document.querySelector('input#post_slug');
    const postLink = document.querySelector('#post-link a');
    const postMetaTitle = document.querySelector('#post_meta_title');
    const postMetaDescription = document.querySelector('#post_meta_description');

    // const thumbnail = document.querySelector('.post-thumbnail-wrap');
    // if (!thumbnail.children.length) {
    //     thumbnail.nextElementSibling.classList.add('activate');
    // }

    const galeryPath = document.querySelector('input[name="add-gallery-imgs"]');

    const dataThumbnail = document.querySelector('.post-thumbnail input[type="file"]');
    const dataGallery = document.querySelector('.post-gallery input[type="file"]');

    const status = document.querySelector('#status');
    const preloader = document.querySelector('#preloader');

    let urlStr = new URL(window.location);
    let postId = urlStr.searchParams.get('id');
    let mod = urlStr.pathname.split('/')[1];

    btn.addEventListener('click', (e) => {
        e.preventDefault();
        fadeIn(status);
        fadeIn(preloader);
        btn.style.pointerEvents = 'none';
        let url = '/review-add';
        if (typeActions == 'edit') {
            url = '/review-edit';
        }
        const length = quill.getLength();
        const html = quill.getSemanticHTML(0, length);

        let imagesItems = JSON.stringify(images('.post-gallery-img'));

        let formData = new FormData(form);
        formData.append('mod', mod);
        formData.append('post_id', postId);
        formData.append('editor_html', html);
        formData.append('imagesItems', imagesItems);

        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка запроса');
            }
            fadeOut(status);
            fadeOut(preloader);
            return response.json();
        })
        .then(data => {
            btn.style.pointerEvents = '';
            console.dir(data);
            if (data.type == 'success') {
                fadeOut(status);
                fadeOut(preloader);
                alertAction(warningWrap, data.success.text, 'success', ' onclick="locRel()"');
                if (typeActions == 'add') {
                    setTimeout(function(){
                        location.reload();
                    }, 4000);
                }
            }
            if (data.type == 'error') {
                fadeOut(status);
                fadeOut(preloader);
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
reviewAddEdit();

function postRatingChange(el) {
    if (el.value > 5) el.value = 5;
    if (el.value < 0) el.value = 0;
}

function locEdit(elem) {
    locEditRender(elem.dataset.id);
    const triggerEl = document.querySelector('#loc a[href="#location-add"]');
    const tabTrigger = new bootstrap.Tab(triggerEl);
    tabTrigger.show();
}

function locEditRender(locId) {
    const form = document.querySelector('form#add_location');
    const thumbnailWrap = form.querySelector('.post-thumbnail-wrap');
    console.dir(form);

    let url = '/admin/fetch';

    let formData = new FormData(form);
    formData.append('action', 'edit_location');
    formData.append('loc_id', locId);

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
        form.elements.location_title.value = data.title;
        form.elements.location_link.value = data.slug;
        form.elements.location_description.innerHTML = data.description;
        // seo
        let seo = JSON.parse(data.seo);
        form.elements.location_meta_title.value = seo.title;
        form.elements.location_meta_description.value = seo.description;
        form.elements.location_meta_keywords.value = seo.keywords;
        // btn
        form.elements.submit.innerText = 'Изменить';
        form.elements.submit.dataset.id = data.id;
        form.elements.submit.dataset.type = 'edit';

        if (data.img) {
            thumbnailWrap.nextElementSibling.classList.remove('activate');
            thumbnailWrap.innerHTML = '';
            let img = JSON.parse(data.img)[0];
            thumbnailWrap.insertAdjacentHTML(
                'beforeEnd',
                `<div class="post-thumbnail-img border" data-fname="${img.link}">
                <img id="${(img.id)?img.id:0}" src="${img.link}" class="p-1" alt="">
                <button type="button" class="btn btn-danger thumbnail-remove js-thumbnail-remove" data-position="thumbnail" data-id="${(img.id)?img.id:0}" data-path="${img.link}" onclick="removeGallery(this,form)">
                    <i class="ri-close-line"></i>
                </button>
                </div>`
            );
        }
    })
    .catch(error => {
        console.dir(error);
    });
}

function locFormReset() {
    const form = document.querySelector('form#add_location');
    const thumbnailWrap = form.querySelector('.post-thumbnail-wrap');
    form.reset();
    form.elements.location_description.innerHTML = '';
    thumbnailWrap.innerHTML = '';
    thumbnailWrap.nextElementSibling.classList.add('activate');
    form.elements.submit.innerText = 'Добавить';
    form.elements.submit.dataset.id = 0;
    form.elements.submit.dataset.type = 'add';
}

// const myModal = document.querySelector('#addPostInfo');
// new bootstrap.Modal(document.getElementById('centermodal')).show();

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

// const razm = {"@context":"https://schema.org","@graph":[{"@type":"WebPage","@id":"https://traveling-best.ru/","url":"https://traveling-best.ru/","name":"Отдых в России | Путешественник","isPartOf":{"@id":"https://traveling-best.ru/#website"},"about":{"@id":"https://traveling-best.ru/#organization"},"datePublished":"2024-10-01T09:00:38+00:00","dateModified":"2025-02-28T04:14:51+00:00","description":"Путешественник помогает найти и забронировать лучшие места для отдыха в России. Глэмпинги в лесу, на море и в горах с лучшими ценами.","breadcrumb":{"@id":"https://traveling-best.ru/#breadcrumb"},"inLanguage":"ru-RU","potentialAction":[{"@type":"ReadAction","target":["https://traveling-best.ru/"]}]},{"@type":"BreadcrumbList","@id":"https://traveling-best.ru/#breadcrumb","itemListElement":[{"@type":"ListItem","position":1,"name":"Главная страница"}]},{"@type":"WebSite","@id":"https://traveling-best.ru/#website","url":"https://traveling-best.ru/","name":"Путешественник","description":"","publisher":{"@id":"https://traveling-best.ru/#organization"},"potentialAction":[{"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://traveling-best.ru/?s={search_term_string}"},"query-input":{"@type":"PropertyValueSpecification","valueRequired":true,"valueName":"search_term_string"}}],"inLanguage":"ru-RU"},{"@type":"Organization","@id":"https://traveling-best.ru/#organization","name":"Путешественник","url":"https://traveling-best.ru/","logo":{"@type":"ImageObject","inLanguage":"ru-RU","@id":"https://traveling-best.ru/#/schema/logo/image/","url":"https://traveling-best.ru/wp-content/uploads/2025/02/cropped-cropped-logo-new.png","contentUrl":"https://traveling-best.ru/wp-content/uploads/2025/02/cropped-cropped-logo-new.png","width":512,"height":512,"caption":"Путешественник"},"image":{"@id":"https://traveling-best.ru/#/schema/logo/image/"}}]};
// console.dir(razm);

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
