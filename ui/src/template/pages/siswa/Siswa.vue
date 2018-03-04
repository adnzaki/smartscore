<template lang="html">
	<div id="dataSiswa">
		<!-- Delete alert -->
		<ssalert :alertClass="'alert-success'" :target="deleteAlert" :initMsg="'Sukses!'" :msg="'Data siswa berhasil dihapus.'" />

		<!-- Unable to delete -->
		<ssalert :alertClass="'alert-danger'" :target="unableToDelete" :initMsg="'Error!'" :msg="'Silakan pilih siswa yang ingin dihapus.'"
		/>

		<!-- TABEL DAFTAR SISWA -->
		<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="padding" v-if="showDaftarSiswa">
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h2>Data Siswa</h2>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6 col-xs-12">
										<button class="btn btn-fw white" @click="showForm('showFormAdd')"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
										<button class="btn btn-fw white" @click="multipleDeleteSiswa"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
										<div class="dropdown inline">
											<button class="btn white dropdown-toggle" data-toggle="dropdown">Impor </button>
											<div class="dropdown-menu">
												<a class="dropdown-item" v-bind:href="$store.state.shared.apiUrl + 'public/docs/FormatDataSiswa.xlsx'">
	    											<i class="material-icons">file_download</i>
	    											Download Format Data Siswa (Excel)
	    										</a>
												<a class="dropdown-item" href="javascript:void(0)" @click="$store.state.importDialog = true">
	    											<i class="material-icons">file_upload</i>
	    											Upload Data Siswa
	    										</a>
											</div>
										</div>
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
										<input type="text" class="form-control" v-model="$store.state.cariSiswa" @keyup.enter="getSiswa(localLimit, 0, $store.state.cariSiswa)" placeholder="Cari siswa (ketik dan enter)">
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
										<th>Nomor Induk</th>
										<th>Nama Siswa</th>
										<th>Jenis Kelamin</th>
										<th>Tempat Lahir</th>
										<th>Tanggal Lahir</th>
										<th colspan="2" class="text-center">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="list in daftarSiswa">
										<td class="text-center">
											<label class="md-check"><input type="checkbox" v-model="$store.state.selectedID" :value="list.id_siswa">
												<i class="primary"></i>
											</label>
										</td>
										<td>{{ list.nis }}</td>
										<td>{{ list.nama_siswa }}</td>
										<td>{{ list.j_kelamin_siswa }}</td>
										<td>{{ list.tempat_lahir_siswa }}</td>
										<td>{{ list.tgl_lahir_siswa }}</td>
										<td class="text-center ss-cursor-pointer" @click="editSiswa(list.id_siswa)"><i class="material-icons">edit</i></td>
										<td class="text-center ss-cursor-pointer" @click="showDeleteConfirm(list.id_siswa)"><i class="material-icons">delete</i></td>
									</tr>
								</tbody>
								<tfoot>
									<td colspan="8" class="text-center">
										<div class="col-sm-6 text-left">
											<p> {{ $store.getters.getRowsRange }} </p>
										</div>
										<div class="col-sm-6 text-center" v-if="$store.state.paging.showPaging">
											<ul class="pagination pagination-sm m-a-0">
												<li><a href="javascript:void(0)" @click="getSiswa(localLimit, paging('first'), cariSiswa)"><i class="material-icons">skip_previous</i></a></li>
												<li><a href="javascript:void(0)" @click="getSiswa(localLimit, paging('prev'), cariSiswa)"><i class="material-icons">navigate_before</i></a></li>
												<li>
													<div class="col-xs-3">
														<input type="text" class="form-control" v-model="$store.state.paging.setStart" @keyup.enter="getSiswa(localLimit, $store.state.paging.setStart - 1, cariSiswa)">
													</div>
												</li>
												<li><a href="javascript:void(0)" @click="getSiswa(localLimit, paging('next'), cariSiswa)"><i class="material-icons">navigate_next</i></a></li>
												<li><a href="javascript:void(0)" @click="getSiswa(localLimit, paging('last'), cariSiswa)"><i class="material-icons">skip_next</i></a></li>
												<li><a href="javascript:void(0)" @click="getSiswa(localLimit, ($store.getters.activePage - 1), cariSiswa)"><i class="material-icons">refresh</i></a></li>
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
								<button class="btn primary" @click="deleteSiswa">OK</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</transition>

		<!-- Modal dialog untuk impor data siswa -->
		<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="modal ss-modal" data-backdrop="true" v-if="importDialog">
				<div class="modal-dialog">
					<div class="col-sm-8 offset-sm-2">
						<div class="modal-content black lt m-b">
							<div class="modal-header">
								<h5 class="modal-title">Impor Data</h5>
							</div>
							<div class="modal-body">
								<p>Silakan pilih file Excel yang telah terisi dengan data valid.</p>
								<p>
									<form action="" name="imporSiswa" method="post" enctype="multipart/form-data">
										<div class="row">
											<div class="col-xs-12">
												<input type="file" name="file" id="file" @change="getFilename" class="form-control">
											</div>
										</div>
									</form>
								</p>
							</div>
							<div class="modal-footer">
								<button class="btn white" @click="closeImportDialog">Cancel</button>
								<button class="btn primary" @click="importSiswa">Impor</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</transition>

		<!-- Modal saat pemrosesan import data... -->
		<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="modal ss-modal" data-backdrop="true" v-if="importProgress">
				<div class="modal-dialog">
					<div class="col-sm-8 offset-sm-2">
						<div class="modal-content black lt m-b">
							<div class="modal-header">
								<h5 class="modal-title">Info</h5>
							</div>
							<div class="modal-body">
								<p class="text-center ss-loading-text">{{ loadingText }}</p>
							</div>
							<div class="modal-footer">
								<button class="btn primary" @click="$store.state.importProgress = false">Tutup</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</transition>

		<!-- FORM TAMBAH SISWA -->
		<TambahSiswa />

		<!-- #END FORM TAMBAH SISWA -->

		<!-- FORM EDIT SISWA -->
		<EditSiswa />
		<!-- #END FORM EDIT SISWA -->
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
	import { Siswa } from '../../../scripts/store/Siswa'
	import TambahSiswa from './TambahSiswa.vue'
	import EditSiswa from './EditSiswa.vue'

	Vue.use(Vuex)

	export default {
		name: 'Siswa',
		store: Siswa,
		components: {
			TambahSiswa,
			EditSiswa
		},
		beforeRouteEnter(to, from, next) {
			next(vm => vm.getSiswa(10, 0, ''))
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
				'getFilename',
				'selectAll'
			]),
			...mapActions([
				'multipleDeleteSiswa',
				'deleteSiswa',
				'editSiswa',
				'showPerPage',
				'importSiswa'
			]),
			getSiswa(limit, offset, search) {
				this.$store.dispatch('getSiswa', {
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
				'deleteAlert', 'unableToDelete', 'showDaftarSiswa',
				'deleteConfirm', 'importDialog', 'importProgress',
				'jmlBaris', 'cariSiswa', 'daftarSiswa', 'selectedID',
				'localLimit', 'loadingText',
			]),
		}
	}
</script>