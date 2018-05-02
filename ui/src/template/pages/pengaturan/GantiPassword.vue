<template>
    <div>
        <form role="form" id="formUbahPassword">
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Password Lama</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password-lama" placeholder="Password Lama">
                    <sserror :msg="error.passwordLama"></sserror>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Password Baru</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password-baru" placeholder="Password Baru (minimal 6 karakter)">
                    <sserror :msg="error.passwordBaru"></sserror>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Konfirmasi Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="konfirmasi-password" placeholder="Konfirmasi Password Baru">
                    <sserror :msg="error.konfirmasiPassword"></sserror>
                </div>
            </div>

            <div class="form-group row m-t-md">
                <div class="offset-sm-4 col-sm-8 text-right">
                    <button type="button" class="btn btn-fw success" @click="gantiPassword">Simpan</button>
                </div>
            </div>
        </form>     
    </div>
</template>
<script>
import Vue from 'vue'
import Vuex from 'vuex'
import { mapState, mapMutations, mapActions } from 'vuex'
import { Pengaturan } from '../../../scripts/store/Pengaturan'

Vue.use(Vuex)

export default {
    name: 'GantiPassword',
    store: Pengaturan,
    components: {
    },
    data() {
        return {}
    },
    methods: {
        ...mapActions([
            'gantiPassword'
        ]),
    },
    computed: mapState([
        'error'
    ])
}
</script>

