import Vue from 'vue'
import AppRouter from './scripts/router.js'    
import appheader from './template/elements/app-header.vue'
import appfooter from './template/elements/app-footer.vue'
import ssalert from './template/content/alert.vue'

Vue.component('ssalert', ssalert)
Vue.component('sserror', {
    props: ['msg'],
    template: '<p class="ss-error">{{ msg }}</p>'
})

new Vue({
    el: '#app-header',
    render: h => h(appheader)
})

new Vue({
    el: '#app-footer',
    render: h => h(appfooter)
})
