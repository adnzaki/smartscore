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
import { paging } from './paging.js'
import global from './global.js'

export default {
    name: 'Rombel',
    mixins: [paging],
    data() {
        return {
            showDaftarRombel: false,
            daftarRombel: '',
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => vm.getRombel(10, 0, ''))
    },
    beforeRouteUpdate(to, from, next) {
        this.showDaftarRombel = ''
        this.getRombel(10, 0, '')
        next()
    },
    beforeRouteLeave(to, from, next) {
        this.showDaftarRombel = false
        next()
    },
    methods: {
        getRombel(limit, start) {
            var self = this
            this.limit = limit
            this.offset = start * limit
            $.ajax({
                url: `${global.apiUrl}admin/RombelController/fetchRombel/${limit}/${this.offset}/`,
                type: 'GET',
                crossDomain: true,
                dataType: 'json',
                success: data => {
                    self.daftarRombel = data['rombel']
                    setTimeout(() => {
                        self.showDaftarRombel = true
                    }, 400)

                    this.totalRows = data['baris']
                    this.create(data['baris'])

                    // atur nilai default untuk next page
                    start === (this.last -= 1) ? this.next = start : this.next = start + 1

                    // atur nilai default untuk previous page
                    start === this.first ? this.prev = start : this.prev = start - 1
                }
            })
        },
        showPerPage(limit) {
            this.rombelLimit = limit
            this.getRombel(this.rombelLimit, 0)
        },
    },
}