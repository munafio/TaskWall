
require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();

Vue.component('task-form', require('./components/TaskForm.vue').default);
Vue.component('tasks', require('./components/Tasks.vue').default);
Vue.component('task-item', require('./components/TaskItem.vue').default);



const app = new Vue({
    el: '#app',
});
