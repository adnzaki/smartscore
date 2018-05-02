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

export const Pengaturan = new Vuex.Store({
    modules: {
        paging, shared
    },
    state: {
        token: '', showFormArsip: false, showFormEditArsip: false,
        daftarArsip: [], localLimit: 10, cariArsip: '',
        detailArsip: '', arsipNilai: [], loadProgress: false,
        alert: {
            successReset: false, errorReset: false,
            archived: false, errorArchive: false,
        },
        error: {
            passwordLama: '', passwordBaru: '', konfirmasiPassword: '',
            namaArsip: '', tglArsip: '', msg: '',
        }
    },
    mutations: {
        showForm(state, form) {
            state[form] = true
            setTimeout(() => {
                $("#datetimepicker1").datetimepicker({
                    format: 'DD/MM/YYYY',
                    icons: {
                        time: 'fa fa-clock-o',
                        date: 'fa fa-calendar',
                        up: 'fa fa-chevron-up',
                        down: 'fa fa-chevron-down',
                        previous: 'fa fa-chevron-left',
                        next: 'fa fa-chevron-right',
                        today: 'fa fa-screenshot',
                        clear: 'fa fa-trash',
                        close: 'fa fa-remove'
                    }
                })
            }, 100)
        },
        showAlert(state, type) {
            state.alert[type] = true
            setTimeout(() => {
                state.alert[type] = false
            }, 3500)
        },
        clearError(state) {
            state.error.passwordLama = ''
            state.error.passwordBaru = ''
            state.error.konfirmasiPassword = ''
        },
        clearMessages(state) {
            state.error.konfirmasiPassword = ''
            state.error.namaArsip = ''
            state.error.passwordBaru = ''
            state.error.passwordLama = ''
            state.error.tglArsip = ''
        },
    },
    actions: {
        getArsip({ state, commit, dispatch }, payload) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                state.showFormArsip = false
                state.paging.limit = payload.limit
                state.paging.offset = payload.offset * payload.limit
                let param = `${payload.limit}/${state.paging.offset}/${state.token}/${payload.search}`
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PengaturanController/getArsip/${param}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.daftarArsip = data['response']
                        dispatch('create', {
                            rows: data['rows'],
                            start: payload.offset,
                            linkNum: 4,
                            activeClass: 'az-active',
                            linkClass: 'waves-effect'
                        })
                    },
                })
            }
        },
        getArsipNilai({ state, commit }, id) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PengaturanController/getArsipNilai/${id}/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.arsipNilai = data.data
                        state.detailArsip = data.arsip
                    },
                })
            }
        },
        gantiPassword({ state, commit }) {
            var data = $("#formUbahPassword").serialize()
            $.ajax({
                url: `${state.shared.apiUrl}admin/PengaturanController/setPasswordBaru/${state.token}`,
                type: 'post',
                dataType: 'json',
                data: data,
                success: msg => {
                    if (msg.code === 225) {
                        state.error.passwordLama = msg.msg.passwordLama
                        state.error.passwordBaru = msg.msg.passwordBaru
                        state.error.konfirmasiPassword = msg.msg.konfirmasiPassword
                        state.error.msg = 'Gagal mengubah password, silakan isi form dengan benar'
                        commit('showAlert', 'errorReset')
                    } else if (msg.code === 150) {
                        commit('clearError')
                        state.error.msg = msg.msg
                        commit('showAlert', 'errorReset')
                    } else {
                        commit('clearError')
                        state.error.msg = msg.msg
                        commit('showAlert', 'successReset')
                        $("#formUbahPassword").trigger('reset')
                    }
                }
            })
        },
        save({ state, commit, dispatch }, payload) {
            let form
            if (payload.event === 'insert') {
                form = $("#formTambahArsip")
            } else {
                form = $("#formEditArsip")
            }
            let param = `${payload.event}/${payload.id}/${state.token}`
            var dataForm = form.serialize()
            $.ajax({
                url: `${state.shared.apiUrl}admin/PengaturanController/simpanDataArsip/${param}`,
                type: 'POST',
                dataType: 'json',
                data: dataForm,
                beforeSend: () => {
                    state.loadProgress = true
                },
                success: msg => {
                    state.loadProgress = false
                    if (msg !== 'success') {
                        state.alert.archived = false
                        commit('showAlert', 'errorArchived') 
                        state.error.namaArsip = msg.nama_arsip
                        state.error.tglArsip = msg.tgl_arsip
                    } else {
                        state.alert.errorArchive = false
                        commit('showAlert', 'archived')
                        if (payload.event === 'insert') {
                            form.trigger("reset")
                            dispatch('closeForm', 'showFormArsip')
                        } else {
                            dispatch('closeForm', 'showFormEditArsip')
                        }
                    }
                }
            })
        },
        getDetailArsip({ state, commit }, id) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {                
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PengaturanController/getDetailArsip/${id}/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.detailArsip = data
                        commit('showForm', 'showFormEditArsip')
                    },
                })
            }
        },
        runGetArsip({ state, dispatch }) {
            let start = state.paging.offset / state.localLimit
            dispatch('getArsip', {
                limit: state.localLimit,
                offset: start,
                search: state.cariArsip
            })
        }, 
        closeForm({ state, commit, dispatch }, form) {
            state[form] = false
            commit('clearMessages')
            dispatch('runGetArsip')
        },
    },
})