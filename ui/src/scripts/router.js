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
import PerbandinganKriteria from '../template/pages/perbandingan-kriteria/PerbandinganKriteria.vue'
import InputPerbandinganKriteria from '../template/pages/perbandingan-kriteria/InputPerbandinganKriteria.vue'
import HasilPerbandinganKriteria from '../template/pages/perbandingan-kriteria/HasilPerbandinganKriteria.vue'
import DaftarAlternatif from '../template/pages/perbandingan-alternatif/DaftarAlternatif.vue'
import PerbandinganAlternatif from '../template/pages/perbandingan-alternatif/PerbandinganAlternatif.vue'
import InputPerbandinganAlternatif from '../template/pages/perbandingan-alternatif/InputPerbandinganAlternatif.vue'
import HasilPerbandinganAlternatif from '../template/pages/perbandingan-alternatif/HasilPerbandinganAlternatif.vue'
import PrioritasSolusi from '../template/pages/perbandingan-alternatif/PrioritasSolusi.vue'
import Pengguna from '../template/pages/pengguna/Pengguna.vue'
import ssalert from '../template/content/alert.vue'

Vue.use(VueRouter)

Vue.component('ssalert', ssalert)

Vue.component('sserror', {
    props: ['msg'],
    template: '<p class="ss-error">{{ msg }}</p>'
})

const routes = [
    { path: '/', component: Dashboard },
    { path: '/dashboard', component: Dashboard },
    { path: '/siswa', component: Siswa },
    { path: '/rombel', component: Rombel },
    { path: '/guru', component: Guru },
    { path: '/kriteria/daftar-kriteria', component: Kriteria },
    { path: '/kriteria/perbandingan', component: PerbandinganKriteria },
    { path: '/kriteria/perbandingan/input/:kriteriaID', component: InputPerbandinganKriteria },
    { path: '/kriteria/perbandingan/hasil', component: HasilPerbandinganKriteria },
    { path: '/alternatif/daftar-siswa', component: DaftarAlternatif },
    { path: '/alternatif/perbandingan', component: PerbandinganAlternatif },
    { path: '/alternatif/perbandingan/input/:kriteriaID/:siswaID', component: InputPerbandinganAlternatif },
    { path: '/alternatif/perbandingan/hasil/:kriteriaID', component: HasilPerbandinganAlternatif },
    { path: '/alternatif/prioritas-solusi', component: PrioritasSolusi },
    { path: '/pengguna', component: Pengguna },
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
