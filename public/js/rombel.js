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

var rombel = new Vue({
    el: '#dataRombel',
    data: {
        showDaftarRombel: false,
        daftarRombel: '',
    },
    methods: {
        getRombel(limit, start) {
            var self = this
            paging.offset = start * limit
            $.ajax({
                url: `${baseUrl}admin/RombelController/fetchRombel/${limit}/${paging.offset}/`,
                type: 'GET',
                dataType: 'json',
                success: data => {
                    self.daftarRombel = data['rombel']
                    setTimeout(() => {
                        self.showDaftarRombel = true
                    }, 400)

                    paging.totalRows = data['baris']
                    paging.create(data['baris'])

                    // atur nilai default untuk next page
                    start === (paging.last -= 1) ? paging.next = start : paging.next = start + 1

                    // atur nilai default untuk previous page
                    start === paging.first ? paging.prev = start : paging.prev = start - 1
                }
            })
        }
    },
})
