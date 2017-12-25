<template>
    <div>       

        <!-- Error alert -->
        <ssalert :alertClass="'alert-danger'" :target="alert.errorInsert" :initMsg="'Error!'" :msg="'Data rombel tidak dapat disimpan, silakan isi form dengan benar.'"></ssalert>

        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
            <div class="padding" v-if="showFormAdd">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="box-header">
                                        <h2>Tambah Rombel</h2>
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
                                <form role="form" id="formTambahRombel">
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Nama Rombel</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" disabled placeholder="Nama Rombel" :value="'Kelas ' + namaRombel.tingkat + namaRombel.paralel">
                                            <input type="hidden" name="nama_rombel" :value="'Kelas ' + namaRombel.tingkat + namaRombel.paralel" />
                                            <sserror :msg="error.namaRombel"></sserror>
                                        </div>
                                    </div>                                    
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Tingkat</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <select class="form-control c-select" v-model="namaRombel.tingkat" name="tingkat">
                                                    <option value="1" class="text-black">1</option>
                                                    <option value="2" class="text-black">2</option>
                                                    <option value="3" class="text-black">3</option>
                                                    <option value="4" class="text-black">4</option>
                                                    <option value="5" class="text-black">5</option>
                                                    <option value="6" class="text-black">6</option>
                                                </select>
                                                <sserror :msg="error.tingkat"></sserror>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Paralel</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <select class="form-control c-select" v-model="namaRombel.paralel" name="paralel">
                                                    <option value="A" class="text-black">A</option>
                                                    <option value="B" class="text-black">B</option>
                                                    <option value="C" class="text-black">C</option>
                                                    <option value="D" class="text-black">D</option>
                                                    <option value="E" class="text-black">E</option>
                                                    <option value="F" class="text-black">F</option>
                                                </select>
                                                <sserror :msg="error.paralel"></sserror>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Wali Kelas</label>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <select class="form-control c-select" name="wali_kelas">
                                                    <option class="text-black" v-for="item in daftarGuru" :value="item.id_guru">{{ item.nama_guru }}</option>
                                                </select>
                                                <sserror :msg="error.guru"></sserror>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row m-t-md">
                                        <div class="offset-sm-4 col-sm-8 text-right">
                                            <a ui-scroll-to="content">
                                                <button type="button" class="btn btn-fw success" @click="save({ event: 'insert', closeForm: false })">Simpan</button>
                                            </a>
                                            <a ui-scroll-to="content">
                                                <button type="button" class="btn btn-fw success" @click="save({ event: 'insert', closeForm: true })">Simpan dan Tutup</button>
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
<script>
import Vue from 'vue'
import Vuex from 'vuex'
import { mapState, mapMutations, mapActions } from 'vuex'
import { Rombel } from '../../../scripts/store/Rombel'
import ssalert from '../../../template/content/alert.vue'
import { sserror } from '../../../scripts/modules/Shared'

Vue.use(Vuex)

export default {
    name: 'TambahRombel',
    store: Rombel,
    components: {
        ssalert,
        sserror
    },
    data() {
        return {}
    },
    methods: {
        ...mapActions([
            'closeForm', 'save', //'editSiswa'
        ]),
    },
    computed: mapState([
        'alert', 'showFormAdd', 'error', 'idSiswa',
        'daftarGuru', 'namaRombel',
    ])
}
</script>

