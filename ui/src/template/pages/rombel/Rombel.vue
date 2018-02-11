<template lang="html">
	<div>
		<!-- Delete alert -->
		<ssalert :alertClass="'alert-success'" :target="alert.delete" :initMsg="'Sukses!'" :msg="'Data Rombel berhasil dihapus.'" />

		<!-- Unable to delete -->
		<ssalert :alertClass="'alert-danger'" :target="alert.unableToDelete" :initMsg="'Error!'" :msg="'Silakan pilih rombel yang ingin dihapus.'" />

		<!-- insert success alert -->
        <ssalert :alertClass="'alert-success'" :target="alert.insert" :initMsg="'Sukses!'" :msg="'Data rombel berhasil ditambahkan'"></ssalert>

		<!-- update success alert -->
        <ssalert :alertClass="'alert-success'" :target="alert.update" :initMsg="'Sukses!'" :msg="'Data rombel berhasil diperbarui'"></ssalert>

		<!-- TABEL DAFTAR ROMBEL  -->
    	<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
    		<div class="padding" v-if="showDaftarRombel">
    			<div class="row">
    				<div class="col-sm-12">
    					<div class="box">
    						<div class="box-header">
    							<h2>Rombongan Belajar</h2>
    						</div>
    						<div class="box-body">
    							<div class="row">
    								<div class="col-sm-9 col-xs-12">
    									<button class="btn btn-fw white" @click="showForm('showFormAdd')"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
										<button class="btn btn-fw white" @click="multipleDeleteRombel"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
										<!-- <button class="btn btn-fw white" @click="$store.state.salinConfirm = true" v-if="smtGenap"><i class="fa fa-copy"></i>&nbsp; Lanjutkan Semester</button> -->
										<button class="btn btn-fw white" @click="$store.state.naikTingkatConfirm = true" v-if="smtGenap === false"><i class="fa fa-level-up"></i>&nbsp; Naik Kelas</button>
    								</div>
    								<div class="col-sm-3 col-xs-12">
    									<div class="form-group row">
    										<label for="" class="col-sm-3 form-control-label">Tampilkan</label>
    										<div class="col-sm-9">
    											<select class="form-control" v-model="$store.state.jmlBaris" v-on:change="showPerPage">
	    											<option value="10" class="text-black">10 baris</option>
	    											<option value="25" class="text-black">25 baris</option>
	    											<option value="50" class="text-black">50 baris</option>
	    											<option value="100" class="text-black">100 baris</option>
	    											<option value="250" class="text-black">250 baris</option> 
	    										</select>
    										</div>
    									</div>
    								</div>
    							</div>
    						</div>

    						<table class="table table-striped b-t">
    							<thead>
    								<tr>
    									<th class="text-center">
											<label class="md-check"><input type="checkbox" v-model="$store.state.allSelected" @click="selectAll">
												<i class="primary"></i>
											</label>
    									</th>
										<th>ID</th>
    									<th>Nama Rombel</th>
    									<th>Tingkat Kelas</th>
    									<th>Wali Kelas</th>
    									<th colspan="3" width="80" class="text-center">Aksi</th>
    								</tr>
    							</thead>
    							<tbody>
    								<tr v-for="list in daftarRombel">
    									<td class="text-center">
											<label class="md-check"><input type="checkbox" v-model="$store.state.selectedRombel" :value="list.id_rombel">
												<i class="primary"></i>
											</label>
    									</td>
										<td>{{ list.id_rombel }}</td>
    									<td>{{ list.nama_rombel }}</td>
    									<td>{{ list.tingkat }}</td>
    									<td>{{ list.nama_guru }}</td>
    									<td class="text-center ss-cursor-pointer" @click="editRombel(list.id_rombel)"><i class="material-icons">edit</i></td>
    	                                <!-- <td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">group</i></td> -->
    									<td class="text-center ss-cursor-pointer" @click="showDeleteConfirm(list.id_rombel)"><i class="material-icons">delete</i></td>
    								</tr>
    							</tbody>
    							<tfoot>
    								<td colspan="7" class="text-center">
    									<div class="col-sm-6 text-left">
    										<p> {{ $store.getters.getRowsRange }} </p>
    									</div>
    									<div class="col-sm-6 text-center">
    										<ul class="pagination pagination-sm m-a-0">
    											<li><a href="javascript:void(0)" @click="getRombel(localLimit, paging('first'))"><i class="material-icons">skip_previous</i></a></li>
    											<li><a href="javascript:void(0)" @click="getRombel(localLimit, paging('prev'))"><i class="material-icons">navigate_before</i></a></li>
    											<li>
    												<div class="col-xs-3">
    													<input type="text" class="form-control" v-model="$store.state.paging.setStart" @keyup.enter="getRombel(localLimit, $store.state.paging.setStart - 1)">
    												</div>
    											</li>
    											<li><a href="javascript:void(0)" @click="getRombel(localLimit, paging('next'))"><i class="material-icons">navigate_next</i></a></li>
    											<li><a href="javascript:void(0)" @click="getRombel(localLimit, paging('last'))"><i class="material-icons">skip_next</i></a></li>
												<li><a href="javascript:void(0)" @click="getRombel(localLimit, ($store.getters.activePage - 1))"><i class="material-icons">refresh</i></a></li>
    										</ul>
    									</div>
    								</td>
    							</tfoot>
    						</table>
    					</div>
    				</div>
    			</div>
    		</div>
    	</transition>
		<!-- #END TABEL DAFTAR ROMBEL  -->

		<!-- Konfirmai hapus data -->
		<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="modal ss-modal" data-backdrop="true" v-if="deleteConfirm">
				<div class="modal-dialog">
					<div class="col-sm-8 offset-sm-2">
						<div class="modal-content black lt m-b">
							<div class="modal-header">
								<h5 class="modal-title">Konfirmasi</h5>
							</div>
							<div class="modal-body">
								<p>Apakah anda yakin ingin menghapus rombel terpilih?</p>
							</div>
							<div class="modal-footer">
								<button class="btn white" @click="closeDeleteConfirm">Cancel</button>
								<button class="btn primary" @click="deleteRombel">OK</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</transition>

		<!-- KONFIRMASI NAIK TINGKAT ROMBEL  -->
	    <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
	    	<div class="modal ss-modal" data-backdrop="true" v-if="$store.state.naikTingkatConfirm">
	    		<div class="modal-dialog">
	    			<div class="col-sm-8 offset-sm-2">
	    				<div class="modal-content black lt m-b">
	    					<div class="modal-header">
	    						<h5 class="modal-title">Konfirmasi</h5>
	    					</div>
	    					<div class="modal-body">
	    						<p>
									Apakah anda yakin ingin menaikkan tingkat kelas semua peserta didik?<br>
								</p>
	    					</div>
	    					<div class="modal-footer">
	    						<button class="btn white" @click="$store.state.naikTingkatConfirm = false">Cancel</button>
	    						<button class="btn primary" @click="naikTingkat">OK</button>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </transition>
		<!-- #END KONFIRMASI NAIK TINGKAT ROMBEL  -->

		<!-- PROGRESS SAAT NAIK TINGKAT ROMBEL  -->
		<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
	    	<div class="modal ss-modal" data-backdrop="true" v-if="naikTingkatProgress">
	    		<div class="modal-dialog">
	    			<div class="col-sm-8 offset-sm-2">
	    				<div class="modal-content black lt m-b">
	    					<div class="modal-header">
	    						<h5 class="modal-title">Info</h5>
	    					</div>
	    					<div class="modal-body">
	    						<p class="text-center ss-loading-text">{{ progressText }}</p>
	    					</div>
	    					<div class="modal-footer">
	    						<button class="btn primary" @click="$store.state.naikTingkatProgress = false">Tutup</button>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </transition>
		<!-- #END PROGRESS NAIK TINGKAT ROMBEL -->

		<!-- FORM TAMBAH ROMBEL -->
		<TambahRombel />

		<!-- FORM EDIT ROMBEL -->
		<EditRombel />

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
import { Rombel } from '../../../scripts/store/Rombel'
import TambahRombel from './TambahRombel.vue'
import EditRombel from './EditRombel.vue'
import ssalert from '../../../template/content/alert.vue'
import { sserror } from '../../../scripts/modules/Shared'

Vue.use(Vuex)

export default {
	name: 'Rombel',
	store: Rombel,
	components: {
		sserror,
		ssalert,
		TambahRombel,
		EditRombel
	},
	beforeRouteEnter(to, from, next) {
		next(vm => vm.getRombel(10, 0))
	},
	beforeRouteUpdate(to, from, next) {
		next()
	},
	beforeRouteLeave(to, from, next) {
		this.$store.state.jmlBaris = 10
		this.$store.state.localLimit = 10
		next()
	},
	data() {
		return {}
	},
	methods: {
		...mapMutations([
			'showForm', 'showDeleteConfirm', 'closeDeleteConfirm',
			'selectAll',
		]),
		...mapActions([
			'showPerPage', 'naikTingkat', 'editRombel',
			'deleteRombel', 'multipleDeleteRombel'
		]),
		getRombel(limit, offset) {
			this.$store.dispatch('getRombel', {
				limit,
				offset
			})
		},
		paging(param) {
			return this.$store.state.paging[param]
		},
	},
	computed: {
		...mapState([
			'showDaftarRombel', 'daftarRombel',
			'smtGenap', 'naikTingkatConfirm', 'naikTingkatProgress', 
			'progressText', 'localLimit', 'alert', 'deleteConfirm',
			'allSelected',
		]),
	}
}
</script>