const preloader = () => {
    window.onload = function() {
        const preload = document.querySelector('#preloader');
        if ( preload ) {
            preload.classList.add("preloader-remove");
        }
    };
}
preloader();

function searchHomeAction() {
    try {
        const start = datepicker('.start', {
            id: 1,
            months: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            customDays: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            startDay: 1,
            formatter: (input, date, instance) => {
                let options = {
                    weekday: "short",
                    year: "numeric",
                    month: "short",
                    day: "numeric"
                };
                const value = date.toLocaleDateString("ru-RU", options)
                input.value = value // => '1/1/2099'
            },
        });
        const end = datepicker('.end', {
            id: 1,
            months: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            customDays: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            startDay: 1,
            formatter: (input, date, instance) => {
                let options = {
                    weekday: "short",
                    year: "numeric",
                    month: "short",
                    day: "numeric"
                };
                const value = date.toLocaleDateString("ru-RU", options)
                input.value = value // => '1/1/2099'
            }
        });

        function searchHome() {
            const searchHomeBtn = document.querySelector('button#search-home-submit');
            if (!searchHomeBtn) return;
            searchHomeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                document.querySelector('select[name="location"]').classList.remove('is-invalid');
                document.querySelector('input[name="dateEnd"]').classList.remove('is-invalid');
                document.querySelector('input[name="dateStart"]').classList.remove('is-invalid');
                let location = document.querySelector('select#location').value;
                let dates = start.getRange();
                let startD = new Date(dates.start);
                let endD = new Date(dates.end);
                let monthSt = startD.getMonth() + 1;
                let monthEn = endD.getMonth() + 1;

                // console.dir(new Intl.DateTimeFormat().format(startD));
                // console.dir(new Intl.DateTimeFormat().format(endD));

                let errCount = 0;

                if (!monthSt && !monthEn) {
                    if (!+location) {
                        document.querySelector('select[name="location"]').classList.add('is-invalid');
                        document.querySelector('input[name="dateEnd"]').classList.add('is-invalid');
                        document.querySelector('input[name="dateStart"]').classList.add('is-invalid');
                        errCount++;
                    }
                } else {
                    if (monthSt && !monthEn) {
                        document.querySelector('input[name="dateEnd"]').classList.add('is-invalid');
                        errCount++;
                    } else if (!monthSt && monthEn) {
                        document.querySelector('input[name="dateStart"]').classList.add('is-invalid');
                        errCount++;
                    }
                }

                if (!errCount) {
                    if (+location) {
                        localStorage.setItem('locations', location);
                    }
                    if (monthSt && monthEn) {
                        let dates = new Intl.DateTimeFormat().format(startD)+'-'+new Intl.DateTimeFormat().format(endD);
                        let monts = [montLang(monthSt, true), montLang(monthEn, true)];
                        localStorage.setItem('dates', dates);
                        localStorage.setItem('monts', monts.join(','));
                    }
                    window.location.href = '/glampings';
                }
            });
        }
        searchHome();
    } catch (err) {

    }
}
searchHomeAction();

function montLang(mont, lc=false) {
    const monthNames = [ " ", "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
        "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
    ];
    const monthNamesLowerCase = [ " ", "январь", "февраль", "март", "апрель", "май", "июнь",
        "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь"
    ];
    if (lc) {
        return monthNamesLowerCase[mont];
    } else {
        return monthNames[mont];
    }
}

const locSearchPage = () => {
    const input = document.querySelector('input#locSearchPage');
    if (!input) return;
    const locOptions = document.querySelector('.loc-page');
    // let locObj = JSON.parse(scriptJson);
    rendOptions(scriptJson, locOptions);

    input.addEventListener('input', (e) => {
        const newItems = scriptJson.filter((item) => {
            return item.title.toLowerCase().includes(e.target.value.toLowerCase())
        })
        rendOptions(newItems, locOptions);
    })
}
locSearchPage();

function rendOptions(obj, wrap) {
    wrap.innerHTML = '';
    obj.forEach((item) => {
        wrap.insertAdjacentHTML(
            'beforeEnd',
            `<li data-id="${item.id}" data-url="${item.slug}">
            <a href="/location/${item.slug}/">${item.title}</a> <sup>${item.count}</sup>
            </li>`
        );
    });
}

// console.dir(scriptJson);
