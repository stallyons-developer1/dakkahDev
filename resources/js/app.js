/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import fa from "element-ui/src/locale/lang/fa";

require('./bootstrap');

window.Vue = require('vue').default;
import VueRouter from 'vue-router'
import Multiselect from 'vue-multiselect'
import VueI18n from 'vue-i18n';
import VueConfirmDialog from 'vue-confirm-dialog'
var VueResource = require('vue-resource');
Vue.use(Multiselect)
Vue.use(VueRouter)
Vue.use(VueResource);
Vue.use(VueConfirmDialog)
Vue.use(VueI18n)
import Paginate from 'vuejs-paginate'
import Vue from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import VueUploadMultipleImage from 'vue-upload-multiple-image'
import VueLazyload from 'vue-lazyload'
import VSwatches from 'vue-swatches';
import VueStepWizard from 'vue-step-wizard';
import "vue-step-wizard/dist/vue-step-wizard.css";
import "vue-multiselect/dist/vue-multiselect.min.css";
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import InputTag from 'vue-input-tag'

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

Vue.config.productionTip = false;

// import '../sass/main.scss'
// import 'remixicon/fonts/remixicon.css'

// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Import Bootstrap an BootstrapVue CSS files (order is important)
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
// Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
// Vue.use(IconsPlugin)
Vue.use(VueStepWizard)
// Import the styles too, globally
import "vue-swatches/dist/vue-swatches.css";
Vue.component('v-select', vSelect);
Vue.component('multiselect', Multiselect);
Vue.component('vuejs-datepicker', DatePicker);
Vue.component('input-tag', InputTag)

Vue.component('vue-dropzone', vue2Dropzone);
Vue.use(VueLazyload);
Vue.component('VueUploadMultipleImage', VueUploadMultipleImage);
Vue.component('paginate', Paginate)
Vue.component('VSwatches', VSwatches);
Vue.component('pagination', require('laravel-vue-pagination'));

VueResource.Http.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
});

// // console.log(ar.Home)
// export const i18n = new VueI18n({
//     locale:locale,
//     fallbackLocale:'en',
//     formatFallbackMessages: true,
//     silentFallbackWarn: true,
//     message: {ar}
// });

import Swal from 'sweetalert2';


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Swal = Swal;
window.Toast = Toast;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//admin
Vue.component('admin-menu', require('./elements/admin/Menu.vue').default);
Vue.component('header-content', require('./elements/admin/HeaderContent.vue').default);
Vue.component('search-bar', require('./elements/admin/SearchBar.vue').default);
Vue.component('front-search-bar', require('./elements/front/SearchBar.vue').default);
Vue.component('successfully-message', require('./elements/front/SuccessfullyMessage.vue').default);
Vue.component('no-data', require('./components/NoData.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);


//front
Vue.component('header-bar', require('./elements/front/HeaderBar.vue').default);
Vue.component('footer-bar', require ('./elements/front/FooterBar.vue').default);
Vue.component('banner', require('./elements/front/Banner.vue').default);
Vue.component('courses-list', require('./pages/front/courses/CoursesList.vue').default);
Vue.component('random-courses-list', require('./pages/front/courses/RandomCourses.vue').default);
Vue.component('home-banner', require('./pages/front/HomeBanner.vue').default);
Vue.component('trainers-list', require('./pages/front/trainers/Index.vue').default);
Vue.component('why-us', require('./elements/front/WhyUs.vue').default);
Vue.component('Newsletter', require('./elements/front/Newsletter.vue').default);
Vue.component('course-header', require('./elements/front/CourseHeader.vue').default);
Vue.component('trainer-header', require('./elements/front/TrainerHeader.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



import routes from './routes';
import AppAdmin from "./pages/admin/App";
let config = { headers: { 'Content-Type': 'multipart/form-data' } };
// front end pages //
// import AppFront from "./pages/front/App";
import routes_front from './frontRouter';
import { slider, slideritem } from 'vue-concise-slider'// import slider components
Vue.mixin({
    methods: {
        checkPermission: function (permission) {
            if (permissions.includes(permission) || sdm == 1){
                return true;
            }else{
                return false;
            }
        },
        getValidationMessage:function(validation){
            let message = {};
            for (let value in validation){
                message.push({[value]:validation[value][0]});
            }
            return message;
            // console.log(validation)
        }
    },
});

import ar from'../lang/ar.json';
export const i18n = new VueI18n({
    silentFallbackWarn: true,
    silentTranslationWarn: true,
    locale: locale,
    fallbackLocale: locale,
    messages: {
        ar: ar
    }
})
global.i18n = i18n;
window.current_language = i18n.locale;
Vue.filter('translate', function (value) {
    return i18n.t(value);
});

// export default i18n;


if (window.location.href.includes('/admin/')){
    const router = new VueRouter({
        mode: 'history',
        routes:routes
    });
    const app = new Vue({
        el: '#app',
        i18n,
        router,
        components: {
            AppAdmin
        },
        // render: h => h(App),
        methods: {
            PostRequest(url, data = {}) {
                return VueResource.Http.post(url, data);
            },
            GetRequest(url) {
                return VueResource.Http.get(url);
            }

        },
        mounted(){
            document.getElementById("language-selector").addEventListener('change', function (event)
            {
                locale = event.target.value; 
                localStorage.setItem("localeLang", locale); 
                location.reload(); 
            });

            var mydir = document.documentElement.dir;
            console.log(mydir);

        }
    });
}else{
    const router = new VueRouter({
        mode: 'history',
        routes:routes_front
    });
    const front_app = new Vue({
        el: '#front_app',
        router,
        components: {
            // AppFront,
            'AppFront': require('../js/pages/front/App.vue').default,

        },
        // render: h => h(App),
        methods: {
            PostRequest(url, data = {}) {
                return VueResource.Http.post(url, data);
            },
            GetRequest(url) {
                return VueResource.Http.get(url);
            }

        }
    });

}

