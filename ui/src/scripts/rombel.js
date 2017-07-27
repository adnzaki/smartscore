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
import { shared } from './shared.js'

export default {
    name: 'Rombel',
    mixins: [paging, shared],
    data() {
        return {
            showDaftarRombel: false,
            daftarRombel: '',
            jmlBaris: 0, smtGenap: false,
            salinConfirm: false, salinProgress: false,
            progressText: ''
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => vm.getRombel(10, 0))
    },
    beforeRouteUpdate(to, from, next) {
        this.showDaftarRombel = ''
        this.getRombel(10, 0)
        next()
    },
    beforeRouteLeave(to, from, next) {
        this.showDaftarRombel = false
        next()
    },
    methods: {
        getRombel(limit, start) {
            var token = this.getCookie('ss_session')
            if(token === 'undefined') {
                window.location.href = this.loginUrl
            } else {
                var self = this
                this.limit = limit
                this.offset = start * limit
                $.ajax({
                    url: `${this.apiUrl}admin/RombelController/fetchRombel/${limit}/${this.offset}/${token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        self.daftarRombel = data['rombel']
                        let j = data['tahun_ajaran'].charAt(data['tahun_ajaran'].length - 1)
                        j === '1' ? self.smtGenap = true : self.smtGenap = false
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
            }
        },
        showPerPage() {
            this.rombelLimit = parseInt(this.jmlBaris)
            this.getRombel(this.rombelLimit, 0)
        },
        salinRombel() {
            let token = this.getCookie('ss_session')
            this.salinConfirm = false
            this.progressText = 'Menyalin rombel...'
            this.salinProgress = true
            $.ajax({
                url: `${this.apiUrl}admin/RombelController/copyrombel/${token}`,
                type: 'POST',
                dataType: 'json',
                success: data => {
                    if(data.status === 1) {
                        this.progressText = `${data.jml_rombel} rombel berhasil disalin ke semester saat ini`
                        this.getRombel(10, 0)
                    } else {
                        this.progressText = 'Terjadi kesalahan saat menyalin rombel'
                    }
                }
            })
        }
    },
}
