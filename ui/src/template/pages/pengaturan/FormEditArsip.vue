<template>
    <div>
        <transition enter-active-class="animated fadeInDown" leave-active-class="animated fadeOutUp">
            <div class="box-body" v-if="showFormEditArsip">	
                <form role="form" id="formEditArsip">                
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Nama Arsip</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="detailArsip.nama_arsip" name="nama_arsip" placeholder="Nama Arsip">
                            <sserror :msg="error.namaArsip"></sserror>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Tanggal Arsip</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" placeholder="DD/MM/YYYY" v-model="detailArsip.tgl_arsip" name="tgl_arsip" minlength="10" maxlength="10" />
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                                <sserror :msg="error.tglArsip"></sserror>
                            </div>
                        </div>
                    </div>  
                    <p class="text-yellow">
                        <i>Perhatian: Data yang diarsipkan tidak akan dapat diubah dan diakses melalui aplikasi lagi.<br>
                        Anda masih bisa melihat rekapitulasi nilai akhir dan mencetaknya sebagai laporan.</i>
                    </p>        
                    <div class="form-group row m-t-md">
                        <div class="offset-sm-4 col-sm-8 text-right">
                            <a ui-scroll-to="content">
                                <button type="button" class="btn btn-fw success" @click="save({ event: 'update', id: detailArsip.id_arsip })">Simpan</button>
                                <button type="button" class="btn btn-fw info" @click="closeForm('showFormEditArsip')">Tutup</button>
                            </a>
                        </div>
                    </div>
                </form> 
            </div>            
        </transition>
    </div>
</template>
<script>
import Vue from 'vue'
import Vuex from 'vuex'
import { mapState, mapMutations, mapActions } from 'vuex'
import { Pengaturan } from '../../../scripts/store/Pengaturan'

Vue.use(Vuex)

export default {
    name: 'FormEditArsip',
    store: Pengaturan,
    components: {
    },
    data() {
        return {}
    },
    methods: {
        ...mapActions([
            'closeForm', 'save',
        ]),
    },
    computed: mapState([
        'error', 'showFormEditArsip', 'detailArsip',
    ])
}
</script>

