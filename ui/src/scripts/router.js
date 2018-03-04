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
import Rombel from '../template/pages/rombel/Rombel.vue'
import Guru from '../template/pages/guru/Guru.vue'
import Kriteria from '../template/pages/kriteria/Kriteria.vue'
import Multiselect from 'vue-multiselect'
import ssalert from '../template/content/alert.vue'

Vue.use(VueRouter)

Vue.component('ssalert', ssalert)

Vue.component('sserror', {
    props: ['msg'],
    template: '<p class="ss-error">{{ msg }}</p>'
})

Vue.component('multiselect', Multiselect)

const routes = [
    { path: '/dashboard', component: Dashboard },
    { path: '/siswa', component: Siswa },
    { path: '/rombel', component: Rombel },
    { path: '/guru', component: Guru },
    { path: '/kriteria', component: Kriteria },
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
    }
}).$mount('#app')
