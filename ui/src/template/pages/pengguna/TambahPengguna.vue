<template>
    <div>
        <!-- Error alert -->
        <ssalert :alertClass="'alert-danger'" :target="errorInsert" :initMsg="'Error!'" :msg="'Data Pengguna tidak dapat disimpan, silakan isi form dengan benar.'"></ssalert>

        <!-- Success alert -->
        <ssalert :alertClass="'alert-success'" :target="insertAlert" :initMsg="'Sukses!'" :msg="'Data pengguna baru berhasil disimpan'"></ssalert>

        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
            <div class="padding" v-if="showFormAdd">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="box-header">
                                        <h2>Tambah Pengguna</h2>
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
                                <form role="form" id="formTambahPengguna">
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Nama Pengguna</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nama_pengguna" minlength="3" placeholder="Nama Pengguna">
                                            <sserror :msg="error.nama"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="email" placeholder="Alamat email">
                                            <sserror :msg="error.email"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="username" placeholder="Username" minlength="3">
                                            <sserror :msg="error.username"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password_pengguna" placeholder="Password (minimal 6 karakter)">
                                            <sserror :msg="error.password"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Konfirmasi Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="konfirmasi_password" placeholder="Konfirmasi Password">
                                            <sserror :msg="error.konfirmasiPassword"></sserror>
                                        </div>
                                    </div>

                                    <div class="form-group row m-t-md">
                                        <div class="offset-sm-4 col-sm-8 text-right">
                                            <a ui-scroll-to="content">
                                                <button type="button" class="btn btn-fw success" @click="save(false)">Simpan</button>
                                            </a>
                                            <a>
                                                <button type="button" class="btn btn-fw success" @click="save(true)">Simpan dan Tutup</button>
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
import { Pengguna } from '../../../scripts/store/Pengguna'

Vue.use(Vuex)

export default {
    name: 'TambahPengguna',
    store: Pengguna,
    components: {
    },
    data() {
        return {}
    },
    methods: {
        ...mapActions([
            'closeForm',
        ]),
        save(closeForm) {
            this.$store.dispatch('insertPengguna', closeForm)
        }
    },
    computed: mapState([
        'errorInsert', 'showFormAdd', 'error', 'insertAlert',
    ])
}
</script>

