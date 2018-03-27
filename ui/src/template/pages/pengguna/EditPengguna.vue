<template>
    <div>
        <!-- Error alert -->
        <ssalert :alertClass="'alert-danger'" :target="errorUpdate" :initMsg="'Error!'" :msg="'Data Pengguna tidak dapat disimpan, silakan isi form dengan benar.'"></ssalert>
        
        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
            <div class="padding" v-if="showFormEdit">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="box-header">
                                        <h2>Ubah Data Pengguna</h2>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="box-header">
                                        <button class="btn btn-icon danger" @click="closeForm('showFormEdit')"><i class="fa fa-remove"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="box-divider m-a-0"></div>
                            <div class="box-body">
                                <form role="form" id="formEditPengguna">
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Nama Pengguna</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" v-model="detail.user.nama_pengguna" name="nama_pengguna" minlength="3" placeholder="Nama Pengguna">
                                            <sserror :msg="error.nama"></sserror>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" v-model="detail.user.email" name="email" placeholder="Alamat email">
                                            <sserror :msg="error.email"></sserror>
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
                                            <button type="button" class="btn btn-fw info" @click="closeForm('showFormEdit')">Tutup</button>
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
    name: 'EditPengguna',
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
            this.$store.dispatch('updatePengguna', {
                id: this.detail.user.id_pengguna,
                closeForm: closeForm,
            })
        }
    },
    computed: mapState([
        'errorUpdate', 'showFormEdit', 'error', 'updateAlert',
        'detail',
    ])
}
</script>

