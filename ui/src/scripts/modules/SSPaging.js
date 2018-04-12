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

/**
 * Smartscore Pagination for Vuex
 * Sebuah paket library untuk mengolah data pagination 
 * Versi ini merupakan pengembangan dari versi standar yang khusus untuk digunakan pada Vuex module
 *
 * @package     Pagination
 * @author      Adnan Zaki
 * @type        Libraries
 */

import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const SSPaging = {
    state: {
        pageLinks: [], limit: 10, offset: 0,
        prev: 0, next: 0, first: 0,
        last: 0, setStart: 0, totalRows: 0,
        numLinks: true, activeClass: '', linkClass: '',
        showPaging: true,
    },
    actions: {
        /**
         * Pagination Generator
         * 
         * @param {*} #state, getters
         * @param {object} settings 
         * 
         * @return void
         */
        create({ state, getters }, settings) {
            state.totalRows = settings.rows
            state.activeClass = settings.activeClass
            state.linkClass = settings.linkClass
            // reset links
            state.pageLinks = []

            // hitung jumlah halaman yang dibutuhkan untuk link pagination
            let countLink = settings.rows / state.limit
            countLink = Math.ceil(countLink)

            // deklarasi nomor awal link
            let startLink

            // cek apakah akan menampilkan nomor link (1, 2, 3 dst.) atau tidak
            if (settings.linkNum === false) {
                state.numLinks = false
            }

            // generate startLink...
            if (settings.linkNum > countLink || settings.linkNum < 1) {
                startLink = 1
            } else {
                if (settings.linkNum % 2 !== 0) {
                    startLink = settings.linkNum - 1
                } else {
                    startLink = settings.linkNum
                }
                startLink = getters.activePage - (startLink / 2)
                if (startLink < 1) {
                    startLink = 1
                }
            }

            // generate link pagination....
            for (let i = startLink; i <= countLink; i++) {
                state.pageLinks.push(i)
                if (state.pageLinks.length === settings.linkNum) {
                    break;
                }
            }

            // halaman terakhir sama dengan jumlah link
            state.last = countLink

            // generate link halaman sebelumnya dan selanjutnya
            settings.start === (state.last -= 1) ? state.next = settings.start : state.next = settings.start + 1
            settings.start === state.first ? state.prev = settings.start : state.prev = settings.start - 1
        },
        activeLink: ({ state, getters }, link) => {
            if (link === getters.activePage) {
                return state.activeClass
            } else {
                return ''
            }
        },
    },
    mutations: {
        reset(state) {
            state.pageLinks = []
            state.limit = 10
            state.offset = 0
            state.prev = 0
            state.next = 0
            state.first = 0
            state.last = 0
            state.setStart = 0
            state.totalRows = 0
        },
    },
    getters: {
        getRowsRange: (state, getters) => {
            if (state.pageLinks.length === 0) {
                state.showPaging = false
                return 'Tidak ada data yang ditampilkan'
            } else {
                state.showPaging = true
                return `Menampilkan baris ${getters.getRowsFrom} - ${getters.getRowsTo} dari ${state.totalRows} baris`
            }
        },
        getRowsFrom: state => {
            let from
            if (state.pageLinks.length === 0) {
                from = 0
            } else {
                if (state.offset === 0) {
                    from = 1
                } else {
                    from = state.offset + 1
                }
            }

            return from
        },
        getRowsTo: state => {
            let currentPage = state.offset / state.limit,
                range
            if (state.pageLinks.length === 0) {
                range = 0
            } else {
                if (currentPage === state.last) {
                    range = state.totalRows
                } else {
                    range = state.offset + state.limit
                }
            }

            return range
        },
        activePage: state => {
            return ((state.offset / state.limit) + 1)
        },
    }
}