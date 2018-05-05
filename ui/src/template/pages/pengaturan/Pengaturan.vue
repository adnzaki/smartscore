<template>
    <div>
        <!-- sukses ganti password -->
        <ssalert :alertClass="'alert-success'" :target="alert.successReset" :initMsg="'Sukses!'" :msg="'Password telah berhasil diubah'"></ssalert>
        <!-- error ubah password -->
	    <ssalert :alertClass="'alert-danger'" :target="alert.errorReset" :initMsg="'Error!'" :msg="error.msg" />
        <!-- sukses simpan arsip -->
        <ssalert :alertClass="'alert-success'" :target="alert.archived" :initMsg="'Sukses!'" :msg="'Data arsip berhasil disimpan'"></ssalert>
        <!-- error tambah arsip -->
	    <ssalert :alertClass="'alert-danger'" :target="alert.errorArchive" :initMsg="'Error!'" :msg="error.msg" />
        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
            <div class="padding">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-header">
                                <h2>Arsip Hasil Keputusan</h2>								
                            </div>     
                            <div class="box-body">
								<div class="row">
									<div class="col-xs-12">
                                        <button class="btn btn-fw white" @click="showForm('showFormArsip')">
                                            <i class="fa fa-archive"></i> &nbsp; Arsipkan Data Saat Ini
                                        </button>
									</div>
								</div>
                            </div>
                            <FormArsip />
                            <FormEditArsip />
                            <div class="box-body">								
                                <div class="row">
                                    <div class="col-sm-3 offset-sm-9 col-xs-12">
										<input type="text" class="form-control" v-model="$store.state.cariArsip" @keyup.enter="getArsip(localLimit, 0, $store.state.cariArsip)" placeholder="Cari arsip (ketik dan enter)">
									</div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped b-t">
                                    <thead>
                                        <tr>										
                                            <th>ID Arsip</th>
                                            <th>Nama Arsip</th>
                                            <th>Titimangsa</th>
                                            <th colspan="3" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in daftarArsip">
                                            <td>{{ item.id_arsip }}</td>
                                            <td>{{ item.nama_arsip }}</td>
                                            <td>{{ item.tgl_arsip }}</td>
                                            <td class="text-center ss-cursor-pointer" @click="getDetailArsip(item.id_arsip)"><i class="material-icons">edit</i></td>
                                            <td class="text-center ss-cursor-pointer" @click="arsipNilai(item.id_arsip)"><i class="material-icons">visibility</i></td>
                                            <td class="text-center ss-cursor-pointer" @click="">
                                                <a :href="$store.state.shared.apiUrl+'cetak-arsip/'+item.id_arsip+'/'+token" target="_blank"><i class="material-icons">print</i></a>
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="8" class="text-center">
                                            <div class="col-sm-6 text-left">
                                                <p> {{ $store.getters.getRowsRange }} </p>
                                            </div>
                                            <div class="col-sm-6 text-center" v-if="$store.state.paging.showPaging">
                                                <ul class="pagination pagination-sm m-a-0">
                                                    <li><a href="javascript:void(0)" @click="getArsip(localLimit, paging('first'), cariArsip)"><i class="material-icons">skip_previous</i></a></li>
                                                    <li><a href="javascript:void(0)" @click="getArsip(localLimit, paging('prev'), cariArsip)"><i class="material-icons">navigate_before</i></a></li>
                                                    <li>
                                                        <div class="col-xs-3">
                                                            <input type="text" class="form-control" v-model="$store.state.paging.setStart" @keyup.enter="getArsip(localLimit, $store.state.paging.setStart - 1, cariArsip)">
                                                        </div>
                                                    </li>
                                                    <li><a href="javascript:void(0)" @click="getArsip(localLimit, paging('next'), cariArsip)"><i class="material-icons">navigate_next</i></a></li>
                                                    <li><a href="javascript:void(0)" @click="getArsip(localLimit, paging('last'), cariArsip)"><i class="material-icons">skip_next</i></a></li>
                                                    <li><a href="javascript:void(0)" @click="getArsip(localLimit, ($store.getters.activePage - 1), cariArsip)"><i class="material-icons">refresh</i></a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>                              
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-header">
                                <h2>Ganti Password</h2>								
                            </div>     
                            <div class="box-body">								
                                <GantiPassword />    
                            </div>
                            <div class="table-responsive">
                            </div>                              
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <!-- Progress saat menyimpan... -->
		<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="modal ss-modal" data-backdrop="true" v-if="loadProgress">
				<div class="modal-dialog">
					<div class="col-sm-8 offset-sm-2">
						<div class="modal-content black lt m-b">
							<div class="modal-header">
								<h5 class="modal-title">Mohon Tunggu</h5>
							</div>
							<div class="modal-body">
								<p>Menyimpan data arsip...</p>
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
import {
	mapState,
	mapMutations,
	mapGetters,
	mapActions
} from 'vuex'

import { Pengaturan } from '../../../scripts/store/Pengaturan'
import GantiPassword from './GantiPassword.vue'
import FormArsip from './FormArsip.vue'
import FormEditArsip from './FormEditArsip.vue'

export default {
    name: 'Pengaturan',
    store: Pengaturan,
    components: {
        GantiPassword,
        FormArsip,
        FormEditArsip,
    },
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getArsip(10, 0, ''))
	},
	beforeRouteUpdate(to, from, next) {
		next()
	},
	beforeRouteLeave(to, from, next) {
		next()
	},
    data() {
        return {}
    },
    methods: {        
        ...mapActions([
            'getDetailArsip'
		]),
		...mapMutations([
			'showForm',
		]),
        getArsip(limit, offset, search) {
            this.$store.dispatch('getArsip', {
                limit,
                offset,
                search
            })
        },
        arsipNilai(idArsip) {
            this.$router.push('/pengaturan/arsip-nilai/' + idArsip)
        },
        paging(param) {
            return this.$store.state.paging[param]
        },
    },
    computed: {
        ...mapState([
            'alert', 'localLimit', 'cariArsip', 'daftarArsip', 'token',
            'loadProgress', 'error',
        ])
    }
}
</script>
