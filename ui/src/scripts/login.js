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
import { shared } from './shared.js'

new Vue({
    el: '#loginPage',
    mixins:[shared],
    data: {
        msg: '',
        title: 'Silakan login dengan menggunakan akun Smartscore anda',
        username: '', password: '',
        tahunAjaran: []
    },
    mounted() {
        var self = this
        $.ajax({
            url: `${this.apiUrl}authcontroller/getTahunAjaran`,
            type: 'get',
            dataType: 'json',
            success: function(data) {
                self.tahunAjaran = data
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
                    url: `${this.apiUrl}authcontroller/validate/`,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: data => {                 
                        if(data.code === 1) {
                            var tgl = new Date(),
                            skrg = tgl.getTime(),
                            expMs = skrg + 3600000,
                            exp = new Date(expMs)
                            document.cookie = `ss_session=${data.cookie};expires=${exp};path=/;`
                            self.msg = ''
                            self.title = data.msg
                            window.location.href = 'http://localhost:8080/smartscore.html#/dashboard'
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