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
