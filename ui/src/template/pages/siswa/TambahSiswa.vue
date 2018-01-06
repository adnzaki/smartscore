<template>
    <div>
        <!-- Success alert -->
        <div class="padding less-m-b">
            <div class="alert alert-success alert-dismissible ss-no-b-r" role="alert" v-if="insertAlert">
                <button type="button" class="close" @click="$store.state.insertAlert = false" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Sukses</strong> Data siswa baru berhasil disimpan.
                <a href="javascript:void(0)" @click="editSiswa(idSiswa)">
                    <b><u>Lihat detail</u></b>
                </a>
            </div>
        </div>

        <!-- Error alert -->
        <ssalert :alertClass="'alert-danger'" :target="errorInsert" :initMsg="'Error!'" :msg="'Data siswa tidak dapat disimpan, silakan isi form dengan benar.'"></ssalert>

        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
            <div class="padding" v-if="showFormAdd">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="box-header">
                                        <h2>Tambah Siswa</h2>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="box-header">
                                        <button class="btn btn-icon danger" @click="closeForm('showFormAdd')"><i class="fa fa-remove"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="box-divider m-a-0"></div>
                            <div class="box-body">
                                <form role="form" id="formTambahSiswa">
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Nama Lengkap</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nama_siswa" placeholder="Nama Lengkap">
                                            <sserror :msg="error.nama"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Nomor Induk Sekolah</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nis" placeholder="Nomor Induk Sekolah" minlength="9" maxlength="9">
                                            <sserror :msg="error.nis"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">NISN</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nisn" placeholder="Nomor Induk Siswa Nasional" minlength="10" maxlength="10">
                                            <sserror :msg="error.nisn"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Jenis Kelamin</label>
                                        <div class="col-sm-10">
                                            <label class="md-check">
                                                <input type="radio" id="j_laki" checked name="j_kelamin_siswa" value="Laki-laki">
                                                <i class="green"></i>Laki-laki
                                            </label>&nbsp &nbsp &nbsp
                                            <label class="md-check">
                                                <input type="radio" id="j_perempuan" name="j_kelamin_siswa" value="Perempuan">
                                                <i class="green"></i>Perempuan
                                            </label>
                                            <sserror :msg="error.jKelaminSiswa"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Tempat Lahir</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="tempat_lahir_siswa" placeholder="Tempat Lahir">
                                            <sserror :msg="error.tmptLahir"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Tanggal Lahir</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <div class='input-group date' id='datetimepicker1'>
                                                    <input type='text' class="form-control" name="tgl_lahir_siswa" minlength="10" maxlength="10" />
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                                <sserror :msg="error.tglLahir"></sserror>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Agama</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <select class="form-control c-select" name="agama_siswa">
                                                    <option class="text-black" value="Islam">Islam</option>
                                                    <option class="text-black" value="Katholik">Katholik</option>
                                                    <option class="text-black" value="Protestan">Kristen Protestan</option>
                                                    <option class="text-black" value="Hindu">Hindu</option>
                                                    <option class="text-black" value="Buddha">Buddha</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Pendidikan Sebelumnya</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="pend_sblm" placeholder="Nama Taman Kanak-kanak (Kosongkan jika tidak ada)">
                                            <sserror :msg="error.pendSblm"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Alamat Siswa</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="alamat_siswa" rows="2"></textarea>
                                            <sserror :msg="error.alamatSiswa"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Nama Ayah</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nama_ayah" placeholder="Nama Ayah">
                                            <sserror :msg="error.namaAyah"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Nama Ibu</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nama_ibu" placeholder="Nama Ibu">
                                            <sserror :msg="error.namaIbu"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Pekerjaan Ayah</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <select class="form-control c-select" name="job_ayah">
                                                    <option class="text-black" value="PNS">PNS</option>
                                                    <option class="text-black" value="Karyawan Swasta">Karyawan Swasta</option>
                                                    <option class="text-black" value="Wiraswasta">Wiraswasta</option>
                                                    <option class="text-black" value="Buruh">Buruh</option>
                                                    <option class="text-black" value="Tidak Bekerja">Tidak Bekerja</option>
                                                    <option class="text-black" value="Lain-lain">Lain-lain</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Pekerjaan Ibu</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <select class="form-control c-select" name="job_ibu">
                                                    <option class="text-black" value="PNS">PNS</option>
                                                    <option class="text-black" value="Karyawan Swasta">Karyawan Swasta</option>
                                                    <option class="text-black" value="Wiraswasta">Wiraswasta</option>
                                                    <option class="text-black" value="Buruh">Buruh</option>
                                                    <option class="text-black" value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                                    <option class="text-black" value="Lain-lain">Lain-lain</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Alamat Orang Tua</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="alamat_ortu" rows="2"></textarea>
                                            <sserror :msg="error.alamatOrtu"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">No. Telp. Orang tua</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="telp_ortu" placeholder="No. Telepon" minlength="11" maxlength="13">
                                            <sserror :msg="error.telpOrtu"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Nama Wali</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nama_wali" placeholder="Nama Wali (Kosongkan jika tidak ada)">
                                            <sserror :msg="error.namaWali"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Alamat Wali</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="alamat_wali" rows="2" placeholder="Alamat Wali (Kosongkan jika tidak ada)"></textarea>
                                            <sserror :msg="error.alamatWali"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Pekerjaan Wali</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <select class="form-control c-select" name="job_wali">
                                                    <option class="text-black" value="PNS">PNS</option>
                                                    <option class="text-black" value="Karyawan Swasta">Karyawan Swasta</option>
                                                    <option class="text-black" value="Wiraswasta">Wiraswasta</option>
                                                    <option class="text-black" value="Buruh">Buruh</option>
                                                    <option class="text-black" value="Tidak Bekerja">Tidak Bekerja</option>
                                                    <option class="text-black" value="Lain-lain">Lain-lain</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">No. Telp. Wali</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="telp_wali" placeholder="No. Telepon Wali (Kosongkan jika tidak ada)" minlength="12" maxlength="15">
                                            <sserror :msg="error.telpWali"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Rombel</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <select class="form-control c-select" name="id_rombel">
                                                    <option class="text-black" v-for="item in rombel" :value="item.id_rombel">{{ item.nama_rombel }}</option>
                                                </select>
                                                <sserror :msg="error.rombel"></sserror>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row m-t-md">
                                        <div class="offset-sm-8 col-sm-4 text-right">
                                            <a ui-scroll-to="content">
                                                <button type="button" class="btn btn-fw success" @click="save">Simpan</button>
                                            </a>
                                            <button type="button" class="btn btn-fw info" @click="closeForm('showFormAdd')">Tutup</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
<script src="../../../scripts/siswa.js"></script>
<script>
import Vue from 'vue'
import Vuex from 'vuex'
import { mapState, mapMutations, mapActions } from 'vuex'
import { Siswa } from '../../../scripts/store/Siswa'
import ssalert from '../../../template/content/alert.vue'
import { sserror } from '../../../scripts/modules/Shared'

Vue.use(Vuex)

export default {
    name: 'TambahSiswa',
    store: Siswa,
    components: {
        ssalert,
        sserror
    },
    data() {
        return {}
    },
    methods: {
        ...mapActions([
            'closeForm', 'editSiswa'
        ]),
        save() {
            this.$store.dispatch('insertSiswa', {
                event: 'insert',
                id: 'null'
            })
        }
    },
    computed: mapState([
        'insertAlert', 'errorInsert', 'showFormAdd',
        'error', 'idSiswa', 'rombel'
    ])
}
</script>

