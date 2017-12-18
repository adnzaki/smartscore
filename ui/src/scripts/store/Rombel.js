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
        idRombel: '', showFormAdd: false,
        daftarGuru: [], selectedRombel: [],
        detailRombel: '',
        showFormEdit: false, selectedID: [],
        deleteConfirm: false,
        jmlBaris: 10, smtGenap: false,
        salinConfirm: false, salinProgress: false,
        progressText: '', localLimit: 10,
        deleteConfirm: false, allSelected: false,

        // alert
        alert: {
            insert: false, update: false, delete: false,
            errorInsert: false, errorUpdate: false, unableToDelete: false,
        },        

        // error messages
        error: {
            namaRombel: '', tingkat: '', guru: '',
        },
    },
    mutations: {
        showDeleteConfirm(state, id) {
            state.selectedRombel = []
            state.alert.unableToDelete = false
            state.selectedRombel.push(id)
            state.deleteConfirm = true
        },
        closeDeleteConfirm(state) {
            state.selectedRombel = []
            state.deleteConfirm = false
        },  
        selectAll(state) {
            $.ajax({
                url: `${state.shared.apiUrl}admin/RombelController/getAllRombelID`,
                type: 'get',
                dataType: 'json',
                success: data => {
                    state.selectedRombel = []
                    if (state.allSelected) {
                        state.selectedRombel = data
                    }
                }
            })
        },
        showForm(state, form) {
            state.showDaftarRombel = false
            setTimeout(() => {
                state[form] = true
                $.ajax({
                    url: `${state.shared.apiUrl}admin/RombelController/getGuru`,
                    type: 'get',
                    dataType: 'json',
                    success: data => {
                        state.daftarGuru = data
                    }
                })
            }, 400)
        },
        showAlert(state, type) {
            state.alert[type] = true
            setTimeout(() => {
                state.alert[type] = false
            }, 3500)
        },
        clearMessages(state) {
            state.error.namaRombel = ''
            state.error.tingkat = ''
            state.error.guru = ''
        },
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
        save({ state, commit, dispatch }, payload) {
            if (payload.event === 'insert') {
                var form = $("#formTambahRombel"),
                    param = payload.event
            } else {
                var form = $("#formEditRombel"),
                    param = `${payload.event}/${payload.id}`
            }            
            var dataForm = form.serialize()
            $.ajax({
                url: `${state.shared.apiUrl}admin/RombelController/save/${param}`,
                type: 'POST',
                dataType: 'json',
                data: dataForm,
                success: msg => {
                    if (msg !== 'success') {
                        if (payload.event === 'insert') {
                            state.alert.insert = false
                            commit('showAlert', 'errorInsert')
                        } else {
                            state.alert.update = false
                            commit('showAlert', 'errorUpdate')
                        }
                        state.error.namaRombel = msg.nama_rombel
                        state.error.tingkat = msg.tingkat
                        state.error.guru = msg.wali_kelas                  
                    } else {
                        // jika event nya adalah insert data rombel
                        // maka bersihkan form, lalu tampilkan alert dan ambil id_siswa
                        if (payload.event === 'insert') {
                            form.trigger("reset")
                            state.alert.errorInsert = false
                            if(payload.closeForm) {
                                dispatch('closeForm', 'showFormAdd')
                            }
                            commit('showAlert', 'insert')

                            // selain itu, jika event nya adalah update data siswa,
                            // maka tampilkan kembali form edit siswa dan tampilkan alert
                        } else {
                            if (payload.closeForm) {
                                dispatch('closeForm', 'showFormEdit')
                            }
                            commit('showAlert', 'update')
                            state.alert.errorUpdate = false
                        }
                    }
                }
            })
        },
        editRombel({ state, commit }, id) {
            $.ajax({
                url: `${state.shared.apiUrl}admin/RombelController/getDetailRombel/${id}`,
                type: 'GET',
                crossDomain: true,
                dataType: 'json',
                success: data => {
                    state.detailRombel = data[0]
                    commit('showForm', 'showFormEdit')
                }
            })
        },
        deleteRombel({ state, commit, dispatch }) {
            var idString = state.selectedRombel.join("-")
            $.ajax({
                url: `${state.shared.apiUrl}admin/RombelController/deleteRombel/${idString}`,
                type: 'POST',
                success: () => {
                    state.deleteConfirm = false
                    state.selectedRombel = []

                    // lakukan pengecekan total baris dalam satu halaman tabel siswa
                    // jika data hanya satu baris, maka offset akan diatur ke halaman sebelumnya
                    // contoh: jika total data pada hal. 3 hanya 1 baris, maka offset akan diatur ke hal. 2
                    let diff = state.paging.totalRows - state.paging.offset
                    if (diff === 1) {
                        state.paging.offset -= state.paging.limit
                    }

                    dispatch('runGetRombel')
                    commit('showAlert', 'delete')
                }
            })
        },
        multipleDeleteRombel({ state, commit }) {
            if (state.selectedRombel.length < 1) {
                commit('showAlert', 'unableToDelete')
            } else {
                state.alert.unableToDelete = false
                state.deleteConfirm = true
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
        closeForm({ state, commit, dispatch }, form) {
            state[form] = false
            commit('clearMessages')
            state.alert.insert = false
            state.alert.update = false
            state.alert.errorInsert = false
            state.alert.errorUpdate = false
            setTimeout(() => {
                dispatch('runGetRombel')
                state.showDaftarRombel = true
            }, 400)
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