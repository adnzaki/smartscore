import Vue from 'vue'
import VueRouter from 'vue-router'
import { global } from './global.js'
import { shared } from './shared.js'
import dashboard from '../template/pages/beranda/dashboard.vue'
import Siswa from '../template/pages/siswa/Siswa.vue'
import Rombel from '../template/pages/rombel/Rombel.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/dashboard', component: dashboard },
    { path: '/siswa', component: Siswa },
    { path: '/rombel', component: Rombel }
]

const router = new VueRouter({
    routes
})

export const AppRouter = new Vue({
    mixins: [global, shared],
    router,
    beforeMount() {
        let token = this.getCookie('ss_session')
        if(token === undefined) {
            window.location.href = this.loginUrl
        }
    }
}).$mount('#app')
