function navScroll(headerId) {
    const masthead = document.getElementById(headerId);
    let blockHeight = masthead.offsetHeight+3;
    const headerFixedHeight = document.querySelector('.header-fixed-height');
    if (headerFixedHeight) {
        headerFixedHeight.style.height = blockHeight+'px';
    }
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if ( currentScrollPos ) {}
        if (prevScrollpos > currentScrollPos) {
            masthead.style.top = "0";
        } else {
            if (prevScrollpos > 20) {
                masthead.style.top = '-'+blockHeight+'px';
            }
        }
        prevScrollpos = currentScrollPos;
    };
    window.addEventListener('resize', (e) => {
        blockHeight = masthead.offsetHeight+3;
        if (headerFixedHeight) {
            headerFixedHeight.style.height = blockHeight+'px';
        }
    });
}
navScroll('topnav');

function fetchGenerale(url, formData, returnText, returnCost) {
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
        let jsonData = JSON.parse(data.response);
        console.dir(jsonData);
        returnText.innerText = data.result;
        returnCost.innerText = 'Стоимость запроса: '+data.expenses+'₽';
    })
    .catch(error => {
        console.dir(error);
    });
}

function formGenTxt() {
    const form = document.querySelector('form#genTxt');
    if (!form) return;
    const returnText = document.querySelector('.return-text');
    const returnCost = document.querySelector('.return-cost');
    form.elements[4].addEventListener('click', (e) => {
        if (form.elements[1].value) {
            form.elements[1].classList.remove('is-invalid');
            let url = '/promt';
            let formData = new FormData(form);
            formData.append('action', 'promt');
            fetchGenerale(url, formData, returnText, returnCost);
        } else {
            form.elements[1].classList.add('is-invalid');
        }
    });
}
formGenTxt();

const fielddokClick = () => {
    const fielddokAll = document.querySelectorAll('.fielddok');
    if (!fielddokAll.length) return;
    const vars = JSON.parse(varsAll);
    const varsArr = [];
    for (var item in vars) {
        if (vars.hasOwnProperty(item)) {
            varsArr.push(vars[item]);
        }
    }
    const modalTitle = document.querySelector('#edit-var-text-modal .modal-title');
    const modalBody = document.querySelector('#edit-var-text-modal .modal-body');
    fielddokAll.forEach((item) => {
        item.addEventListener('click', (e) => {
            const newVar = varsArr.filter((elem) => {
                return (elem.id == item.dataset.id);
            })[0];
            let td = Number(newVar.typedata);
            let typedata = varsOptions('typedata_field')[td];
            let value = document.querySelector('.field-item[name="'+item.dataset.key+'"]').value.replace(/"/g, '&quot;');

            modalTitle.innerText = (newVar.descr)? newVar.descr : newVar.captholder;
            modalBody.innerHTML = fieldTd(typedata, item.dataset.key, value, newVar.extdata);

            let phone = '';
            if (typedata[2] == 'phone') {
                let inputElem = document.querySelector('input[data-title="'+item.dataset.key+'"]');
                for (let ev of ['input', 'blur', 'focus']) {
                    inputElem.addEventListener(ev, phone_mask);
                }
            }
            partyYur('#yur-magazin');
        });
    });
    // console.dir(JSON.parse(varsAll));
    // console.dir(JSON.parse(prodCalc));
}
fielddokClick();

function fieldFilling(elem) {
    let key = elem.dataset.title;
    let cont = document.querySelectorAll('.fielddok[data-key="'+key+'"]'); //.innerHTML = elem.value;
    cont.forEach((item) => {
        if (elem.type == 'date') {
            item.innerHTML = dateFormaterYearNew(elem.value, ' ')
        } else {
            item.innerHTML = elem.value;
            document.querySelector('input[name="'+key+'"]').value = elem.value.replace(/"/g, '&quot;');
        }
    });
}

function fieldFillingFd(elem) {
    let key = elem.dataset.title;
    console.dir(elem.dataset.title);
    let cont = document.querySelectorAll('.fielddok[data-key="'+key+'"]'); //.innerHTML = elem.value;
    cont.forEach((item) => {
        if (elem.type == 'date') {
            item.innerHTML = dateFormaterYearNew(elem.value, ' ');
            document.querySelector('input[name="'+key+'"]').value = elem.value;
        } else {
            item.innerHTML = elem.value;
            document.querySelector('input[name="'+key+'"]').value = elem.value.normalize(); //replace(/"/g, '&quot;');
        }
    });
}

function fieldFillingForm(elem) {
    let ih = document.querySelectorAll('span[data-key="'+elem.name+'"]');
    let inv = document.querySelectorAll('input[name="'+elem.name+'"]');
    let tanv = document.querySelectorAll('textarea[name="'+elem.name+'"]');
    console.dir(inv);
    if (inv.length) {
        for (var variable of inv) {
            if (variable != elem) {
                if (elem.type == 'date') {
                    variable.value = elem.value;
                } else if (true) {
                    variable.value = elem.value.replace(/"/g, '&quot;');
                }
            }
            variable.classList.remove('is-invalid');
        }
    }
    if (ih.length) {
        ih.forEach((item) => {
            if (elem.type == 'date') {
                item.innerHTML = dateFormaterYearNew(elem.value, ' ');
            } else {
                item.innerHTML = elem.value.replace(/"/g, '&quot;');
            }
            item.classList.remove('is-invalid');
        });
    }
    if (tanv.length) {
        for (var variable of tanv) {
            if (variable != elem) {
                variable.value = elem.value;
                console.dir(variable);
            }
            variable.classList.remove('is-invalid');
        }
    }
}

function fieldTd(typedata, name, value, optionsStr) {
    let phone = '';
    if (typedata[2] == 'phone') {
        phone = ' phone_mask';
    }
    if (typedata[0] == 'input') {
        return `<input type="${typedata[1]}" id="${name}" data-title="${name}" class="form-control${phone}" value="${value}" onblur="fieldFillingFd(this)">`;
    } else if (typedata[0] == 'textarea') {
        return `<textarea class="form-control" data-title="${name}" rows="2" onblur="fieldFillingFd(this)">${value}</textarea>`;
    } else if (typedata[0] == 'select') {
        let optionsArr = optionsStr.split(';');
        let options = ``;
        optionsArr.forEach((item) => {
            let optionsData = item.split(',');
            if (optionsData.length == 2) {
                options += `<option value="${optionsData[0]}">${optionsData[1]}</option>`;
            } else {
                options += `<option value="${optionsData[0]}">${optionsData[0]}</option>`;
            }
        });
        return `<select class="form-select" name="${name}" ${typedata[2]}>${options}</select>`;
    }
}

function dateFormaterYearNew(dateVal, separator) {
    const months = ['января' , 'февраля' , 'марта' , 'апреля' , 'мая' , 'июня' , 'июля' , 'августа' , 'сентября' , 'октября' , 'ноября' , 'декабря' ];
    let date = new Date(dateVal);
    var day = date.getDate();
    var month = months[date.getMonth()];
    var year = date.getFullYear();
    if (day < 10) {
        day = '0' + day;
    }
    if (month < 10) {
        month = '0' + month;
    }
    return day + separator + month + separator + year;
}

function varsOptions(name='') {
    const type = {
        1: 'Вводится клиентом',
        2: 'API Запрос в ФССП',
        3: 'Заголовок'
    };
    const typedata = {
        1: 'Текстовое поле',
        2: 'Цифровое поле',
        3: 'Выбор даты',
        4: 'Ввод телефона',
        5: 'Поле с выбором',
        6: 'Описание',
        7: 'Ссылки на документы',
        8: 'Поле с мультивыбором',
        9: 'Текстовая надпись'
    };

    const typedata_field = {
        1: ['input', 'text', ''],
        2: ['input', 'number', ''],
        3: ['input', 'date', ''],
        4: ['input', 'text', 'phone'],
        5: ['select', '', ''],
        6: ['textarea', '', ''],
        7: ['input', 'text', 'url'],
        8: ['select', 'multiple', ''],
        9: ['label', '', '']
    };
    let result = {};
    if (name == 'type') {
        result = type;
    }
    if (name == 'typedata') {
        result = typedata;
    }
    if (name == 'typedata_field') {
        result = typedata_field;
    }
    return result;
}

function calculatorActions() {
    const contPage = document.querySelector('.cont-page');
    if (contPage) return;
    // console.dir(prodCalc);
    const calc = JSON.parse(prodCalc);

    let inputs = [
        ...Array.from(document.querySelectorAll('input[name="'+calc.dateStart+'"]')),
        ...Array.from(document.querySelectorAll('input[name="'+calc.dateEnd+'"]')),
        ...Array.from(document.querySelectorAll('input[name="'+calc.cost+'"]'))
    ];
    for (let elem of inputs) {
        elem.addEventListener('blur', (e) => {
            if (validateInputs(inputs)) {
                calculator(calc);
            }
        });
    }
}
calculatorActions();

function calculator(calc) {
    let keyRate = calc.keyRate;
    let dateStart = document.querySelector('input[name="'+calc.dateStart+'"]').value;
    let dateEnd = document.querySelector('input[name="'+calc.dateEnd+'"]').value;
    let sum = document.querySelector('input[name="'+calc.cost+'"]').value;
    let startDate = new Date(dateStart);
    let endDate = new Date(dateEnd);
    let result = 0;
    if (calc.calc == 1) {
        result = ((sum*daysBetween(startDate, endDate)*2*0.0033)/100)*keyRate;
    }
    if (calc.calc == 2) {
        result = ((sum/100)*3)*daysBetween(startDate, endDate);
    }
    if (calc.calc == 3) {
        result = (sum/100)*daysBetween(startDate, endDate);
    }
    if (calc.calc == 4) {
        result = ((sum/100)*0.5)*daysBetween(startDate, endDate);
    }
    if (calc.calc == 5) {
        result = ((sum/100*keyRate)/365)*daysBetween(startDate, endDate);
    }

    // document.querySelector('input[name="'+calc.calculation+'"]').value = result;
    document.querySelectorAll('input[name="'+calc.calculation+'"]').forEach((item, i) => {
        item.value = result;
        item.classList.remove('is-invalid');
    });

    let ih = document.querySelectorAll('span[data-key="'+calc.calculation+'"]');
    if (ih.length) {
        ih.forEach((item) => {
            item.innerHTML = result;
            console.dir(item);
            console.dir(result);
        });
    }
}

function validateInputs(inputs) {
    let i = 0;
    for (var variable of inputs) {
        if (!variable.value) {
            i++;
        }
    }
    if (i == 0) {
        return true;
    } else {
        return false;
    }
}

function daysBetween(startDate, endDate) {
    if (!(startDate instanceof Date) || !(endDate instanceof Date)) {
        throw new Error('Применяйте корректные объекты Date.');
    }
    const diffTime = Date.UTC(endDate.getFullYear(), endDate.getMonth(), endDate.getDate()) -
        Date.UTC(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
    const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)) + 1;
    return diffDays ;
}

function calcType(typeId) {
    const calcsObj = {
        1: 'Неустойка по строительству ДДУ', // ((sum*numberDays*2*0.0033)/100)*keyRate
        2: 'Неустойка за любые услуги (3%)', // ((sum/100)*3)*numberDays
        3: 'Неустойка за бракованный товар (1%)', // (sum/100)*numberDays
        4: 'Неустойка за не поставленный товар (0,5%)', // ((sum/100)*0.5)*numberDays
        5: 'Процент за пользование чужими деньгами' // ((sum/100*keyRate)/365)*numberDays
    };
    return calcsObj[typeId];
}

function noselect() {
    return false;
}

const noselectAction = () => {
    const source = document.querySelector('.doc-page');
    if (!source) return;
    source.onselectstart = noselect;
    // source.ondragstart = noselect;
    // source.oncontextmenu = noselect;
}
noselectAction();

function payAction(elem) {
    const modalBuyDoc = new bootstrap.Modal('#modal-buy-doc');
    const modalWarning = new bootstrap.Modal('#warning-form-modal');
    const offcanvasFields = new bootstrap.Offcanvas('#offcanvasFields');

    const forms = document.querySelectorAll('form.fields-list');
    const btnFields = document.querySelector('#btn-fields');

    if (validateForm(forms)) {
        modalBuyDoc.show();
    } else {
        modalWarning.show();
    }

    const wfm = document.getElementById('warning-form-modal');
    wfm.addEventListener('hide.bs.modal', event => {
        let obArr = document.querySelectorAll('.offcanvas-backdrop');
        if (obArr.length) {
            obArr.forEach((item) => {
                item.remove();
            });
        }
        if (btnFields.checkVisibility()) {
            offcanvasFields.show();
        }
    });
}

function buyDocument(elem) {
    elem.style.pointerEvents = 'none';
    let fieldsListForm = document.querySelector('form#fields-list');
    const closeBtn = document.querySelector('#modal-buy-doc .btn-close');
    const btnFields = document.querySelector('#btn-fields');
    if (btnFields.checkVisibility()) {
        fieldsListForm = document.querySelector('form#fields-list-mob');
    }
    const successModal = new bootstrap.Modal('#success-form-modal', {
        // keyboard: false
    });
    const successModalAct = document.getElementById('success-form-modal');

    successModalAct.addEventListener('hidden.bs.modal', event => {
        location.reload();
    });
    // console.dir(elem);
    // console.dir(elem.form);
    // console.dir(fieldsListForm);
    // console.dir(validateForm(elem.form));

    if (validateForm([elem.form])) {
        let formData = new FormData(elem.form);
        let formDataFl = new FormData(fieldsListForm);

        formData.append('action', 'buyDocument');
        for (var pair of formDataFl.entries()) {
            formData.append(pair[0], pair[1]);
        }
        url = '/front/fetch';

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
            if (data.doc_url) {
                closeBtn.click();
                successModal.show();
            }
        })
        .catch(error => {
            console.dir(error);
        });
    }
}

function validateForm(forms) {
    let i = 0;
    forms.forEach((form) => {
        for (var variable of form.elements) {
            if (variable.type == 'checkbox') {
                if (variable.required == true) {
                    if (variable.checked == false) {
                        variable.classList.add('is-invalid');
                        i++;
                    }
                }
            } else {
                if (variable.type != 'button' && !variable.value) {
                    variable.classList.add('is-invalid');
                    i++;
                }
            }
        }
    });
    if (i == 0) {
        return true;
    } else {
        return false;
    }
}

function validateFormValid(selector) {
    const forms = document.querySelectorAll(selector);
    if (!forms.length) return;
    // for (var variable of form.elements) {
    //     variable.addEventListener('input', (e) => {
    //         if (e.target.value) {
    //             e.target.classList.remove('is-invalid');
    //         }
    //     });
    // }

    forms.forEach((form) => {
        for (var variable of form.elements) {
            variable.addEventListener('input', (e) => {
                if (e.target.value) {
                    e.target.classList.remove('is-invalid');
                }
            });
        }
    });
}
validateFormValid('form#fields-list');
validateFormValid('form#buy_doc_form');

// console.dir(document.querySelectorAll('form#fields-list'));

// document.querySelectorAll('form#fields-list').forEach((item, i) => {
//     console.dir(item);
// });


function phone_mask(e) {
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

var phone_inputs = document.querySelectorAll('.phone_mask');
for (let elem of phone_inputs) {
    for (let ev of ['input', 'blur', 'focus']) {
        elem.addEventListener(ev, phone_mask);
    }
}

// jQuery(document).ready( function($) {});

function partyYur(idName) {
    $(idName).suggestions({
        token: "69cff3e74a71d5ece8579d27a89e9532c70bcbf5",
        type: "PARTY",
        onSelect: function(suggestion) {
            console.log(suggestion);
            // $("#yur-magazin").val(suggestion.value);
            // $("#yur-inn").val(suggestion.data.inn);
            // $("#yur-ogrn").val(suggestion.data.ogrn);
            // $("#yur-adres").val(suggestion.data.address.value);

            document.querySelectorAll('input[name="yur-magazin"]').forEach((item, i) => {
                item.value = suggestion.value; //.replace(/"/g, '&quot;'); //.replace("\\\"", "&quot;");
                item.classList.remove('is-invalid');

                console.dir(suggestion.value.replaceAll('"', '\\"'));//.replace(/"/g, '&quot;'));
                console.dir(item);
            });
            document.querySelectorAll('input[name="yur-inn"]').forEach((item, i) => {
                item.value = suggestion.data.inn;
                item.classList.remove('is-invalid');
            });
            document.querySelectorAll('input[name="yur-ogrn"]').forEach((item, i) => {
                item.value = suggestion.data.ogrn;
                item.classList.remove('is-invalid');
            });
            document.querySelectorAll('textarea[name="yur-adres"]').forEach((item, i) => {
                item.value = suggestion.data.address.value;
                item.classList.remove('is-invalid');
                // item.innerText = suggestion.data.address.value;
            });


            // document.querySelector('input[name="yur-magazin"]').value = suggestion.value;
            // document.querySelector('input[name="yur-inn"]').value = suggestion.data.inn;
            // document.querySelector('input[name="yur-ogrn"]').value = suggestion.data.ogrn;
            // document.querySelector('textarea[name="yur-adres"]').value = suggestion.data.address.value;

            document.querySelector('input[name="yur-magazin"]').classList.remove('is-invalid');
            document.querySelector('input[name="yur-inn"]').classList.remove('is-invalid');
            document.querySelector('input[name="yur-ogrn"]').classList.remove('is-invalid');
            document.querySelector('textarea[name="yur-adres"]').classList.remove('is-invalid');

            $('span[data-key="yur-inn"]').html(suggestion.data.inn);
            $('span[data-key="yur-ogrn"]').html(suggestion.data.ogrn);
            $('span[data-key="yur-adres"]').html(suggestion.data.address.value);

            let ih = document.querySelectorAll('span[data-key="yur-magazin"]');
            if (ih.length) {
                ih.forEach((item) => {
                    item.innerHTML = suggestion.value;
                });
            }
        }
    });
}
const inputsSugg = document.querySelectorAll('#yur-magazin');
if (inputsSugg.length) {
    inputsSugg.forEach((item, i) => {
        partyYur(item);
    });
}

function htmlDecode(html) {
    var elem = document.createElement('textarea');
    elem.innerHTML = html;
    return elem.textContent;
}

function encodeHTMLEntities(text) {
    var textArea = document.createElement('textarea');
    textArea.innerText = text;
    return textArea.innerHTML;
}

function calculatorNb(btn) {
    let form = btn.parentElement.previousElementSibling;
    let cena = form.elements.cena.value;
    if (!cena) {
        form.elements.cena.classList.add('is-invalid');
    } else {
        form.elements.cena.classList.remove('is-invalid');
        let startDate = new Date(form.elements.payment_date.value);
        let endDate = new Date(form.elements.current_date.value);
        let days = daysBetween(startDate, endDate);
        let rnd = (cena/100).toFixed(2);
        let rnAll = (rnd*days).toFixed(2);
        document.querySelector('.cena-neust').innerText = cena;
        document.querySelector('.days-neust').innerText = days;
        document.querySelector('.rnAll-neust').innerText = rnAll;
        document.querySelectorAll('.rnd-neust').forEach((item) => {
            item.innerText = rnd;
        });
        btn.parentElement.nextElementSibling.classList.add('active');
        document.querySelector('#calc-btn').scrollIntoView({ behavior: 'smooth' });
    }
}

function pleloadImgsNav(btn) {
    console.dir(btn.dataset.page);
    console.dir(btn.parentElement.parentElement.children[0]);
    let piHeight = document.querySelector('.pleload-img img').offsetHeight+16;
    let pageNum = btn.dataset.page-1;
    btn.parentElement.parentElement.previousElementSibling.children[0].children[0].style.marginTop = '-'+pageNum*piHeight+'px';
    document.querySelector('.page-count span').innerText = btn.dataset.page;
    pleloadImgsNavActive();
    btn.disabled = true;
}

function pleloadImgsNavActive() {
    let navs = document.querySelectorAll('.pleload-imgs-nav-item button');
    if (navs) {
        navs.forEach((nav) => {
            nav.disabled = false;
        });
    }
}

function pleloadImgsHeight() {
    let pi = document.querySelector('.pleload-img img');
    if (pi) {
        let piHeight = pi.offsetHeight;
        document.querySelector('.pleload-imgs').style.height = piHeight+'px';
    }
}
pleloadImgsHeight();

window.addEventListener('resize', () => {
    if (document.querySelector('.calculators')) {
        pleloadImgsHeight();
        pleloadImgsNavActive();
        document.querySelector('.pleload-imgs-nav').children[0].children[0].disabled = true;
        document.querySelector('.page-count span').innerText = 1;
        document.querySelector('.pleload-imgs').children[0].style.marginTop = '0'
    }
});

function inputIsvalid(input) {
    input.classList.remove('is-invalid');
}

const testPay = () => {
    const btn = document.querySelector('#test');

    if (!btn) return;

    btn.addEventListener('click', (e) => {
        console.dir(btn);
        let url = '/paylink';
        let formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]'));

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
            // let jsonData = JSON.parse(data.response);
            // console.dir(jsonData);
        })
        .catch(error => {
            console.dir(error);
        });
    });
}
testPay();
