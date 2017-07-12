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
 * Smartscore Pagination
 * Sebuah paket library untuk mengolah data pagination
 *
 * @package     Pagination
 * @author      Adnan Zaki
 * @type        Libraries
 */

import Vue from 'vue'
export const paging = {
    data() {
        return {
            pageLinks: [], limit: 10, offset: 0,
            prev: 0, next: 0, first: 0,
            last: 0, setStart: 0, totalRows: 0
        }
    },
    methods: {
        create(num) {
            // reset links
            this.pageLinks = []

            // hitung jumlah halaman yang dibutuhkan untuk link pagination
            let countLink = num / this.limit
            countLink = Math.ceil(countLink)

            // generate link pagination....
            for(let i = 0; i < countLink; i++) {
                this.pageLinks.push(i + 1)
            }
            this.last = countLink
            return this.pageLinks
        },
        dataTo() {
            let currentPage = this.offset / this.limit,
                range
            if(currentPage === this.last) {
                range = this.totalRows
            } else {
                range = this.offset + this.limit
            }

            return range
        },
        dataFrom() {
            let from
            if(this.offset === 0) {
                from = 1
            } else {
                from = this.offset + 1
            }

            return from
        },
        reset() {
            this.pageLinks = []
            this.limit = 10
            this.offset = 0
            this.prev = 0
            this.next = 0
            this.first = 0
            this.last = 0
            this.setStart = 0
            this.totalRows = 0
        }
    }
}
