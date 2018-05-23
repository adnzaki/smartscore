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
import { shared } from '../modules/Shared'

Vue.use(Vuex)

export const Dashboard = new Vuex.Store({
    modules: {
        shared
    },
    state: {
        ringkasan: '', token: '', tigaBesar: [],
    },
    actions: {
        getData({ state, commit, dispatch }) {
            commit('getCookie', 'ss_session')
            let token = state.shared.cookieName
            state.token = token
            if (token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/DashboardController/getData/${token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.ringkasan = data
                        if(data.cekAlternatif === '0')  {
                            localStorage.setItem('siswaTerbaik', 'Tidak ada data')
                            localStorage.setItem('nilaiTerbaik', 0)
                        }
                        dispatch('getTigaBesar')
                    }
                })
            }
        },
        getTigaBesar({ state, commit }) {
            if (state.token === '') {
                window.location.href = `${state.shared.apiUrl}AuthController/logout/`
            } else {
                $.ajax({
                    url: `${state.shared.apiUrl}admin/PerbandinganAlternatifController/getTigaBesar/${state.token}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        state.tigaBesar = data
                    }
                })
            }
        }
    }
})