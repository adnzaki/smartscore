var siswa = new Vue({
    el: '#dataSiswa',
    data: {
        daftarSiswa: '',
        showDaftarSiswa: false,
        tglLahir: ''
    },
    methods: {
        getSiswa: function() {
            var _this = siswa;
            $.ajax({
                url: baseUrl + 'SiswaController/fetchSiswa',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    _this.daftarSiswa = data;
                    _this.showDaftarSiswa = true;
                }
            })
        },
    },
})
