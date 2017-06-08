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

var shared = new Vue({
    el: '#loader',
    data: {
        showLoader: false
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
    }
})
