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

export const shared = {
    data() {
        return {

        }        
    },
    methods: {
        formHasValue(form) {
            var fields = [];
            $(`${form} :input[type='text']`).each(function() {
                fields.push($(this).val());
            });

            var notBlankFields = fields.filter(fields => {
                return fields.length > 0;
            })

            if(notBlankFields.length > 0) {
                return true;
            } else {
                return false;
            }
        },
        getCookie(name) {
            var allToken = document.cookie
            allToken = allToken.split(';')
            for(let i = 0; i < allToken.length; i++) {
                let cookieItem = allToken[i].split('='),
                    key = cookieItem[0].replace(/ /g, '')
                if(key === name) {
                    return cookieItem[1]
                }
            }
        }
    }
}
