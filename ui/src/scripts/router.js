/**
 * Smartscore
 * Aplikasi Pengolahan Nilai Siswa berbasis Kurikulum 2013 untuk tingkat Sekolah Dasar (SD)
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License | https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 * @version     1.0.0
 */

/**
 * Smartscore Router 
 * Routing Interface untuk mengelola client-side routing pada aplikasi Smartscore
 * 
 * @author      Adnan Zaki
 * @package     Router
 * @type        Interface
 */

import Vue from 'vue'
import VueRouter from 'vue-router'
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
    router,
}).$mount('#app')
