import Vue from 'vue'
import Login from './scripts/login.js'
import AppRouter from './scripts/router.js'
import appheader from './template/elements/app-header.vue'
import appfooter from './template/elements/app-footer.vue'

new Vue({
    el: '#app-header',
    render: h => h(appheader)
})

new Vue({
    el: '#app-footer',
    render: h => h(appfooter)
})
