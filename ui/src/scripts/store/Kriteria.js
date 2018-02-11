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
        token: '', newID: '', detailKriteria: null,
        deleteConfirm: false, allSelected: false,
        // alert
        alert: {
            insert: false, update: false, delete: false,
            errorInsert: false, errorUpdate: false, unableToDelete: false,
        },  
        error: {
            namaKriteria: '',
        },
        showFormAdd: false, showFormEdit: false,
    },
    mutations: {
        selectAll(state) {
            $.ajax({
                url: `${state.shared.apiUrl}admin/KriteriaController/getAllKriteriaID/${state.token}`,
                type: 'get',
                dataType: 'json',
                success: data => {
                    state.selectedID = []
                    if (state.allSelected) {
                        state.selectedID = data
                    }
                }
            })
        },        
        showForm(state, form) {            
            setTimeout(() => {
                state[form] = true
                if (form === 'showFormAdd') {
                    $.ajax({
                        url: `${state.shared.apiUrl}admin/KriteriaController/getLastID/${state.token}`,
                        type: 'get',
                        dataType: 'json',
                        success: data => {
                            state.newID = data
                        }
                    })
                }
            }, 400)
        },
        showDeleteConfirm(state, id) {
            state.selectedID = []
            state.alert.unableToDelete = false
            state.selectedID.push(id)
            state.deleteConfirm = true
        },
        closeDeleteConfirm(state) {
            state.selectedID = []
            state.deleteConfirm = false
            state.allSelected = false
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
                            dispatch('closeForm', 'showFormEdit')
                            commit('showAlert', 'update')
                            state.alert.errorUpdate = false
                        }
                    }
                }
            })
        },
        editKriteria({ state, commit }, id) {
            $.ajax({
                url: `${state.shared.apiUrl}admin/KriteriaController/editKriteria/${id}/${state.token}`,
                type: 'GET',
                crossDomain: true,
                dataType: 'json',
                success: data => {
                    state.detailKriteria = data
                    commit('showForm', 'showFormEdit')
                }
            })
        },
        deleteKriteria({ state, commit, dispatch }) {
            var idString = state.selectedID.join("-")
            $.ajax({
                url: `${state.shared.apiUrl}admin/KriteriaController/deleteKriteria/${idString}/${state.token}`,
                type: 'POST',
                success: () => {
                    state.deleteConfirm = false
                    state.selectedID = []

                    // lakukan pengecekan total baris dalam satu halaman tabel kriteria
                    // jika data hanya satu baris, maka offset akan diatur ke halaman sebelumnya
                    // contoh: jika total data pada hal. 3 hanya 1 baris, maka offset akan diatur ke hal. 2
                    let diff = state.paging.totalRows - state.paging.offset
                    if (diff === 1 && state.paging.offset > 0) {
                        state.paging.offset -= state.paging.limit
                    }

                    dispatch('runGetKriteria')
                    commit('showAlert', 'delete')

                    if (state.allSelected) {
                        state.allSelected = false
                    }
                }
            })
        },
        multipleDeleteKriteria({ state, commit }) {
            if (state.selectedID.length < 1) {
                commit('showAlert', 'unableToDelete')
            } else {
                state.alert.unableToDelete = false
                state.deleteConfirm = true
            }
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