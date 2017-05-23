Vue.component('sserror', {
    props: ['msg'],
    template: '<p class="ss-error">{{ msg }}</p>'
})

var siswa = new Vue({
    el: '#dataSiswa',
    data: {
        daftarSiswa: '',
        detailSiswa: '',
        showDaftarSiswa: false,
        showFormAdd: false,
        showFormEdit: false,
        idSiswa: '',

        // alert
        insertAlert: false, updateAlert: false, deleteAlert: false,
        alertMessage: '',

        // data for pagination
        pageLinks: [], limit: 10, offset: 0,
        prev: 0, next: 0, first: 0,
        last: 0, setStart: 0,
        // error messages
        error: {
            nama: '', nis: '', nisn: '', tmptLahir: '', tglLahir: '',
            pendSblm: '', alamatSiswa: '', namaAyah: '', namaIbu: '',
            alamatOrtu: '', telpOrtu: '', namaWali: '', alamatWali: '', telpWali: ''
        },
    },
    methods: {
        getSiswa(limit, start) {
            if(core.formHasValue("#formTambahSiswa")) {
                sidebar.modal.siswaIsFilled = true;
            } else {
                this.showFormAdd = false;
                this.showAlert = false;
                var obj = siswa,
                offset = start * limit;
                this.prev = start - 1;
                $.ajax({
                    url: `${baseUrl}admin/SiswaController/fetchSiswa/${limit}/${offset}`,
                    type: 'GET',
                    dataType: 'json',
                    success: data => {
                        obj.daftarSiswa = data['dataSiswa'];
                        obj.showDaftarSiswa = true;
                        obj.pagination(data['totalRows']);
                        start === (obj.last -= 1) ? obj.next = start : obj.next = start + 1;
                    }
                })
            }
        },
        insertSiswa(event, id) {
            if(event === 'insert') {
                form = $("#formTambahSiswa");
                dataForm = form.serialize();
                param = event;
            } else {
                form = $("#formEditSiswa");
                dataForm = form.serialize();
                param = `${event}/${id}`;
            }
            var obj = siswa;
            // alert(dataForm + ' ============ ' + param);
            $.ajax({
                url: `${baseUrl}admin/SiswaController/setSiswa/${param}`,
                type: 'POST',
                dataType: 'json',
                data: dataForm,
                success: msg => {
                    if(msg.msg !== 'success') {
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
                        obj.clearMessages();

                        // jika event nya adalah insert data siswa
                        // maka bersihkan form, lalu tampilkan alert dan ambil id_siswa
                        if(event === 'insert') {
                            form.trigger("reset");
                            obj.insertAlert = true;
                            obj.idSiswa = msg['id'][0].id_siswa;

                        // selain itu, jika event nya adalah update data siswa,
                        // maka tampilkan kembali form edit siswa dan tampilkan alert
                        } else {
                            siswa.editSiswa(id);
                            obj.updateAlert = true;
                        }
                    }
                }
            })
        },
        editSiswa(id) {
            if(this.showFormAdd) {
                this.showFormAdd = false;
            }
            this.insertAlert = false;
            this.showForm('showFormEdit');
            $.ajax({
                url: `${baseUrl}admin/SiswaController/editSiswa/${id}`,
                type: 'GET',
                dataType: 'json',
                success: data => {
                    siswa.detailSiswa = data;

                    // berikan timeout 500 mili detik untuk menjalankan fungsi
                    // radio button mana yg harus dicek
                    // karena timeout untuk membuka form adalah 400 mili detik
                    setTimeout(() => {
                        siswa.isChecked();
                        siswa.isSelected('agama_siswa');
                        siswa.isSelected('job_ayah');
                        siswa.isSelected('job_ibu');
                        siswa.isSelected('job_wali');
                    }, 500);

                }
            })
        },
        isChecked() {
            if(this.detailSiswa.j_kelamin_siswa === $("#j_laki").val()) {
                $("#j_laki").prop("checked", true);
            } else {
                $("#j_perempuan").prop("checked", true);
            }
        },
        isSelected(target) {
            $(`#${target} option`).each(function() {
                if(siswa.detailSiswa[target] === $(this).val()) {
                    $(this).attr("selected", "selected");
                }
            })
        },
        pagination(num) {
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
        showForm(form) {
            this.showDaftarSiswa = false;
            setTimeout(() => {
                siswa[form] = true;
                setTimeout(() => {
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
        closeForm(form) {
            core.formHasValue("#formTambahSiswa");
            if(core.formHasValue("#formTambahSiswa")) {
                sidebar.modal.siswaIsFilled = true;
            } else {
                this[form] = false
                this.clearMessages();
                this.insertAlert = false;
                this.updateAlert = false;

                setTimeout(() => {
                    this.getSiswa(this.limit, 0);
                    siswa.showDaftarSiswa = true;
                }, 400);
            }
        },
        clearMessages() {
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
