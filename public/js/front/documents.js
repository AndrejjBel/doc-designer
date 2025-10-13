function documentsFiltrVision(btn) {
    btn.previousElementSibling.classList.toggle('vision');
    if (btn.innerText == 'Показать все') {
        btn.innerText = 'Скрыть';
    } else {
        btn.innerText = 'Показать все';
    }
}

function documentsFiltr(btn) {
    const btns = document.querySelectorAll('.documents-filtr button');
    const docs = document.querySelectorAll('.documents-list-item');
    btns.forEach((item) => {
        item.classList.remove('btn-soft-success');
        item.classList.add('btn-soft-secondary');
        item.disabled = false;
    });
    btn.classList.add('btn-soft-success');
    btn.disabled = true;

    let docsCount = 0;
    docs.forEach((doc) => {
        doc.style.display = '';
    });


    if (btn.dataset.groupid == 'all') {
        docsCount = docs.length;
    } else {
        docs.forEach((doc) => {
            if (doc.dataset.parentid != btn.dataset.groupid) {
                doc.style.display = 'none';
            } else {
                docsCount++;
            }
        });
    }

    document.querySelector('.documents-count .doc-count').innerText = docsCount;
    document.querySelector('.documents-count .doc-text').innerText = num_word(docsCount, ['документ', 'документа', 'документов']);
}

function docCout() {
    const docCount = document.querySelector('.documents-count .doc-count');
    const docs = document.querySelectorAll('.documents-list-item');
    console.dir(docCount);
    if (!docCount) return;
    docCount.innerText = docs.length;
    document.querySelector('.documents-count .doc-text').innerText = num_word(docs.length, ['документ', 'документа', 'документов']);
}
// docCout();

function num_word(value, words){
    // num_word(value, ['товар', 'товара', 'товаров']);
    value = Math.abs(value) % 100;
    var num = value % 10;
    if(value > 10 && value < 20) return words[2];
    if(num > 1 && num < 5) return words[1];
    if(num == 1) return words[0];
    return words[2];
}
