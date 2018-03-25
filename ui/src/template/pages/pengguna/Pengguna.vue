<template lang="html">
	<div id="dataSiswa">
		<!-- Delete alert -->
		<ssalert :alertClass="'alert-success'" :target="deleteAlert" :initMsg="'Sukses!'" :msg="'Data siswa berhasil dihapus.'" />

		<!-- Unable to delete -->
		<ssalert :alertClass="'alert-danger'" :target="unableToDelete" :initMsg="'Error!'" :msg="'Silakan pilih siswa yang ingin dihapus.'" />

		<!-- Success alert -->
        <ssalert :alertClass="'alert-success'" :target="updateAlert" :initMsg="'Sukses!'" :msg="'Data siswa berhasil diperbarui'"></ssalert>

		<!-- Success alert -->
        <ssalert :alertClass="'alert-success'" :target="insertAndClose" :initMsg="'Sukses!'" :msg="'Data siswa berhasil ditambahkan'"></ssalert>

		<!-- TABEL DAFTAR SISWA -->
		<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="padding" v-if="showDaftarPengguna">
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h2>Data Pengguna</h2>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6 col-xs-12">
										<button class="btn btn-fw white" @click="showForm('showFormAdd')"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
										<button class="btn btn-fw white" @click="multipleDeletePengguna"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
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
									<div class="col-sm-3 col-xs-12">
										<input type="text" class="form-control" v-model="$store.state.cariPengguna" @keyup.enter="getPengguna(localLimit, 0, $store.state.cariPengguna)" placeholder="Cari pengguna (ketik dan enter)">
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
										<th>Nama Pengguna</th>
										<th>Username</th>
										<th>Email</th>
										<th colspan="3" class="text-center">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="list in daftarPengguna">
										<td class="text-center">
											<label class="md-check"><input type="checkbox" v-model="$store.state.selectedID" :value="list.id_pengguna">
												<i class="primary"></i>
											</label>
										</td>
										<td>{{ list.nama_pengguna }}</td>
										<td>{{ list.username }}</td>
										<td>{{ list.email }}</td>
										<td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">edit</i></td>
										<td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">replay</i></td>
                                        <td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">delete</i></td>
									</tr>
								</tbody>
								<tfoot>
									<td colspan="8" class="text-center">
										<div class="col-sm-6 text-left">
											<p> {{ $store.getters.getRowsRange }} </p>
										</div>
										<div class="col-sm-6 text-center" v-if="$store.state.paging.showPaging">
											<ul class="pagination pagination-sm m-a-0">
												<li><a href="javascript:void(0)" @click="getPengguna(localLimit, paging('first'), cariPengguna)"><i class="material-icons">skip_previous</i></a></li>
												<li><a href="javascript:void(0)" @click="getPengguna(localLimit, paging('prev'), cariPengguna)"><i class="material-icons">navigate_before</i></a></li>
												<li>
													<div class="col-xs-3">
														<input type="text" class="form-control" v-model="$store.state.paging.setStart" @keyup.enter="getPengguna(localLimit, $store.state.paging.setStart - 1, cariPengguna)">
													</div>
												</li>
												<li><a href="javascript:void(0)" @click="getPengguna(localLimit, paging('next'), cariPengguna)"><i class="material-icons">navigate_next</i></a></li>
												<li><a href="javascript:void(0)" @click="getPengguna(localLimit, paging('last'), cariPengguna)"><i class="material-icons">skip_next</i></a></li>
												<li><a href="javascript:void(0)" @click="getPengguna(localLimit, ($store.getters.activePage - 1), cariPengguna)"><i class="material-icons">refresh</i></a></li>
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
		<!-- #END TABEL DAFTAR SISWA -->

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
								<p>Apakah anda yakin ingin menghapus data ini?</p>
							</div>
							<div class="modal-footer">
								<button class="btn white" @click="closeDeleteConfirm">Cancel</button>
								<button class="btn primary" @click="deletePengguna">OK</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</transition>

		<!-- FORM TAMBAH PENGGUNA -->

		<!-- #END FORM TAMBAH SISWA -->

		<!-- FORM EDIT NAMA DAN EMAIL -->		

		<!-- #END FORM EDIT NAMA DAN EMAIL -->

        <!-- FORM RESET PASSWORD -->		

		<!-- #END FORM RESET PASSWORD-->
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
	import { Pengguna } from '../../../scripts/store/Pengguna'
	// import TambahSiswa from './TambahSiswa.vue'
	// import EditSiswa from './EditSiswa.vue'

	Vue.use(Vuex)

	export default {
		name: 'Pengguna',
		store: Pengguna,
		components: {
			
		},
		beforeRouteEnter(to, from, next) {
			next(vm => vm.getPengguna(10, 0, ''))
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
				'showDeleteConfirm',
				'closeDeleteConfirm',				
				'showForm',
				'closeImportDialog',
				'selectAll'
			]),
			...mapActions([
				'multipleDeletePengguna',
				'deletePengguna',
				'editPengguna',
				'showPerPage',
			]),
			getPengguna(limit, offset, search) {
				this.$store.dispatch('getPengguna', {
					limit,
					offset,
					search
				})
			},
			paging(param) {
				return this.$store.state.paging[param]
			},
		},
		computed: {
			...mapState([
				'deleteAlert', 'unableToDelete', 'showDaftarPengguna',
				'deleteConfirm', 'jmlBaris', 'cariPengguna', 'daftarPengguna', 'selectedID',
				'localLimit', 'updateAlert', 'insertAndClose'
			]),
		}
	}
</script>