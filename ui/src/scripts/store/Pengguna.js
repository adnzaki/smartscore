import Vue from 'vue'
import Vuex from 'vuex'
import { SSPaging as paging } from '../modules/SSPaging'
import { shared } from '../modules/Shared'

Vue.use(Vuex)

export const Pengguna = new Vuex.Store({
    modules: {
        paging,
        shared
    },
    state: {
        daftarPengguna: [], detail: {
            user: [], password: [], 
        },
        selectedID: [], localLimit: 10,
        showDaftarPengguna: false, allSelected: false,
        jmlBaris: 10, cariPengguna: '',
        showFormAdd: false, showFormEdit: false, showFormReset: false,
        
        // alert
        insertAlert: false, updateAlert: false, deleteAlert: false, insertAndClose: false,
        errorInsert: false, errorUpdate: false, unableToDelete: false,
        resetAlert: false, errorReset: false,

        // error messages
        error: {
            nama: '', email: '', username: '', password: '', konfirmasiPassword: '',
        },
    },
    mutations: {        
        showDeleteConfirm() {

        },
        closeDeleteConfirm() {

        },
        showForm(state, form) {
            state.showDaftarPengguna = false
            setTimeout(() => {
                state[form] = true
            }, 400)
        },
        closeImportDialog() {

        },
        selectAll() {

        },
        clearMessages(state) {
            state.error.nama = ''
            state.error.email = ''
            state.error.username = ''
            state.error.password = ''
            state.error.konfirmasiPassword = ''
        },
        showAlert(state, alert) {
            state[alert] = true
            setTimeout(() => {
                state[alert] = false
            }, 4000)
        },
    },
    actions: {
        getPengguna({ state, commit, dispatch }, payload) {
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
                    url: `${state.shared.apiUrl}admin/UserController/getUser/${param}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.daftarPengguna = data['data']
                        setTimeout(() => {
                            state.showDaftarPengguna = true
                        }, 400)

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
        insertPengguna({ state, commit, dispatch }, closeForm) {
            let form = $("#formTambahPengguna"),
                dataForm = form.serialize()
            $.ajax({
                url: `${state.shared.apiUrl}admin/UserController/insert/${state.token}`,
                type: 'POST',
                dataType: 'json',
                data: dataForm,
                success: msg => {
                    if (msg !== 'success') {
                        state.insertAndClose = false
                        commit('showAlert', 'errorInsert')
                        state.error.nama = msg.nama_pengguna
                        state.error.email = msg.email
                        state.error.username = msg.username
                        state.error.password = msg.password_pengguna
                        state.error.konfirmasiPassword = msg.konfirmasi_password
                    } else {
                        commit('clearMessages')
                        form.trigger("reset")
                        state.errorInsert = false
                        if (closeForm) {
                            dispatch('closeForm', 'showFormAdd')
                            commit('showAlert', 'insertAndClose')
                        } else {
                            commit('showAlert', 'insertAlert')
                        }
                    }
                }
            })
        },
        updatePengguna({ state, commit, dispatch }, payload) {
            let form = $("#formEditPengguna"),
                dataForm = form.serialize()
            $.ajax({
                url: `${state.shared.apiUrl}admin/UserController/update/${payload.id}/${state.token}`,
                type: 'POST',
                dataType: 'json',
                data: dataForm,
                success: msg => {
                    if (msg !== 'success') {
                        state.updateAlert = false
                        commit('showAlert', 'errorUpdate')
                        state.error.nama = msg.nama_pengguna
                        state.error.email = msg.email
                    } else {
                        commit('clearMessages')
                        state.errorUpdate = false
                        if (payload.closeForm) {
                            dispatch('closeForm', 'showFormEdit')
                        }
                        commit('showAlert', 'updateAlert')
                    }
                }
            })
        },
        resetPassword({ state, commit, dispatch }, payload) {
            let form = $("#formResetPassword"),
                dataForm = form.serialize()
            $.ajax({
                url: `${state.shared.apiUrl}admin/UserController/resetPassword/${payload.id}/${state.token}`,
                type: 'POST',
                dataType: 'json',
                data: dataForm,
                success: msg => {
                    if (msg !== 'success') {
                        state.resetAlert = false
                        commit('showAlert', 'errorReset')
                        state.error.password = msg.password_pengguna
                        state.error.konfirmasiPassword = msg.konfirmasi_password
                    } else {
                        commit('clearMessages')
                        state.errorReset = false
                        if (payload.closeForm) {
                            dispatch('closeForm', 'showFormReset')
                        }
                        commit('showAlert', 'resetAlert')
                    }
                }
            })
        },
        multipleDeletePengguna() {

        },
        deletePengguna() {

        },
        editPengguna({ state, commit }, payload) {
            $.ajax({
                url: `${state.shared.apiUrl}admin/UserController/editPengguna/${payload.id}/${state.token}`,
                type: 'GET',
                crossDomain: true,
                dataType: 'json',
                success: data => {
                    state.detail.user = data[0]
                    if(payload.type === 'edit') {
                        commit('showForm', 'showFormEdit')            
                    } else {
                        commit('showForm', 'showFormReset')
                    }
                }
            })
        },
        closeForm({ state, commit, dispatch }, form) {
            state[form] = false
            commit('clearMessages')
            state.insertAndClose = false
            state.update = false
            state.errorInsert = false
            state.errorUpdate = false
            setTimeout(() => {
                dispatch('runGetPengguna')
                state.showDaftarPengguna = true
            }, 400)
        },
        runGetPengguna({ state, dispatch }) {
            let start = state.paging.offset / state.localLimit
            dispatch('getPengguna', {
                limit: state.localLimit,
                offset: start,
                search: state.cariPengguna
            })
        },  
        showPerPage({ state, commit, dispatch }) {
            state.localLimit = parseInt(state.jmlBaris)
            dispatch('getPengguna', {
                limit: state.localLimit,
                offset: 0,
                search: state.cariPengguna
            })
        },  
    }
})