import Vue from 'vue'
import VueRouter from 'vue-router'
import dashboard from '../template/pages/beranda/dashboard.vue'
import Siswa from '../template/pages/siswa/Siswa.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/dashboard', component: dashboard },
    { path: '/siswa/', component: Siswa }
]

const router = new VueRouter({
    routes
})

export const AppRouter = new Vue({
    router
}).$mount('#app')
