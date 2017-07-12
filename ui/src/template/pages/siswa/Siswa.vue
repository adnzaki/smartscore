<template lang="html">
	<div id="dataSiswa">
		<!-- Delete alert -->
		<ssalert :alertClass="'alert-success ss-fly-alert'" :target="deleteAlert" :initMsg="'Sukses!'" :msg="'Data siswa berhasil dihapus.'"></ssalert>

	    <!-- Unable to delete -->
		<ssalert :alertClass="'alert-danger ss-fly-alert'" :target="unableToDelete" :initMsg="'Error!'" :msg="'Silakan pilih siswa yang ingin dihapus.'"></ssalert>

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
	    										<a class="dropdown-item" v-bind:href="formatExcel">
	    											<i class="material-icons">file_download</i>
	    											Download Format Data Siswa (Excel)
	    										</a>
	    										<a class="dropdown-item" href="javascript:void(0)" @click="importDialog = true">
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
	    										<select class="form-control">
													<option class="text-black">Pilih Baris</option>
	    											<option @click="showPerPage(10)" class="text-black">10 baris</option>
	    											<option @click="showPerPage(25)" class="text-black">25 baris</option>
	    											<option @click="showPerPage(50)" class="text-black">50 baris</option>
	    											<option @click="showPerPage(100)" class="text-black">100 baris</option>
	    											<option @click="showPerPage(250)" class="text-black">250 baris</option>
	    										</select>
	    									</div>
	    								</div>
	    							</div>
	    							<div class="col-sm-3 col-xs-12">
	    								<input type="text" class="form-control" v-model="cariSiswa" @keyup.enter="getSiswa(limit, 0, cariSiswa)" placeholder="Cari siswa (ketik dan enter)">
	    							</div>
	    						</div>
	    					</div>

	    					<table class="table table-striped b-t">
	    						<thead>
	    							<tr>
	    								<th width="30">#</th>
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
											<label class="md-check"><input type="checkbox" v-model="selectedID" :value="list.id_siswa">
												<i class="primary"></i>
											</label>
	    								</td>
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
	    								<div class="col-sm-8 text-left">
	    									<p>Menampilkan baris <b>{{ dataFrom() }}</b> - <b>{{ dataTo() }}</b> dari <b>{{ totalRows }}</b> baris.</p>
	    								</div>
	    								<div class="col-sm-4 text-center">
	    									<ul class="pagination pagination-sm m-a-0">
	    										<li><a href="javascript:void(0)" @click="getSiswa(limit, first, cariSiswa)"><i class="material-icons">skip_previous</i></a></li>
	    										<li><a href="javascript:void(0)" @click="getSiswa(limit, prev, cariSiswa)"><i class="material-icons">navigate_before</i></a></li>
	    										<li>
	    											<div class="col-xs-3">
	    												<input type="text" class="form-control" v-model="setStart" @keyup.enter="getSiswa(limit, setStart - 1, cariSiswa)">
	    											</div>
	    										</li>
	    										<li><a href="javascript:void(0)" @click="getSiswa(limit, next, cariSiswa)"><i class="material-icons">navigate_next</i></a></li>
	    										<li><a href="javascript:void(0)" @click="getSiswa(limit, last, cariSiswa)"><i class="material-icons">skip_next</i></a></li>
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
	    						<button class="btn primary" @click="importProgress = false">Tutup</button>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </transition>

		<!-- FORM TAMBAH SISWA -->
		<div>
			<!-- Success alert -->
			<div class="padding less-m-b">
		        <div class="alert alert-success alert-dismissible ss-no-b-r" role="alert" v-if="insertAlert">
		            <button type="button" class="close" @click="insertAlert = false" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		            <strong>Sukses</strong> Data siswa baru berhasil disimpan.
		            <a href="javascript:void(0)" @click="editSiswa(idSiswa)">
		                <b><u>Lihat detail</u></b>
		            </a>
		        </div>
		    </div>

		    <!-- Error alert -->
			<ssalert :alertClass="'alert-danger'" :target="errorInsert" :initMsg="'Error!'" :msg="'Data siswa tidak dapat disimpan, silakan isi form dengan benar.'"></ssalert>

		    <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
		    	<div class="padding" v-if="showFormAdd">
		    		<div class="row">
		    			<div class="col-sm-12">
		    				<div class="box">
		    					<div class="row">
		    						<div class="col-sm-8">
		    							<div class="box-header">
		    								<h2>Tambah Siswa</h2>
		    							</div>
		    						</div>
		    						<div class="col-sm-4 text-right">
		    							<div class="box-header">
		    								<button class="btn btn-icon danger" @click="closeForm('showFormAdd')"><i class="fa fa-remove"></i></button>
		    							</div>
		    						</div>
		    					</div>

		    					<div class="box-divider m-a-0"></div>
		    					<div class="box-body">
		    						<form role="form" id="formTambahSiswa">
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Nama Lengkap</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="nama_siswa" placeholder="Nama Lengkap">
		    									<sserror :msg="error.nama"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Nomor Induk Sekolah</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="nis" placeholder="Nomor Induk Sekolah" minlength="9" maxlength="9">
		    									<sserror :msg="error.nis"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">NISN</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="nisn" placeholder="Nomor Induk Siswa Nasional" minlength="10" maxlength="10">
		    									<sserror :msg="error.nisn"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Jenis Kelamin</label>
		    								<div class="col-sm-10">
		    									<label class="md-check">
		    										<input type="radio" id="j_laki" checked name="j_kelamin_siswa" value="Laki-laki">
		    										<i class="green"></i>Laki-laki
		    									</label>&nbsp &nbsp &nbsp
		    									<label class="md-check">
		    										<input type="radio" id="j_perempuan" name="j_kelamin_siswa" value="Perempuan">
		    										<i class="green"></i>Perempuan
		    									</label>
		    									<sserror :msg="error.jKelaminSiswa"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Tempat Lahir</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="tempat_lahir_siswa" placeholder="Tempat Lahir">
		    									<sserror :msg="error.tmptLahir"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Tanggal Lahir</label>
		    								<div class="col-sm-10">
		    									<div class="form-group">
		    										<div class='input-group date' id='datetimepicker1'>
		    											<input type='text' class="form-control" name="tgl_lahir_siswa" minlength="10" maxlength="10" />
		    											<span class="input-group-addon">
		    						                        <span class="fa fa-calendar"></span>
		    											</span>
		    										</div>
		    										<sserror :msg="error.tglLahir"></sserror>
		    									</div>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Agama</label>
		    								<div class="col-sm-10">
		    									<div class="form-group">
		    										<select class="form-control c-select" name="agama_siswa">
		    											<option value="Islam">Islam</option>
		    											<option value="Katholik">Katholik</option>
		    											<option value="Protestan">Kristen Protestan</option>
		    											<option value="Hindu">Hindu</option>
		    											<option value="Buddha">Buddha</option>
		    										</select>
		    									</div>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Pendidikan Sebelumnya</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="pend_sblm" placeholder="Nama Taman Kanak-kanak (Kosongkan jika tidak ada)">
		    									<sserror :msg="error.pendSblm"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Alamat Siswa</label>
		    								<div class="col-sm-10">
		    									<textarea class="form-control" name="alamat_siswa" rows="2"></textarea>
		    									<sserror :msg="error.alamatSiswa"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Nama Ayah</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="nama_ayah" placeholder="Nama Ayah">
		    									<sserror :msg="error.namaAyah"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Nama Ibu</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="nama_ibu" placeholder="Nama Ibu">
		    									<sserror :msg="error.namaIbu"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Pekerjaan Ayah</label>
		    								<div class="col-sm-10">
		    									<div class="form-group">
		    										<select class="form-control c-select" name="job_ayah">
		    											<option value="PNS">PNS</option>
		    											<option value="Karyawan Swasta">Karyawan Swasta</option>
		    											<option value="Wiraswasta">Wiraswasta</option>
		    											<option value="Buruh">Buruh</option>
		    											<option value="Tidak Bekerja">Tidak Bekerja</option>
		    											<option value="Lain-lain">Lain-lain</option>
		    										</select>
		    									</div>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Pekerjaan Ibu</label>
		    								<div class="col-sm-10">
		    									<div class="form-group">
		    										<select class="form-control c-select" name="job_ibu">
		    											<option value="PNS">PNS</option>
		    											<option value="Karyawan Swasta">Karyawan Swasta</option>
		    											<option value="Wiraswasta">Wiraswasta</option>
		    											<option value="Buruh">Buruh</option>
		    											<option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
		    											<option value="Lain-lain">Lain-lain</option>
		    										</select>
		    									</div>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Alamat Orang Tua</label>
		    								<div class="col-sm-10">
		    									<textarea class="form-control" name="alamat_ortu" rows="2"></textarea>
		    									<sserror :msg="error.alamatOrtu"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">No. Telp. Orang tua</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="telp_ortu" placeholder="No. Telepon" minlength="12" maxlength="15">
		    									<sserror :msg="error.telpOrtu"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Nama Wali</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="nama_wali" placeholder="Nama Wali (Kosongkan jika tidak ada)">
		    									<sserror :msg="error.namaWali"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Alamat Wali</label>
		    								<div class="col-sm-10">
		    									<textarea class="form-control" name="alamat_wali" rows="2" placeholder="Alamat Wali (Kosongkan jika tidak ada)"></textarea>
		    									<sserror :msg="error.alamatWali"></sserror>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">Pekerjaan Wali</label>
		    								<div class="col-sm-10">
		    									<div class="form-group">
		    										<select class="form-control c-select" name="job_wali">
		    											<option value="PNS">PNS</option>
		    											<option value="Karyawan Swasta">Karyawan Swasta</option>
		    											<option value="Wiraswasta">Wiraswasta</option>
		    											<option value="Buruh">Buruh</option>
		    											<option value="Tidak Bekerja">Tidak Bekerja</option>
		    											<option value="Lain-lain">Lain-lain</option>
		    										</select>
		    									</div>
		    								</div>
		    							</div>
		    							<div class="form-group row">
		    								<label class="col-sm-2 form-control-label">No. Telp. Wali</label>
		    								<div class="col-sm-10">
		    									<input type="text" class="form-control" name="telp_wali" placeholder="No. Telepon Wali (Kosongkan jika tidak ada)" minlength="12" maxlength="15">
		    									<sserror :msg="error.telpWali"></sserror>
		    								</div>
		    							</div>

		    							<div class="form-group row m-t-md">
		    								<div class="offset-sm-8 col-sm-4 text-right">
		    									<a ui-scroll-to="content">
		    										<button type="button" class="btn btn-fw success" @click="insertSiswa('insert')">Simpan</button>
		    									</a>
		    									<button type="button" class="btn btn-fw info" @click="closeForm('showFormAdd')">Tutup</button>
		    								</div>
		    							</div>
		    						</form>
		    					</div>
		    				</div>
		    			</div>
		    		</div>
		    	</div>
		    </transition>

		    <!-- Warning modal -->
		    <!-- <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
		    	<div class="modal ss-modal" data-backdrop="true" v-if="sidebar.modal.siswaIsFilled">
		    		<div class="modal-dialog">
		    			<div class="col-sm-8 offset-sm-2">
		    				<div class="modal-content black lt m-b">
		    					<div class="modal-header">
		    						<h5 class="modal-title">Peringatan</h5>
		    					</div>
		    					<div class="modal-body">
		    						<p>Terdapat isian yang belum disimpan, apakah anda yakin ingin menutup halaman ini?</p>
		    					</div>
		    					<div class="modal-footer">
		    						<button class="btn white" @click="sidebar.modal.siswaIsFilled = false">Cancel</button>
		    						<button class="btn primary" @click="sidebar.forceShowDaftarSiswa">OK</button>
		    					</div>
		    				</div>
		    			</div>
		    		</div>
		    	</div>
		    </transition> -->
		</div>
		<!-- #END FORM TAMBAH SISWA -->

		<!-- FORM EDIT SISWA -->
		<div>
			<!-- Success alert -->
			<ssalert :alertClass="'alert-success'" :target="updateAlert" :initMsg="'Sukses!'" :msg="'Data siswa berhasil diperbarui'"></ssalert>

			<!-- Error alert -->
			<ssalert :alertClass="'alert-danger'" :target="errorUpdate" :initMsg="'Error!'" :msg="'Gagal memperbarui data siswa, silakan isi form dengan benar'"></ssalert>

			<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
				<div class="padding" v-if="showFormEdit">
					<div class="row">
						<div class="col-sm-12">
							<div class="box">
								<div class="row">
									<div class="col-sm-8">
										<div class="box-header">
											<h2>Edit Data Siswa</h2>
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
									<form role="form" id="formEditSiswa">
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Nama Lengkap</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.nama_siswa" name="nama_siswa" placeholder="Nama Lengkap">
												<sserror :msg="error.nama"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Nomor Induk Sekolah</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.nis" name="nis" placeholder="Nomor Induk Sekolah" minlength="9" maxlength="9">
												<sserror :msg="error.nis"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">NISN</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.nisn" name="nisn" placeholder="Nomor Induk Siswa Nasional" minlength="10" maxlength="10">
												<sserror :msg="error.nisn"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Jenis Kelamin</label>
											<div class="col-sm-10">
												<label class="md-check">
													<input type="radio" id="j_laki" name="j_kelamin_siswa" value="L">
													<i class="green"></i>Laki-laki
												</label>&nbsp &nbsp &nbsp
												<label class="md-check">
													<input type="radio" id="j_perempuan" name="j_kelamin_siswa" value="P">
													<i class="green"></i>Perempuan
												</label>
												<sserror :msg="error.jKelaminSiswa"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Tempat Lahir</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.tempat_lahir_siswa" name="tempat_lahir_siswa" placeholder="Tempat Lahir">
												<sserror :msg="error.tmptLahir"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Tanggal Lahir</label>
											<div class="col-sm-10">
												<div class="form-group">
													<div class='input-group date' id='datetimepicker1'>
														<input type='text' class="form-control" v-model="detailSiswa.tgl_lahir_siswa" name="tgl_lahir_siswa" minlength="10" maxlength="10" />
														<span class="input-group-addon">
															<span class="fa fa-calendar"></span>
														</span>
													</div>
													<sserror :msg="error.tglLahir"></sserror>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Agama</label>
											<div class="col-sm-10">
												<div class="form-group">
													<select class="form-control c-select" id="agama_siswa" name="agama_siswa">
														<option value="Islam">Islam</option>
														<option value="Katholik">Katholik</option>
														<option value="Protestan">Kristen Protestan</option>
														<option value="Hindu">Hindu</option>
														<option value="Buddha">Buddha</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Pendidikan Sebelumnya</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.pend_sblm" name="pend_sblm" placeholder="Nama Taman Kanak-kanak (Kosongkan jika tidak ada)">
												<sserror :msg="error.pendSblm"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Alamat Siswa</label>
											<div class="col-sm-10">
												<textarea class="form-control" v-model="detailSiswa.alamat_siswa" name="alamat_siswa" rows="2"></textarea>
												<sserror :msg="error.alamatSiswa"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Nama Ayah</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.nama_ayah" name="nama_ayah" placeholder="Nama Ayah">
												<sserror :msg="error.namaAyah"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Nama Ibu</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.nama_ibu" name="nama_ibu" placeholder="Nama Ibu">
												<sserror :msg="error.namaIbu"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Pekerjaan Ayah</label>
											<div class="col-sm-10">
												<div class="form-group">
													<select class="form-control c-select" id="job_ayah" name="job_ayah">
														<option value="PNS">PNS</option>
														<option value="Karyawan Swasta">Karyawan Swasta</option>
														<option value="Wiraswasta">Wiraswasta</option>
														<option value="Buruh">Buruh</option>
														<option value="Tidak Bekerja">Tidak Bekerja</option>
														<option value="Lain-lain">Lain-lain</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Pekerjaan Ibu</label>
											<div class="col-sm-10">
												<div class="form-group">
													<select class="form-control c-select" id="job_ibu" name="job_ibu">
														<option value="PNS">PNS</option>
														<option value="Karyawan Swasta">Karyawan Swasta</option>
														<option value="Wiraswasta">Wiraswasta</option>
														<option value="Buruh">Buruh</option>
														<option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
														<option value="Lain-lain">Lain-lain</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Alamat Orang Tua</label>
											<div class="col-sm-10">
												<textarea class="form-control" v-model="detailSiswa.alamat_ortu" name="alamat_ortu" rows="2"></textarea>
												<sserror :msg="error.alamatOrtu"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">No. Telp. Orang tua</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.telp_ortu" name="telp_ortu" placeholder="No. Telepon" minlength="12" maxlength="15">
												<sserror :msg="error.telpOrtu"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Nama Wali</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.nama_wali" name="nama_wali" placeholder="Nama Wali (Kosongkan jika tidak ada)">
												<sserror :msg="error.namaWali"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Alamat Wali</label>
											<div class="col-sm-10">
												<textarea class="form-control" v-model="detailSiswa.alamat_wali" name="alamat_wali" rows="2" placeholder="Alamat Wali (Kosongkan jika tidak ada)"></textarea>
												<sserror :msg="error.alamatWali"></sserror>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Pekerjaan Wali</label>
											<div class="col-sm-10">
												<div class="form-group">
													<select class="form-control c-select" id="job_wali" name="job_wali">
														<option value="PNS">PNS</option>
														<option value="Karyawan Swasta">Karyawan Swasta</option>
														<option value="Wiraswasta">Wiraswasta</option>
														<option value="Buruh">Buruh</option>
														<option value="Tidak Bekerja">Tidak Bekerja</option>
														<option value="Lain-lain">Lain-lain</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">No. Telp. Wali</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" v-model="detailSiswa.telp_wali" name="telp_wali" placeholder="No. Telepon Wali (Kosongkan jika tidak ada)" minlength="12" maxlength="15">
												<sserror :msg="error.telpWali"></sserror>
											</div>
										</div>
										<!-- ################### END OF FORM ######################## -->
										<div class="form-group row m-t-md">
											<div class="offset-sm-8 col-sm-4 text-right">
												<a ui-scroll-to="content">
													<button type="button" class="btn btn-fw success" @click="insertSiswa('update', detailSiswa.id_siswa)">Simpan</button>
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
		<!-- #END FORM EDIT SISWA -->
	</div>



</template>
<script src="../../../scripts/siswa.js"></script>
