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
import { ssconfig } from '../../app.config'
import Dashboard from '../template/pages/beranda/Dashboard.vue'
import Siswa from '../template/pages/siswa/Siswa.vue'
import EditSiswa from '../template/pages/siswa/EditSiswa.vue'
import Rombel from '../template/pages/rombel/Rombel.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/dashboard', component: Dashboard },
    { path: '/siswa', component: Siswa },
    { path: '/siswa/edit/:id', component: EditSiswa },
    { path: '/rombel', component: Rombel }
]

const router = new VueRouter({
    routes,
    linkActiveClass: 'active',
})

export const AppRouter = new Vue({
    router,
    data() {
        return {
            config: ssconfig
        }
    },
}).$mount('#app')
