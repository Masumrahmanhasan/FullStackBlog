
require('./bootstrap');

window.Vue = require('vue');
import store from './store'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import router from './router'
Vue.use(ViewUI);
import common from './common'
Vue.mixin(common);

window.bus = new Vue();


router.beforeEach((to, from, next) => {
    ViewUI.LoadingBar.start();
    next();
});

router.afterEach(route => {
    ViewUI.LoadingBar.finish();
});


Vue.component('mainapp', require('./components/MainApp.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store
});
