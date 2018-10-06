
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

require('bootstrap-table');
require('bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.js');
require('bootstrap-table/dist/extensions/natural-sorting/bootstrap-table-natural-sorting');

require('bootstrap-select');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


let store = {
    score : 0
};

Vue.component('score', {
    data: () => store,
    template: '<input v-model="score" type="number">',
    props: ['type']
});
Vue.component('score-increment', {
    data: () => store,
    template: '<button v-on:click="score = Number(score) + Number(increment)"> + {{ increment }} </button>',
    props: ['increment']
});

const app = new Vue({
    el: '#app'
});

let timer = 0;

window.startTimer = (up = true, start = null, setAmount = true) => {
    let running = timer != 0;

    button = document.getElementsByName('startStop')[0];
    button.innerHTML = running ? 'Start' : 'Stop';

    let increment = up ? 1 : -1;
    if (running) {
        window.clearInterval(timer);
        timer = 0;
        if (! up) {
            setTimer(start);
        }
    }
    else {
        let tick = 0;
        if (start) {
            tick = start;
            setTimer(start);
        }
        timer = window.setInterval(() => {
            tick = tick + increment;

            setTimer(tick);
            if (setAmount) {
                document.getElementById('amount').value = tick;
            }

            if (tick < 0) {
                window.clearInterval(timer);
                timer = 0;
                if (!up) {
                    setTimer(start);
                    button.innerHTML = 'Start';
                }
            }
        }, 1000);
    }
};

setTimer = (totalSeconds) => {
    
    seconds = totalSeconds % 60;
    minutes = Math.floor(totalSeconds / 60);

    document.getElementById('amountAsTime').value = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
};

