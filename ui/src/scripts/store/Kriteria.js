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
    },
    mutations: {
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
                    url: `${state.shared.apiUrl}admin/KriteriaController/getPerbandingan/${param}`,
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
        showPerPage({ state, commit, dispatch }) {
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
    }
})