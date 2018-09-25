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
    date.getFullYear() + '-'
    + zeroPlus(date.getMonth() + 1) + '-'
    + zeroPlus(date.getDate()) + 'T'
    + zeroPlus(date.getHours()) + ':'
    + '00:00';

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

    testInput(true);
    setInterval(testInput, 60000);

    form.addEventListener('submit', () => {
        dateNow.value = dateFotmatInput(new Date());
    });
});
