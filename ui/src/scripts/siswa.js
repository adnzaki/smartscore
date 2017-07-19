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
import { paging } from './paging.js'
import { shared } from './shared.js'
import { global } from './global.js'
import ssalert from '../template/content/alert.vue'
import ssloader from '../template/content/loader.vue'

export default {
    name: 'Siswa',
    mixins: [paging, global, shared, ssloader],
    data() {
        return {
            daftarSiswa: '',
            detailSiswa: '',
            filename: '',
            loadingText: '',
            cariSiswa: '',
            idSiswa: '',
            showDaftarSiswa: false,
            showFormAdd: false,
            showFormEdit: false,
            selectedID: [],
            deleteConfirm: false,
            importDialog: false,
            importProgress: false,
            jmlBaris: 0,

            // alert
            insertAlert: false, updateAlert: false, deleteAlert: false,
            errorInsert: false, errorUpdate: false, unableToDelete: false,

            // error messages
            error: {
                nama: '', nis: '', nisn: '', jKelaminSiswa: '', tmptLahir: '', tglLahir: '',
                pendSblm: '', alamatSiswa: '', namaAyah: '', namaIbu: '',
                alamatOrtu: '', telpOrtu: '', namaWali: '', alamatWali: '', telpWali: ''
            },
        }
    },
    components: {
        sserror: {
            props: ['msg'],
            template: '<p class="ss-error">{{ msg }}</p>'
        },
        ssalert
    },
    beforeRouteEnter(to, from, next) {
        next(vm => vm.getSiswa(25, 0, ''))
    },
    beforeRouteUpdate(to, from, next) {
        this.daftarSiswa = ''
        this.getSiswa(25, 0, '')
        next()
    },
    beforeRouteLeave(to, from, next) {
        this.showDaftarSiswa = false
        next()  
    },
    methods: {
        getSiswa(limit, start, search) {
            var token = this.getCookie('ss_session')
            if(token === undefined) {
                window.location.href = this.loginUrl
            } else {
                this.showFormAdd = false
                this.showFormEdit = false
                var obj = this
                this.limit = limit
                this.offset = start * limit
                $.ajax({
                    url: `${this.apiUrl}admin/SiswaController/fetchSiswa/${limit}/${this.offset}/${token}/${search}`,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'json',
                    success: data => {
                        obj.daftarSiswa = data['dataSiswa']

                        // penggunaan setTimeout() baru akan terasa manfaatnya ketika
                        // nanti tidak ada lagi blank page pada aplikasi
                        setTimeout(() => {
                            obj.showDaftarSiswa = true
                        }, 400)

                        // simpan data total baris
                        this.totalRows = data['totalRows']

                        // perbarui data pagination
                        this.create(data['totalRows'])

                        // atur nilai default untuk next page
                        start === (this.last -= 1) ? this.next = start : this.next = start + 1

                        // atur nilai default untuk previous page
                        start === this.first ? this.prev = start : this.prev = start - 1
                    },
                    error: data => {
                        if(data.code === 0 || data.code === 1) {
                            alert(data.msg)
                        } else {
                            alert('Gagal mengirimkan request ke server')
                        }
                    }
                })
            }            
        },
        showPerPage() {
            this.limit = parseInt(this.jmlBaris)
            this.getSiswa(this.limit, 0, this.cariSiswa)
        },
        insertSiswa(event, id) {
            if(event === 'insert') {
                var form = $("#formTambahSiswa"),
                    param = event
            } else {
                var form = $("#formEditSiswa"),
                    param = `${event}/${id}`
            }
            var obj = this,
                dataForm = form.serialize()
            $.ajax({
                url: `${this.apiUrl}admin/SiswaController/setSiswa/${param}`,
                type: 'POST',
                dataType: 'json',
                data: dataForm,
                success: msg => {
                    if(msg.msg !== 'success') {
                        if(event === 'insert') {
                            obj.insertAlert = false
                            obj.errorInsert = true
                        } else {
                            obj.updateAlert = false
                            obj.errorUpdate = true
                        }
                        obj.error.nama = msg.nama_siswa
                        obj.error.nis = msg.nis
                        obj.error.nisn = msg.nisn
                        obj.error.jKelaminSiswa = msg.j_kelamin_siswa
                        obj.error.tmptLahir = msg.tempat_lahir_siswa
                        obj.error.tglLahir = msg.tgl_lahir_siswa
                        obj.error.pendSblm = msg.pend_sblm
                        obj.error.alamatSiswa = msg.alamat_siswa
                        obj.error.namaAyah = msg.nama_ayah
                        obj.error.namaIbu = msg.nama_ibu
                        obj.error.alamatOrtu = msg.alamat_ortu
                        obj.error.telpOrtu = msg.telp_ortu
                        obj.error.namaWali = msg.nama_wali
                        obj.error.alamatWali = msg.alamat_wali
                        obj.error.telpWali = msg.telp_wali
                    }
                    else {
                        obj.clearMessages()

                        // jika event nya adalah insert data siswa
                        // maka bersihkan form, lalu tampilkan alert dan ambil id_siswa
                        if(event === 'insert') {
                            form.trigger("reset")
                            obj.insertAlert = true
                            obj.errorInsert = false
                            obj.idSiswa = msg['id'][0].id_siswa

                        // selain itu, jika event nya adalah update data siswa,
                        // maka tampilkan kembali form edit siswa dan tampilkan alert
                        } else {
                            obj.editSiswa(id)
                            obj.updateAlert = true
                            obj.errorUpdate = false
                        }
                    }
                }
            })
        },
        importSiswa() {
            var form = document.forms.namedItem('imporSiswa'),
                data = new FormData(form),
                req = new XMLHttpRequest()
            req.open("POST", `${this.apiUrl}admin/SiswaController/importSiswa`, true)
            this.importDialog = false
            this.filename = ''
            this.loadingText = "Mengimpor data..."
            this.importProgress = true
            req.responseType = 'json'
            req.onload = objEvent => {
                if(req.response === 0) {
                    this.loadingText = "Format file yang anda masukkan tidak sesuai"
                } else {
                    this.loadingText = `${req.response.success}, ${req.response.failed}`
                    let start = this.offset / this.limit
                    this.getSiswa(this.limit, start, this.cariSiswa)
                }
            }
            req.send(data)
        },
        getFilename() {
            var file = $("#file").val()
            file = file.split("\\")
            this.filename = file[file.length - 1]
        },
        closeImportDialog() {
            this.filename = ''
            this.importDialog = false
        },
        editSiswa(id) {
            var obj = this
            if(this.showFormAdd) {
                this.showFormAdd = false
            }
            this.insertAlert = false
            $.ajax({
                url: `${this.apiUrl}admin/SiswaController/editSiswa/${id}`,
                type: 'GET',
                crossDomain: true,
                dataType: 'json',
                success: data => {
                    obj.detailSiswa = data
                    this.showForm('showFormEdit')

                    // berikan timeout 500 mili detik untuk menjalankan fungsi
                    // radio button mana yg harus dicek
                    // karena timeout untuk membuka form adalah 400 mili detik
                    setTimeout(() => {
                        obj.isChecked()
                        obj.isSelected('agama_siswa')
                        obj.isSelected('job_ayah')
                        obj.isSelected('job_ibu')
                        obj.isSelected('job_wali')
                    }, 500)
                }
            })
        },
        showDeleteConfirm(id) {
            this.selectedID = []
            this.unableToDelete = false
            this.selectedID.push(id)
            this.deleteConfirm = true
        },
        closeDeleteConfirm() {
            this.selectedID = []
            this.deleteConfirm = false
        },
        multipleDeleteSiswa() {
            if(this.selectedID.length < 1) {
                this.unableToDelete = true
                setTimeout(() => {
                    this.unableToDelete = false
                }, 3000)
            } else {
                this.unableToDelete = false
                this.deleteConfirm = true
            }
        },
        deleteSiswa() {
            var idString = this.selectedID.join("-")
            $.ajax({
                url: `${this.apiUrl}admin/SiswaController/deleteSiswa/${idString}`,
                type: 'POST',
                dataType: 'json',
                success: () => {
                    this.deleteConfirm = false
                    this.selectedID = []

                    // lakukan pengecekan total baris dalam satu halaman tabel siswa
                    // jika data hanya satu baris, maka offset akan diatur ke halaman sebelumnya
                    // contoh: jika total data pada hal. 3 hanya 1 baris, maka offset akan diatur ke hal. 2
                    let diff = this.totalRows - this.offset
                    if(diff == 1) {
                        this.offset -= this.limit
                    }

                    let start = this.offset / this.limit
                    this.getSiswa(this.limit, start, this.cariSiswa)
                    this.deleteAlert = true
                    setTimeout(() => {
                        this.deleteAlert = false
                    }, 5000)
                }
            })
        },
        isChecked() {
            if(this.detailSiswa.j_kelamin_siswa === $("#j_laki").val()) {
                $("#j_laki").prop("checked", true)
            } else {
                $("#j_perempuan").prop("checked", true)
            }
        },
        isSelected(target) {
            var obj = this
            $(`#${target} option`).each(function() {
                if(obj.detailSiswa[target] === $(this).val()) {
                    $(this).attr("selected", "selected")
                }
            })
        },
        showForm(form) {
            this.showDaftarSiswa = false
            setTimeout(() => {
                this[form] = true
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
                    })
                }, 100)
            }, 400)
        },
        closeForm(form) {
            this[form] = false
            this.clearMessages()
            this.insertAlert = false
            this.updateAlert = false
            this.errorInsert = false
            this.errorUpdate = false
            let start = this.offset / this.limit
            setTimeout(() => {
                this.getSiswa(this.limit, start, this.cariSiswa)
                this.showDaftarSiswa = true
            }, 400)
        },
        clearMessages() {
            this.error.nama = ''
            this.error.nis = ''
            this.error.nisn = ''
            this.error.tmptLahir = ''
            this.error.tglLahir = ''
            this.error.pendSblm = ''
            this.error.alamatSiswa = ''
            this.error.namaAyah = ''
            this.error.namaIbu = ''
            this.error.alamatOrtu = ''
            this.error.telpOrtu = ''
            this.error.namaWali = ''
            this.error.alamatWali = ''
            this.error.telpWali = ''
        }
    }
}
