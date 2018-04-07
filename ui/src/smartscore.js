/**
 * Smartscore
 * Sistem Pendukung Keputusan Pemilihan Siswa Terbaik
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License | https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode
 * @author      Adnan Zaki
 * @link        https://wolestech.com
 * @version     1.0.0
 */

import Vue from 'vue'
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
