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
import { ssconfig } from '../../app.config'

new Vue({
    el: '#loginPage',
    data: {
        msg: '',
        title: 'Silakan login dengan menggunakan akun Smartscore anda',
        username: '', password: '',
        tahunAjaran: [], tahunAjaranValue: '',
        showTahunAjaran: false,
    },
    mounted() {
        $.ajax({
            url: `${ssconfig.apiUrl}AuthController/getTahunAjaran`,
            type: 'get',
            dataType: 'json',
            success: data => {
                this.tahunAjaran = data
                this.tahunAjaranValue = data[0].tahun_ajaran
            }
        })
    },
    methods: {
        login() {
            var data = $("#formLogin").serialize()
            var self = this
            if(this.username === '' || this.password === '') {
                this.msg = 'Silakan masukkan username dan password anda'
            } else {
                $.ajax({
                    url: `${ssconfig.apiUrl}AuthController/validate/`,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: data => {                 
                        if(data.code === 1) {
                            var tgl = new Date(),
                            skrg = tgl.getTime(),
                            expMs = skrg + (ssconfig.cookieExp * 60 * 1000),
                            exp = new Date(expMs)
                            document.cookie = `${ssconfig.cookieName}=${data.cookie};expires=${exp.toUTCString()};path=/;`
                            self.msg = ''
                            self.title = data.msg
                            window.location.href = `${ssconfig.loginUrl}smartscore.html#/${ssconfig.mainPage}`
                        } else {
                            self.msg = data.msg
                        }                   
                    },
                    error() {
                        self.msg = 'Gagal terkoneksi dengan server'
                    }
                })
            }            
        },        
    }
})