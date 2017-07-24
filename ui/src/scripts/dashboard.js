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

import Vue from 'vue'
import { shared } from './shared.js'
import { global } from './global.js'

export default {
    name: 'dashboard',
    mixins: [shared, global],
    data() {
        return {
            pesan: 'testtt',
            urlToken: '',
        }        
    },
    beforeRouteEnter(to, from, next) {
        next(vm => vm.hello())
    },
    beforeRouteUpdate(to, from, next) {
        this.hello()
        next()
    },
    beforeRouteLeave(to, from, next) {
        next()
    },
    methods: {
        hello() {
            let token = this.getCookie('ss_session')
            if(token === 'undefined') {
                window.location.href = `${this.apiUrl}authcontroller/logout/`
            } else {
                this.pesan = 'Selamat Datang'
            }            
        }
    }
}
