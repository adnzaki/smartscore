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

var module = new Vue({
    data: {
        activeModule: 'beranda',
        toOpen: ''
    },
    methods: {
        beranda() {
            if(this.activeModule !== 'beranda') {
                if (this.close() !== false) {
                    this.toOpen = 'beranda'
                    this.activeModule = 'beranda'
                    beranda.getDashboard()
                }
            }
        },
        siswa() {
            this.toOpen = 'siswa'
            this.close()
            this.activeModule = 'siswa'
            siswa.getSiswa(paging.limit, 0, '')
        },
        rombel() {
            if(this.close() !== false) {
                this.toOpen = 'rombel'
                this.close()
                this.activeModule = 'rombel'
                rombel.getRombel(paging.limit, 0)
            }
        },
        open(moduleName) {
            this.toOpen = moduleName
            switch (moduleName) {
                case 'beranda': this.beranda(); break
                case 'siswa':
                    paging.reset()
                    this.siswa()
                    break
                case 'rombel':
                    paging.reset()
                    this.rombel()
                    break
                default: 'Module name has not been initialized'
            }
        },
        close() {
            switch (this.activeModule) {
                case 'beranda':
                    beranda.showDashboard = false
                    break
                case 'siswa':
                    if(shared.formHasValue("#formTambahSiswa")) {
                        sidebar.modal.siswaIsFilled = true
                        return false
                    } else {
                        siswa.showDaftarSiswa = false
                        siswa.showFormAdd = false
                        siswa.showFormEdit = false
                    }
                    break
                case 'rombel':
                    rombel.showDaftarRombel = false
                    break
                default: 'Module has not been initialized'
            }
        }
    }
})
