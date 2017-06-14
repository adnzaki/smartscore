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

var sidebar = new Vue({
    el: '#aside',
    data: {
        modal: {
            siswaIsFilled: false
        }
    },
    methods: {
        forceShowDaftarSiswa() {
            $('#formTambahSiswa').trigger("reset");
            setTimeout(() => {
                this.modal.siswaIsFilled = false;
                module.open(module.toOpen)
                siswa.clearMessages();
                siswa.errorInsert = false;
            }, 100);
        }
    }
})
