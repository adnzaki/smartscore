import Vue from 'vue'
import Vuex from 'vuex'
import { SSPaging as paging } from '../modules/SSPaging'
import { shared } from '../modules/Shared'

Vue.use(Vuex)

export const PerbandinganAlternatif = new Vuex.Store({
    modules: {
        paging, shared
    },
    state: {
        daftarAlternatif: [], alternatifToCompare: [],
        alternatif: [], token: '', kriteria: [],
        CR: '', konsistensi: '', jumlahKolom: {},
        hasilPerbandingan: [], eigen: [],
        pilihKriteria: '', namaAlternatif: '', saveProgress: false,
        prioritasSolusi: {}, hasData: null, loadProgress: false,
        alert: { successSave: false, errorSave: false, unableToGetResult: false, }
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
        getAlternatifToCompare({ state, commit, dispatch }, idSiswa) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganAlternatifController/getAlternatifToCompare/${idSiswa}/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.alternatifToCompare = data
                    }
                })
            }
        },
        getAlternatifName({ state, commit, dispatch }, siswaID) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganAlternatifController/getAlternatifName/${siswaID}/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    success: data => {
                        state.namaAlternatif = data
                    }
                })
            }
        },
        getDaftarAlternatif({ state, commit, dispatch }) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganAlternatifController/getDaftarAlternatif/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.daftarAlternatif = data
                    }
                })
            }
        },
        getPerbandinganAlternatif({ state, commit, dispatch }) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganAlternatifController/getAlternatif/${state.pilihKriteria}/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    beforeSend: () => {
                        state.loadProgress = true
                    },
                    success: data => {           
                        state.loadProgress = false             
                        state.alternatif = data['alternatif']
                        state.jumlahKolom = data['jumlahKolom']
                        if(data['filled'] > 0) {
                            state.hasData = true
                        } else if (data['filled'] === 0) {
                            state.hasData = false
                        }
                    }
                })
            }
        },
        getComparisonResult({ state, commit, dispatch }, kriteriaID) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganAlternatifController/getComparisonResult/${kriteriaID}/${state.token}`,
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
        getPrioritasSolusi({ state, commit, dispatch }) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganAlternatifController/prioritasSolusi/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.prioritasSolusi = data
                        localStorage.setItem('siswaTerbaik', data.nilaiTertinggi.siswa)
                        localStorage.setItem('nilaiTerbaik', data.nilaiTertinggi.nilai)
                    }
                })
            }
        },
        save({ state, commit, dispatch }, kriteriaID) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            var form = $('#formPerbandinganAlternatif').serialize()
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganAlternatifController/save/${kriteriaID}/${state.token}`,
                    type: 'POST',
                    data: form,
                    dataType: 'json',
                    beforeSend: () => {
                        state.saveProgress = true
                    },
                    success: msg => {
                        state.saveProgress = false
                        if (msg === 'success') {
                            commit('showAlert', 'successSave')
                            dispatch('getPerbandinganAlternatif')
                        } else {
                            commit('showAlert', 'errorSave')
                        }
                    }
                })
            }
        },
        getKriteria({ state, commit }) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganAlternatifController/getKriteria/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.kriteria = data
                    }
                })
            }
        }
    }
})