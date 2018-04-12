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
import { ssconfig } from '../../../app.config'

Vue.use(Vuex)

export const shared = {
    state: {
        apiUrl: ssconfig.apiUrl,
        loginUrl: ssconfig.loginUrl,
        cookieName: '',
    },
    mutations: {
        getCookie(state, name) {
            var allToken = document.cookie
            allToken = allToken.split(';')
            for (let i = 0; i < allToken.length; i++) {
                let cookieItem = allToken[i].split('='),
                    key = cookieItem[0].replace(/ /g, '')
                if (key === name) {
                    state.cookieName = cookieItem[1]
                }
            }
        },
    },
    actions: {
        
    },
}

var loadCookie = (name) => {
    var allToken = document.cookie
    allToken = allToken.split(';')
    for (let i = 0; i < allToken.length; i++) {
        let cookieItem = allToken[i].split('='),
            key = cookieItem[0].replace(/ /g, '')
        if (key === name) {
            return cookieItem[1]
        }
    }
}

export var getToken = loadCookie(ssconfig.cookieName)