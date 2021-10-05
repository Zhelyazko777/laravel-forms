import Vue from "vue";
import Form from 'laravel-forms-vue';

window.Vue = require('vue');
window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.use(Form);
const app = new Vue({
    el: '#app',
});
