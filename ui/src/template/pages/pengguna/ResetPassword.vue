<template>
    <div>
        <!-- Error alert -->
        <ssalert :alertClass="'alert-danger'" :target="errorReset" :initMsg="'Error!'" :msg="'Gagal mereset password, silakan isi form dengan benar.'"></ssalert>

        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
            <div class="padding" v-if="showFormReset">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="box-header">
                                        <h2>Reset Password</h2>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="box-header">
                                        <button class="btn btn-icon danger" @click="closeForm('showFormReset')"><i class="fa fa-remove"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="box-divider m-a-0"></div>
                            <div class="box-body">
                                <form role="form" id="formResetPassword">
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Password Baru</label>
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
                                            <button type="button" class="btn btn-fw info" @click="closeForm('showFormReset')">Tutup</button>
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
    name: 'ResetPassword',
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
            this.$store.dispatch('resetPassword', {
                id: this.detail.user.id_pengguna,
                closeForm,
            })
        }
    },
    computed: mapState([
        'errorReset', 'showFormReset', 'error', 'detail'
    ])
}
</script>

