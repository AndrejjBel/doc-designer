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
        });
    });
    console.dir(JSON.parse(varsAll));
    // console.dir(varsAll);
}
fielddokClick();

function fieldFilling(elem) {
    let key = elem.dataset.title;
    let cont = document.querySelectorAll('.fielddok[data-key="'+key+'"] strong'); //.innerHTML = elem.value;
    cont.forEach((item) => {
        if (elem.type == 'date') {
            item.innerHTML = dateFormaterYearNew(elem.value, ' ')
        } else {
            item.innerHTML = elem.value;
            document.querySelector('input[name="'+key+'"]').value = elem.value.replace(/"/g, '&quot;');
        }
    });
}

function fieldFillingForm(elem) {
    let ih = document.querySelectorAll('span[data-key="'+elem.name+'"] strong');
    if (ih.length) {
        ih.forEach((item) => {
            if (elem.type == 'date') {
                item.innerHTML = dateFormaterYearNew(elem.value, ' ');
            } else {
                item.innerHTML = elem.value.replace(/"/g, '&quot;');
            }
        });
    }
}

function fieldTd(typedata, name, value, optionsStr) {
    if (typedata[0] == 'input') {
        return `<input type="${typedata[1]}" data-title="${name}" class="form-control" value="${value}" oninput="fieldFilling(this)">`;
    } else if (typedata[0] == 'textarea') {
        return `<textarea class="form-control" data-title="${name}" rows="2" oninput="fieldFilling(this)">${value}</textarea>`;
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

function calculator(type) {
    if (type == 1) {}
    if (type == 2) {}
    if (type == 3) {
        daysBetween(startDate, endDate);
    }
    if (type == 4) {}
    if (type == 5) {}
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

const source = document.querySelector('.page-templates');
source.onselectstart = noselect;
// source.ondragstart = noselect;
// source.oncontextmenu = noselect;

jQuery(document).ready( function($) {
    $("#yur-magazin").suggestions({
        token: "69cff3e74a71d5ece8579d27a89e9532c70bcbf5",
        type: "PARTY",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            console.log(suggestion);
            $("#yur-inn").val(suggestion.data.inn);
            $("#yur-ogrn").val(suggestion.data.ogrn);
            $("#yur-adres").val(suggestion.data.address.value);

            $('span[data-key="yur-inn"] strong').html(suggestion.data.inn);
            $('span[data-key="yur-ogrn"] strong').html(suggestion.data.ogrn);
            $('span[data-key="yur-adres"] strong').html(suggestion.data.address.value);
        }
    });
});
