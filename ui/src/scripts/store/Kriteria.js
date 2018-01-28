import Vue from 'vue'
import Vuex from 'vuex'
import { SSPaging as paging } from '../modules/SSPaging'
import { shared } from '../modules/Shared'

Vue.use(Vuex)

export const Kriteria = new Vuex.Store({
    modules: {
        paging, shared
    },
    state: {
        kriteria: [], jmlBaris: 10,
        cariKriteria: '', localLimit: 10,
        selectedID: [], showDaftarKriteria: false,
        token: '', newID: '',
        // alert
        alert: {
            insert: false, update: false, delete: false,
            errorInsert: false, errorUpdate: false, unableToDelete: false,
        },  
        error: {
            namaKriteria: '',
        },
        showFormAdd: false,
    },
    mutations: {
        showForm(state, form) {
            setTimeout(() => {
                state[form] = true
                $.ajax({
                    url: `${state.shared.apiUrl}admin/KriteriaController/getLastID/${state.token}`,
                    type: 'get',
                    dataType: 'json',
                    success: data => {
                        state.newID = data + 1
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
            state.error.namaKriteria = ''
        },
    },
    actions: {
        getKriteria({ state, commit, dispatch }, payload) {
            commit('getCookie', 'ss_session')
            state.token = state.shared.cookieName
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                state.paging.limit = payload.limit
                state.paging.offset = payload.offset * payload.limit
                let param = `${payload.limit}/${state.paging.offset}/${state.token}/${payload.search}`
                $.ajax({
                    url: `${state.shared.apiUrl}admin/KriteriaController/getKriteria/${param}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.kriteria = data['kriteria']
                        setTimeout(() => {
                            state.showDaftarKriteria = true
                        }, 400)
                        dispatch('create', {
                            rows: data['rows'],
                            start: payload.offset,
                            linkNum: 4,
                            activeClass: 'az-active',
                            linkClass: 'waves-effect'
                        })
                    }
                })
            }
        },
        save({ state, commit, dispatch }, payload) {
            let form
            if (payload.event === 'insert') {
                form = $("#formTambahKriteria")

            } else {
                form = $("#formEditKriteria")
            }
            let param = `${payload.event}/${payload.id}/${state.token}`
            var dataForm = form.serialize()
            $.ajax({
                url: `${state.shared.apiUrl}admin/KriteriaController/save/${param}`,
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
                        state.error.namaKriteria = msg.nama_kriteria
                    } else {
                        // jika event nya adalah insert data rombel
                        // maka bersihkan form, lalu tampilkan alert dan ambil id_siswa
                        if (payload.event === 'insert') {
                            form.trigger("reset")
                            state.alert.errorInsert = false
                            dispatch('closeForm', 'showFormAdd')
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
        showPerPage({ state, dispatch }) {
            state.localLimit = parseInt(state.jmlBaris)
            dispatch('getKriteria', {
                limit: state.localLimit,
                offset: 0,
                search: state.cariKriteria
            })
        },  
        runGetKriteria({ state, dispatch }) {
            let start = state.paging.offset / state.localLimit
            dispatch('getKriteria', {
                limit: state.localLimit,
                offset: start,
                search: state.cariKriteria
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
                dispatch('runGetKriteria')
                state.showDaftarKriteria = true
            }, 400)
        },
    }
})