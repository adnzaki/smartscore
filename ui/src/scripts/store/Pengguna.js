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
        showFormAdd: false, showFormEdit: false,
        
        // alert
        insertAlert: false, updateAlert: false, deleteAlert: false, insertAndClose: false,
        errorInsert: false, errorUpdate: false, unableToDelete: false,

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
        showForm() {

        },
        closeImportDialog() {

        },
        selectAll() {

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
        multipleDeletePengguna() {

        },
        deletePengguna() {

        },
        editPengguna() {

        },
        resetPassword() {

        },
        showPerPage() {

        }
    }
})