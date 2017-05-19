Vue.component('sserror', {
    props: ['msg'],
    template: '<p class="ss-error">{{ msg }}</p>'
})

var siswa = new Vue({
    el: '#dataSiswa',
    data: {
        daftarSiswa: '',
        showDaftarSiswa: false,
        showFormAdd: false,
        // data for pagination
        pageLinks: [], limit: 10, offset: 0,
        prev: 0, next: 0, first: 0,
        last: 0, setStart: 0,
        // error messages
        error: {
            nama: '', nis: '', nisn: '', tmptLahir: '', tglLahir: '',
            pendSblm: '', alamatSiswa: '', namaAyah: '', namaIbu: '',
            alamatOrtu: '', telpOrtu: '', namaWali: '', alamatWali: '', telpWali: ''
        }
    },
    methods: {
        getSiswa: function(limit, start) {
            if(this.showFormAdd) {
                sidebar.modal.siswaIsFilled = true;
            } else {
                this.showFormAdd = false;
                var obj = siswa,
                offset = start * limit;
                this.prev = start - 1;
                $.ajax({
                    url: baseUrl + 'admin/SiswaController/fetchSiswa/' + limit + '/' + offset,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        obj.daftarSiswa = data['dataSiswa'];
                        obj.showDaftarSiswa = true;
                        obj.pagination(data['totalRows']);
                        start === (obj.last -= 1) ? obj.next = start : obj.next = start + 1;
                    }
                })
            }

        },
        insertSiswa: function() {
            var dataForm = $("#formTambahSiswa").serialize();
            var obj = siswa;
            //alert(dataForm);
            $.ajax({
                url: baseUrl + 'admin/SiswaController/setSiswa/insert',
                type: 'POST',
                dataType: 'json',
                data: dataForm,
                success: function(msg) {
                    if(msg !== 'success') {
                        obj.error.nama = msg.nama_siswa;
                        obj.error.nis = msg.nis;
                        obj.error.nisn = msg.nisn;
                        obj.error.tmptLahir = msg.tempat_lahir_siswa;
                        obj.error.tglLahir = msg.tgl_lahir_siswa;
                        obj.error.pendSblm = msg.pend_sblm;
                        obj.error.alamatSiswa = msg.alamat_siswa;
                        obj.error.namaAyah = msg.nama_ayah;
                        obj.error.namaIbu = msg.nama_ibu;
                        obj.error.alamatOrtu = msg.alamat_ortu;
                        obj.error.telpOrtu = msg.telp_ortu;
                        obj.error.namaWali = msg.nama_wali;
                        obj.error.alamatWali = msg.alamat_wali;
                        obj.error.telpWali = msg.telp_wali;
                    }
                    else {
                        obj.showFormAdd = false;
                        obj.getSiswa(obj.limit, 0);
                    }
                }
            })
        },
        pagination: function(num) {
            // reset links
            this.pageLinks = [];

            // hitung jumlah halaman yang dibutuhkan untuk link pagination
            let countLink = num / this.limit;
            countLink = Math.ceil(countLink);

            // generate link pagination....
            for(let i = 0; i < countLink; i++) {
                this.pageLinks.push(i + 1);
            }
            this.last = countLink;
            return this.pageLinks;
        },
        showForm: function() {
            this.showDaftarSiswa = false;
            setTimeout(function() {
                siswa.showFormAdd = true;
                setTimeout(function() {
                    $("#datetimepicker1").datetimepicker({
                        format: 'DD/MM/YYYY',
                        icons: {
                          time: 'fa fa-clock-o',
                          date: 'fa fa-calendar',
                          up: 'fa fa-chevron-up',
                          down: 'fa fa-chevron-down',
                          previous: 'fa fa-chevron-left',
                          next: 'fa fa-chevron-right',
                          today: 'fa fa-screenshot',
                          clear: 'fa fa-trash',
                          close: 'fa fa-remove'
                        }
                    });
                }, 100)
            }, 400);
        },
        closeForm: function() {
            this.showFormAdd = false;
            this.clearMessages();
            setTimeout(function() {
                siswa.showDaftarSiswa = true;
            }, 400);
        },
        clearMessages: function() {
            this.error.nama = '';
            this.error.nis = '';
            this.error.nisn = '';
            this.error.tmptLahir = '';
            this.error.tglLahir = '';
            this.error.pendSblm = '';
            this.error.alamatSiswa = '';
            this.error.namaAyah = '';
            this.error.namaIbu = '';
            this.error.alamatOrtu = '';
            this.error.telpOrtu = '';
            this.error.namaWali = '';
            this.error.alamatWali = '';
            this.error.telpWali = '';
        }
    },
})
