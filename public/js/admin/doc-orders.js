function userOrderDocInfo() {
    const modalOrderInfo = document.getElementById("modalOrderDocInfo");
    if (!modalOrderInfo) return;
    modalOrderInfo.addEventListener("show.bs.modal", (e) => {
        let modalBody = e.target.querySelector(".modal-body");
        let ordersObj = JSON.parse(ordersArr);
        let order = ordersObj.find((obj) => {
            return obj.id == e.relatedTarget.dataset.order;
        });
        let lawyer = '';
        let lawyerInfo = '';
        if (order.status == 2) {
            lawyer = JSON.parse(order.lawyer);
            let li = (lawyer.fio)? lawyer.fio : lawyer.username;

            lawyerInfo = `<div class="alert alert-success d-flex justify-content-between" role="alert">
            <strong>В работе</strong>
            <p class="fw-bolder m-0">${li}</p>
            </div>`;
        }
        let clientmeta = JSON.parse(order.clientmeta);
        let strjson = JSON.parse(order.strjson);
        let vars = JSON.parse(varsAll);
        let gg = varsFilter(vars, "title", "firstname");

        let strjsonHtml = ``;

        for (const property in strjson) {
            if (property != "summ") {
                let keyName = varsFilter(vars, "title", property).descr;
                strjsonHtml += `<strong>${keyName}</strong><div class="order-info-item mb-1">${strjson[property]}</div>`;
            }
        }

        let userInfo = `<div class="user-info border-bottom">
        <h4 class="text-decoration-underline">Заказчик</h4>
        <p>${clientmeta.name}</p>
        <p>${clientmeta.phone}</p>
        <p>${clientmeta.email}</p>
        </div>`;

        let orderInfo = `<div class="order-info mt-2">
        <h4 class="text-decoration-underline">Заказ</h4>
        ${strjsonHtml}
        </div>`;

        modalBody.innerHTML = lawyerInfo + userInfo + orderInfo;
    });
}
userOrderDocInfo();

function doc_order_staus_change(btn) {
    const warningWrap = document.querySelector("#warning-wrap");
    let url = "/admin/fetch";
    let formData = new FormData();
    formData.append('action', 'doc_order_status_change');
    formData.append('id', btn.dataset.order);
    formData.append('status', 2);
    formData.append('_token', document.querySelector('input[name="_token"]').value);

    fetch(url, {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Ошибка запроса");
        }
        return response.json();
    })
    .then((data) => {
        console.dir(data);

        if (data.type == "success") {
            let dosw = document.querySelector("#doc-order-status-wrap-"+btn.dataset.order);
            let dos = document.querySelector("#doc-order-status-"+btn.dataset.order);
            dosw.insertAdjacentHTML(
                "beforeEnd",
                `<span id="lawyer-info-' . $order['id'] . '" class="d-flex badge badge-outline-success mt-1 w-fit-cont">
                    ${data.user_fio}
                </span>`
            );
            dos.innerText = 'В работе';
            dos.classList.remove("badge-outline-secondary");
            dos.classList.add("badge-outline-info");
            btn.remove();
            warningWrap.innerHTML = "";
            alertAction(warningWrap, "Заказ взят в работу", "success");
            setTimeout(function () {
                warningWrap.innerHTML = "";
            }, 5000);
        } else {
            warningWrap.innerHTML = "";
            alertAction(warningWrap, "Что-то пошло не так", "danger");
            setTimeout(function () {
                warningWrap.innerHTML = "";
            }, 5000);
        }
    })
    .catch((error) => {
        console.dir(error);
    });
}

function appointLawyer(btn) {
    let form = btn.parentElement;
    form.onsubmit = (e) => e.preventDefault();
    let dropdown = new bootstrap.Dropdown(btn.parentElement.parentElement)
    dropdown.hide();
    btn.parentElement.parentElement.previousElementSibling.classList.remove('show');
    console.dir(btn.parentElement);
    console.dir(btn.dataset.orderid);

    const warningWrap = document.querySelector("#warning-wrap");
    let url = "/admin/fetch";
    let formData = new FormData(form);
    formData.append('action', 'doc_order_lawyer_change');
    formData.append('id', btn.dataset.orderid);
    formData.append('_token', document.querySelector('input[name="_token"]').value);

    fetch(url, {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Ошибка запроса");
        }
        return response.json();
    })
    .then((data) => {
        console.dir(data);

        if (data.type == "success") {
            let dosw = document.querySelector("#doc-order-status-wrap-"+btn.dataset.orderid);
            let dos = document.querySelector("#doc-order-status-"+btn.dataset.orderid);
            let li = document.querySelector("#lawyer-info-"+btn.dataset.orderid);
            if (li) {
                li.innerText = data.user_fio;
            } else {
                dosw.insertAdjacentHTML(
                    "beforeEnd",
                    `<span id="lawyer-info-' . $order['id'] . '" class="d-flex badge badge-outline-success mt-1 w-fit-cont">
                        ${data.user_fio}
                    </span>`
                );
                dos.innerText = 'В работе';
                dos.classList.remove("badge-outline-secondary");
                dos.classList.add("badge-outline-info");
                btn.parentElement.parentElement.parentElement.previousElementSibling.remove();
            }
            warningWrap.innerHTML = "";
            alertAction(warningWrap, "Юрист назначен", "success");
            setTimeout(function () {
                warningWrap.innerHTML = "";
            }, 5000);
        } else {
            warningWrap.innerHTML = "";
            alertAction(warningWrap, "Что-то пошло не так", "danger");
            setTimeout(function () {
                warningWrap.innerHTML = "";
            }, 5000);
        }
    })
    .catch((error) => {
        console.dir(error);
    });
}

function uploadDoc(elem) {
    const warningWrap = document.querySelector("#warning-wrap");
    let loadingType = "one";
    let form = elem.parentElement;

    console.dir(elem);
    console.dir(form);
    console.dir(elem.id);

    let url = "/admin/upload-doc";

    let formData = new FormData(form);
    formData.append("action", elem.id);
    formData.append("order_id", elem.dataset.order);
    formData.append("loadingType", loadingType);

    fetch(url, {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Ошибка запроса");
        }
        return response.json();
    })
    .then((data) => {
        console.dir(data);

        if (data.type == "success") {
            form.nextElementSibling.setAttribute("href", data.file.link);
            form.nextElementSibling.children[0].classList.remove(
                "text-danger"
            );
            form.nextElementSibling.children[0].classList.add(
                "text-success"
            );
            warningWrap.innerHTML = "";
            alertAction(warningWrap, "Документ загружен", "success");
            setTimeout(function () {
                warningWrap.innerHTML = "";
            }, 5000);
        } else {
            warningWrap.innerHTML = "";
            alertAction(warningWrap, "Что-то пошло не так", "danger");
            setTimeout(function () {
                warningWrap.innerHTML = "";
            }, 5000);
        }
    })
    .catch((error) => {
        console.dir(error);
    });
}

function uploadDocForm() {
    const form = document.querySelector(".upload-document-form");
    if (!form) return;
    const warningWrap = document.querySelector("#warning-wrap");
    let btn = form.elements.submit;
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        let locUrl = new URL(window.location.href);

        let url = "/admin/doc-comments";

        let formData = new FormData(form);
        formData.append('action', 'doc_lawyer_upload');
        formData.append('doc_order', locUrl.searchParams.get('id'));
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        fetch(url, {
            method: "POST",
            body: formData,
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Ошибка запроса");
            }
            return response.json();
        })
        .then((data) => {
            console.dir(data);

            if (data.type == "success") {
                warningWrap.innerHTML = "";
                alertAction(warningWrap, "Документ загружен", "success");
                setTimeout(function () {
                    warningWrap.innerHTML = "";
                }, 5000);
            } else {
                warningWrap.innerHTML = "";
                alertAction(warningWrap, "Что-то пошло не так", "danger");
                setTimeout(function () {
                    warningWrap.innerHTML = "";
                }, 5000);
            }
        })
        .catch((error) => {
            console.dir(error);
        });
    });
}
uploadDocForm();

function commentForm() {
    const form = document.querySelector(".doc-comment-form");
    if (!form) return;
    const warningWrap = document.querySelector("#warning-wrap");
    let btn = form.elements.submit;
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        let locUrl = new URL(window.location.href);

        let url = "/admin/doc-comments";

        let formData = new FormData(form);
        formData.append('action', 'doc_comment_create');
        formData.append('doc_order', locUrl.searchParams.get('id'));
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        fetch(url, {
            method: "POST",
            body: formData,
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Ошибка запроса");
            }
            return response.json();
        })
        .then((data) => {
            console.dir(data);

            if (data.type == "success") {
                warningWrap.innerHTML = "";
                alertAction(warningWrap, "Сообщение отправлено", "success");
                setTimeout(function () {
                    warningWrap.innerHTML = "";
                }, 5000);
            } else {
                warningWrap.innerHTML = "";
                alertAction(warningWrap, "Что-то пошло не так", "danger");
                setTimeout(function () {
                    warningWrap.innerHTML = "";
                }, 5000);
            }
        })
        .catch((error) => {
            console.dir(error);
        });
    });
}
commentForm();

// setInterval(showmessage, 10000);
function showmessage() {
    console.dir("Прошло 10 секунд");
}

function observerAction(elem) {
    if (elem.dataset.views == 'novision') {
        // console.dir(elem.dataset.views);
        // console.dir(elem.id);
        // console.dir(elem.querySelector('.email-action-icons-item'));

        let url = "/admin/doc-comments";

        let formData = new FormData();
        formData.append('action', 'doc_comment_views_update');
        formData.append('comment_id', elem.id);
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        fetch(url, {
            method: "POST",
            body: formData,
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Ошибка запроса");
            }
            return response.json();
        })
        .then((data) => {
            console.dir(data);

            if (data.type == "success") {
                elem.querySelector('.email-action-icons-item').classList.remove('ri-mail-unread-line');
                elem.querySelector('.email-action-icons-item').classList.add('ri-mail-open-line');
            }
        })
        .catch((error) => {
            console.dir(error);
        });
    }
}

function observerMessage(target) {
    let options = {
        threshold: 1.0,
    };
    let callback = (entries, observer) => {
        if(entries[0].isIntersecting === true) {
            observerAction(entries[0].target);
            observer.disconnect();
        }
    };
    let observer = new IntersectionObserver(callback, options);
    observer.observe(target);
}
// observerMessage('#doc-order5');

function messageVision() {
    const mess = document.querySelectorAll('.comments-doc .message-item');
    if (!mess.length) return;
    mess.forEach((mes) => {
        observerMessage(mes);
    });
}
messageVision();

function infoDocOrderActions() {
    const infoDocOrder = document.querySelector('.info-doc-order');
    if (!infoDocOrder) return;
    infoDocOrder.addEventListener('click', (e) => {
        console.dir(infoDocOrder);
    });
}
infoDocOrderActions();
