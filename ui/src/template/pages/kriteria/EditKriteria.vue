<template>
    <div>       

        <!-- Error alert -->
        <ssalert :alertClass="'alert-danger'" :target="alert.errorUpdate" :initMsg="'Error!'" :msg="'Gagal menyimpan data kriteria, silakan isi form dengan benar.'"></ssalert>
       
        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
	    	<div class="modal ss-modal" data-backdrop="true" v-if="showFormEdit">
	    		<div class="modal-dialog">
	    			<div class="col-sm-8 offset-sm-2">
	    				<div class="modal-content black lt m-b">
	    					<div class="modal-header">
	    						<h5 class="modal-title">Edit Kriteria: {{ detailKriteria.nama_kriteria }}</h5>
	    					</div>
	    					<div class="modal-body">
	    						<form role="form" id="formEditKriteria">
                                    <div class="form-group row">
                                        <label class="col-sm-12 form-control-label">ID Kriteria</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" disabled :placeholder="detailKriteria.id_kriteria">
                                        </div>
                                    </div>  
                                    <div class="form-group row">
                                        <label class="col-sm-12 form-control-label">Nama Kriteria</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="nama_kriteria" placeholder="Nama Kriteria" v-model="detailKriteria.nama_kriteria">
                                            <sserror :msg="error.namaKriteria"></sserror>
                                        </div>
                                    </div>                                  
                                </form>
	    					</div>
	    					<div class="modal-footer">
	    						<button class="btn white" @click="closeForm('showFormEdit')">Cancel</button>
	    						<button type="button" class="btn btn-fw success" @click="save({ event: 'update', id: detailKriteria.id_kriteria })">Simpan</button>
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
import { Kriteria } from '../../../scripts/store/Kriteria'
import ssalert from '../../../template/content/alert.vue'
import { sserror } from '../../../scripts/modules/Shared'

Vue.use(Vuex)

export default {
    name: 'EditKriteria',
    store: Kriteria,
    components: {
        ssalert,
        sserror
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
        'alert', 'showFormEdit', 'error',
        'detailKriteria',
    ])
}
</script>

