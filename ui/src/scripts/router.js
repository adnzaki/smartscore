import Vue from 'vue'
import VueRouter from 'vue-router'
import dashboard from '../template/pages/beranda/dashboard.vue'
import Siswa from '../template/pages/siswa/Siswa.vue'
import Rombel from '../template/pages/rombel/Rombel.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/', component: dashboard },
    { path: '/siswa', component: Siswa },
    { path: '/rombel', component: Rombel }
]

const router = new VueRouter({
    routes
})

export const AppRouter = new Vue({
    router
}).$mount('#app')
