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
import global from './global.js'

Vue.component('sserror', {
    props: ['msg'],
    template: '<p class="ss-error">{{ msg }}</p>'
})

export default {
    name: 'Siswa',
    data() {
        return {
            daftarSiswa: '',
            detailSiswa: '',
            filename: '',
            loadingText: '',
            cariSiswa: '',
            showDaftarSiswa: false,
            showFormAdd: false,
            showFormEdit: false,
            selectedID: [],
            deleteConfirm: false,
            unableToDelete: false,
            importDialog: false,
            importProgress: false,
            greetings: 'Welcome to Siswa Manager',

            // alert
            insertAlert: false, updateAlert: false, deleteAlert: false,
            errorInsert: false, errorUpdate: false, alertMessage: '',

            // pagination data
            dataPage: {
                totalRows: 0, offset: 0, limit: 0, prev: 0,
                next: 0, first: 0, last: 0, start: 0, to: 0, from: 0
            },

            // error messages
            error: {
                nama: '', nis: '', nisn: '', jKelaminSiswa: '', tmptLahir: '', tglLahir: '',
                pendSblm: '', alamatSiswa: '', namaAyah: '', namaIbu: '',
                alamatOrtu: '', telpOrtu: '', namaWali: '', alamatWali: '', telpWali: ''
            },
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => vm.getSiswa(paging.limit, 0, ''))
    },
    beforeRouteUpdate(to, from, next) {
        this.daftarSiswa = ''
        this.getSiswa(paging.limit, 0, '')
        next()
    },
    beforeRouteLeave(to, from, next) {
        this.showDaftarSiswa = false
        next()
    },
    methods: {
        getSiswa(limit, start, search) {
            if(shared.formHasValue("#formTambahSiswa")) {
                sidebar.modal.siswaIsFilled = true
            } else {
                this.showFormAdd = false
                this.showFormEdit = false
                var obj = this
                paging.offset = start * limit
                $.ajax({
                    url: `${global.apiUrl}admin/SiswaController/fetchSiswa/${limit}/${paging.offset}/${search}`,
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
                        paging.totalRows = data['totalRows']

                        // perbarui data pagination
                        paging.create(data['totalRows'])

                        // atur nilai default untuk next page
                        start === (paging.last -= 1) ? paging.next = start : paging.next = start + 1

                        // atur nilai default untuk previous page
                        start === paging.first ? paging.prev = start : paging.prev = start - 1
                        this.createPageData()
                    }
                })
            }
        },
        createPageData() {
            this.dataPage.totalRows = paging.totalRows
            this.dataPage.offset = paging.offset
            this.dataPage.limit = paging.limit
            this.dataPage.prev = paging.prev
            this.dataPage.next = paging.next
            this.dataPage.first = paging.first
            this.dataPage.last = paging.last
            this.dataPage.start = paging.setStart
            this.dataPage.to = paging.dataTo()
            this.dataPage.from = paging.dataFrom()
        },
        showPerPage(limit) {
            paging.limit = limit
            this.getSiswa(paging.limit, 0, this.cariSiswa)
        },
        insertSiswa(event, id) {
            if(event === 'insert') {
                form = $("#formTambahSiswa")
                dataForm = form.serialize()
                param = event
            } else {
                form = $("#formEditSiswa")
                dataForm = form.serialize()
                param = `${event}/${id}`
            }
            var obj = this
            $.ajax({
                url: `${global.apiUrl}admin/SiswaController/setSiswa/${param}`,
                type: 'POST',
                dataType: 'json',
                data: dataForm,
                success: msg => {
                    if(msg.msg !== 'success') {
                        event === 'insert' ? obj.errorInsert = true : obj.errorUpdate = true
                        obj.alertMessage = "Data siswa tidak dapat disimpan, silakan isi form dengan benar."
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
                            obj.alertMessage = "Data siswa baru berhasil disimpan"
                            obj.idSiswa = msg['id'][0].id_siswa

                        // selain itu, jika event nya adalah update data siswa,
                        // maka tampilkan kembali form edit siswa dan tampilkan alert
                        } else {
                            siswa.editSiswa(id)
                            obj.updateAlert = true
                            obj.errorUpdate = false
                            obj.alertMessage = "Data siswa baru berhasil diperbarui"
                        }
                    }
                }
            })
        },
        importSiswa() {
            var form = document.forms.namedItem('imporSiswa'),
                data = new FormData(form),
                req = new XMLHttpRequest()
            req.open("POST", `${global.apiUrl}admin/SiswaController/importSiswa`, true)
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
                    let start = paging.offset / paging.limit
                    this.getSiswa(paging.limit, start, this.cariSiswa)
                }
            }
            req.send(data)
        },
        closeImportDialog() {
            this.filename = ''
            this.importDialog = false
        },
        editSiswa(id) {
            if(this.showFormAdd) {
                this.showFormAdd = false
            }
            this.insertAlert = false
            this.showForm('showFormEdit')
            $.ajax({
                url: `${global.apiUrl}admin/SiswaController/editSiswa/${id}`,
                type: 'GET',
                dataType: 'json',
                success: data => {
                    siswa.detailSiswa = data

                    // berikan timeout 500 mili detik untuk menjalankan fungsi
                    // radio button mana yg harus dicek
                    // karena timeout untuk membuka form adalah 400 mili detik
                    setTimeout(() => {
                        siswa.isChecked()
                        siswa.isSelected('agama_siswa')
                        siswa.isSelected('job_ayah')
                        siswa.isSelected('job_ibu')
                        siswa.isSelected('job_wali')
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
                this.alertMessage = "Silakan pilih siswa yang ingin dihapus"
            } else {
                this.unableToDelete = false
                this.deleteConfirm = true
            }
        },
        deleteSiswa() {
            for(let i = 0; i < this.selectedID.length; i++) {
                $.ajax({
                    url: `${global.apiUrl}admin/SiswaController/deleteSiswa/${this.selectedID[i]}`,
                    type: 'POST',
                })
            }
            this.deleteConfirm = false
            this.selectedID = []

            // lakukan pengecekan total baris dalam satu halaman tabel siswa
            // jika data hanya satu baris, maka offset akan diatur ke halaman sebelumnya
            // contoh: jika total data pada hal. 3 hanya 1 baris, maka offset akan diatur ke hal. 2
            let diff = paging.totalRows - siswa.offset
            if(diff == 1) {
                paging.offset -= paging.limit
            }

            let start = paging.offset / paging.limit
            this.deleteAlert = true
            this.alertMessage = "Data siswa berhasil dihapus"
            this.getSiswa(paging.limit, start, this.cariSiswa)
            setTimeout(() => {
                this.deleteAlert = false
            }, 5000)
        },
        isChecked() {
            if(this.detailSiswa.j_kelamin_siswa === $("#j_laki").val()) {
                $("#j_laki").prop("checked", true)
            } else {
                $("#j_perempuan").prop("checked", true)
            }
        },
        isSelected(target) {
            $(`#${target} option`).each(function() {
                if(siswa.detailSiswa[target] === $(this).val()) {
                    $(this).attr("selected", "selected")
                }
            })
        },
        showForm(form) {
            this.showDaftarSiswa = false
            setTimeout(() => {
                siswa[form] = true
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
            if(shared.formHasValue("#formTambahSiswa")) {
                sidebar.modal.siswaIsFilled = true
            } else {
                this[form] = false
                this.clearMessages()
                this.insertAlert = false
                this.updateAlert = false
                this.errorInsert = false
                this.errorUpdate = false
                let start = paging.offset / paging.limit
                setTimeout(() => {
                    this.getSiswa(paging.limit, start, this.cariSiswa)
                    siswa.showDaftarSiswa = true
                }, 400)
            }
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
    },
}
