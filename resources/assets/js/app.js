/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// Vue.component('example', require('./components/Example.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

const zeroPlus = x => x < 10 ? '0' + x : x;
const dateFotmatInput = date =>
    `${date.getFullYear()}-${zeroPlus(date.getMonth() + 1)}-${zeroPlus(date.getDate())}T${zeroPlus(date.getHours())}:00`;

window.addEventListener('load', () => {
    let form = document.getElementById('operationForm');
    let date1 = document.getElementById('date1');
    let dateNow = document.getElementById('dateNow');

    const testInput = (changeVal = false) => {
        let now = new Date();
        now.setHours(now.getHours() + 1);
        date1.min = dateFotmatInput(now);
        if (changeVal) {
            date1.value = dateFotmatInput(now);
        }
    };

    if (date1) {
        testInput(true);
        setInterval(testInput, 60000);
    }

    if (form) {
        form.addEventListener('submit', () => {
            dateNow.value = dateFotmatInput(new Date());
        });
    }


    let serveDateDiv = document.getElementById('serveDate');
    let serveDate = new Date(serveDateDiv.textContent);
    serveDate.setSeconds(0);
    let nowDate = new Date();
    nowDate.setSeconds(0);
    let diffMinutesDateServer = Math.round((nowDate - serveDate) / 60000);
    const formatDateTable = (selectorArr) => {
        selectorArr.forEach((elSelector) => {
            let parents = document.querySelectorAll(elSelector.selectorParent) || [];
            parents.forEach((elParent) => {
                let tables = elParent.querySelectorAll(elSelector.selectorTable) || [];
                tables.forEach((elTable) => {
                    let dates = elTable.querySelectorAll(elSelector.selectorFieldDate) || [];
                    dates.forEach((date) => {
                        let elDate = new Date(date.textContent);
                        elDate.setMinutes(elDate.getMinutes() + diffMinutesDateServer);
                        date.textContent = elDate.toLocaleString();
                    });
                });
                let help_text = elParent.querySelectorAll(elSelector.help_text) || [];
                help_text.forEach((elHT) => {
                    elHT.textContent = 'Время операции указанно в вашем часовом поясе';
                })
            });
        });
    };

    formatDateTable([{
        'selectorParent': '.parent_defferred_operations',
        'selectorTable': '.table_defferred_operations',
        'selectorFieldDate': '.operation_datetime',
        'help_text': '.help_text',
    }]);
});
