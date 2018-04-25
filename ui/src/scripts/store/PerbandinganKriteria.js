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

import Vue from 'vue'
import Vuex from 'vuex'
import { SSPaging as paging } from '../modules/SSPaging'
import { shared } from '../modules/Shared'

Vue.use(Vuex)

export const PerbandinganKriteria = new Vuex.Store({
    modules: {
        paging, shared
    },
    state: {
        kriteria: [], token: '', kriteriaToCompare: [],
        daftarKriteria: [],
        CR: '', konsistensi: '', jumlahKolom: {},
        hasilPerbandingan: [], eigen: [], hasData: false,
        namaKriteria: '', saveProgress: false, 
        alert: { successSave: false, errorSave: false, }
    },
    mutations: {
        showAlert(state, type) {
            state.alert[type] = true
            setTimeout(() => {
                state.alert[type] = false
            }, 4000)
        },
    },
    actions: {
        getDaftarKriteria({ state, commit, dispatch }) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganKriteriaController/getDaftarKriteria/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.daftarKriteria = data
                    }
                })
            }
        },
        getPerbandinganKriteria({ state, commit, dispatch }) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganKriteriaController/getPerbandingan/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.kriteria = data['kriteria']
                        state.jumlahKolom = data['jumlahKolom']
                        if (data['filled'] > 0) {
                            state.hasData = true
                        } else if (data['filled'] === 0) {
                            state.hasData = false
                        }
                    }
                })
            }
        },
        getKriteriaToCompare({ state, commit, dispatch }, kriteriaID) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganKriteriaController/getKriteriaToCompare/${kriteriaID}/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.kriteriaToCompare = data
                    }
                })
            }
        },
        getComparisonResult({ state, commit, dispatch }) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganKriteriaController/getComparisonResult/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.CR = data['CR']
                        state.konsistensi = data['konsistensi']
                        state.hasilPerbandingan = data['hasil']
                    }
                })
            }
        },
        save({ state, commit, dispatch }) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            var form = $('#formPerbandinganKriteria').serialize()
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganKriteriaController/save/${state.token}`,
                    type: 'POST',
                    data: form,
                    dataType: 'json',
                    beforeSend: () => {
                        state.saveProgress = true
                    },
                    success: msg => {
                        state.saveProgress = false
                        if(msg === 'success') {
                            commit('showAlert', 'successSave')
                            dispatch('getPerbandinganKriteria')
                        } else {
                            commit('showAlert', 'errorSave')
                        }
                    }
                })
            }
        },
        getKriteriaName({ state, commit, dispatch }, kriteriaID) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganKriteriaController/getKriteriaName/${kriteriaID}/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    success: data => {
                        state.namaKriteria = data
                    }
                })
            }
        },
    }
})