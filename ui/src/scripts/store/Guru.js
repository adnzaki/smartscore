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

export const Guru = new Vuex.Store({
    modules: {
        paging,
        shared
    },
    state: {
        daftarGuru: [], showDaftarGuru: false, cariGuru: '',
        showFormAdd: false, showFormEdit: false, localLimit: 10,
        selectedID: [], jmlBaris: 10,
        token: '',
    },
    mutations: {

    },
    actions: {
        getGuru({ state, commit, dispatch }, payload) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                state.showFormAdd = false
                state.showFormEdit = false
                state.paging.limit = payload.limit
                state.paging.offset = payload.offset * payload.limit
                let param = `${payload.limit}/${state.paging.offset}/${state.token}/${payload.search}`
                $.ajax({
                    url: `${state.shared.apiUrl}admin/GuruController/fetchGuru/${param}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.daftarGuru = data['dataGuru']
                        setTimeout(() => {
                            state.showDaftarGuru = true
                        }, 400)

                        dispatch('create', {
                            rows: data['totalRows'],
                            start: payload.offset,
                            linkNum: 4,
                            activeClass: 'az-active',
                            linkClass: 'waves-effect'
                        })
                    }
                })
            }
        },
        showPerPage({ state, commit, dispatch }) {
            state.localLimit = parseInt(state.jmlBaris)
            dispatch('getGuru', {
                limit: state.localLimit,
                offset: 0,
                search: state.cariGuru
            })
        },  
        runGetGuru({ state, dispatch }) {
            let start = state.paging.offset / state.localLimit
            dispatch('getGuru', {
                limit: state.localLimit,
                offset: start,
                search: state.cariGuru
            })
        },
    }
})