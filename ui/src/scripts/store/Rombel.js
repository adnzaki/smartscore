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
import Vuex from 'vuex'
import { SSPaging as paging } from '../modules/SSPaging'
import { shared } from '../modules/Shared'

Vue.use(Vuex)

export const Rombel = new Vuex.Store({
    modules: {
        paging,
        shared
    },
    state: {
        showDaftarRombel: false,
        daftarRombel: '',
        jmlBaris: 10, smtGenap: false,
        salinConfirm: false, salinProgress: false,
        progressText: '', localLimit: 10
    },
    mutations: {

    },
    actions: {
        /**
         * getRombel(state: string, payload: {limit, start})
         * 
         * @param {object} state 
         * @param {object} payload 
         * 
         */
        getRombel({ state, commit, dispatch }, payload) {
            commit('getCookie', 'ss_session')
            let token = state.shared.cookieName
            if (token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                var self = state
                state.paging.limit = payload.limit
                state.paging.offset = payload.offset * payload.limit
                let param = `${payload.limit}/${state.paging.offset}/${token}`
                $.ajax({
                    url: `${state.shared.apiUrl}admin/RombelController/fetchRombel/${param}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        self.daftarRombel = data['rombel']
                        let j = data['tahun_ajaran'].charAt(data['tahun_ajaran'].length - 1)
                        j === '1' ? self.smtGenap = false : self.smtGenap = true
                        setTimeout(() => {
                            self.showDaftarRombel = true
                        }, 400)

                        dispatch('create', {
                            rows: data['baris'],
                            start: payload.offset,
                            linkNum: 4,
                            activeClass: 'az-active',
                            linkClass: 'waves-effect'
                        })
                    },
                    error: () => {
                        alert('Tidak dapat terkoneksi dengan server')
                    }
                })
            }
        },
        showPerPage({ state, commit, dispatch }) {
            state.localLimit = parseInt(state.jmlBaris)
            dispatch('getRombel', {
                limit: state.localLimit,
                offset: 0,
            })
        },  
        salinRombel({ state, commit, dispatch }) {
            commit('getCookie', 'ss_session')
            let token = state.shared.cookieName
            state.salinConfirm = false
            state.progressText = 'Menyalin rombel...'
            state.salinProgress = true
            $.ajax({
                url: `${state.shared.apiUrl}admin/RombelController/copyRombel/${token}`,
                type: 'POST',
                dataType: 'json',
                success: data => {
                    if (data.status === 1) {
                        state.progressText = `${data.jml_rombel} rombel berhasil disalin ke semester saat ini`
                        dispatch('runGetRombel')
                    } else {
                        state.progressText = 'Terjadi kesalahan saat menyalin rombel'
                    }
                }
            })
        },
        runGetRombel({ state, dispatch }) {
            let start = state.paging.offset / state.localLimit
            dispatch('getRombel', {
                limit: state.localLimit,
                offset: start,
            })
            setTimeout(() => {
                if (state.daftarRombel.length === 0) {
                    start -= 1
                    dispatch('getRombel', {
                        limit: state.paging.limit,
                        offset: start,
                    })
                }
            }, 500)
        },   
    }
})