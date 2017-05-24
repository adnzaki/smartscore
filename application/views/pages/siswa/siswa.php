<!-- Delete alert -->
<div class="padding less-m-b">
	<div class="alert alert-success alert-dismissible ss-no-b-r" role="alert" v-if="deleteAlert">
		<button type="button" class="close" @click="deleteAlert = false" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Sukses!</strong> Data siswa berhasil dihapus
	</div>
</div>

<transition enter-active-class="animated slideInLeft" leave-active-class="animated slideOutRight">
	<div class="padding" v-if="showDaftarSiswa">
		<div class="row">
			<div class="col-sm-12">
				<div class="box">
					<div class="box-header">
						<h2>Data Siswa</h2>
					</div>
					<div class="box-body">
						<button class="btn btn-fw white" @click="showForm('showFormAdd')"><i class="fa fa-plus"></i>&nbsp Tambah</button>
					</div>

					<table class="table table-striped b-t">
						<thead>
							<tr>
								<th>Nama Siswa</th>
								<th>Jenis Kelamin</th>
								<th>Tempat Lahir</th>
								<th>Tanggal Lahir</th>
								<th colspan="2" class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="list in daftarSiswa">
								<td>{{ list.nama_siswa }}</td>
								<td>{{ list.j_kelamin_siswa }}</td>
								<td>{{ list.tempat_lahir_siswa }}</td>
								<td>{{ list.tgl_lahir_siswa }}</td>
								<td class="text-center ss-cursor-pointer" @click="editSiswa(list.id_siswa)"><i class="material-icons">edit</i></td>
								<td class="text-center ss-cursor-pointer" @click="showDeleteConfirm(list.id_siswa)"><i class="material-icons">delete</i></td>
							</tr>
						</tbody>
						<tfoot>
							<td colspan="4" class="text-center">
								<div class="col-sm-4 offset-sm-8 text-center">
									<ul class="pagination pagination-sm m-a-0">
										<li><a href="javascript:void(0)" @click="getSiswa(limit, first)"><i class="material-icons">skip_previous</i></a></li>
										<li><a href="javascript:void(0)" @click="getSiswa(limit, prev)"><i class="material-icons">navigate_before</i></a></li>
										<li>
											<div class="col-xs-3">
												<input type="text" class="form-control" v-model="setStart" placeholder="Enter email"
												@keyup.enter="getSiswa(limit, setStart - 1)">
											</div>
										</li>
										<li><a href="javascript:void(0)" @click="getSiswa(limit, next)"><i class="material-icons">navigate_next</i></a></li>
										<li><a href="javascript:void(0)" @click="getSiswa(limit, last)"><i class="material-icons">skip_next</i></a></li>
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
						<button class="btn white" @click="deleteConfirm = false">Cancel</button>
						<button class="btn primary" @click="deleteSiswa" ui-scroll-to="content">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</transition>
