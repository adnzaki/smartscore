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
        selectedID: [],
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
                    }
                })
            }
        }
    }
})