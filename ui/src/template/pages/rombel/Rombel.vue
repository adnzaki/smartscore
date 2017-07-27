<template lang="html">
	<div>
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
    									<button class="btn btn-fw white" @click=""><i class="fa fa-plus"></i>&nbsp; Tambah</button>
										<button class="btn btn-fw white" @click=""><i class="fa fa-trash"></i>&nbsp; Hapus</button>
										<button class="btn btn-fw white" @click="salinConfirm = true"><i class="fa fa-copy"></i>&nbsp; Salin</button>
										<button class="btn btn-fw white" @click="" v-if="smtGenap"><i class="fa fa-level-up"></i>&nbsp; Naik Kelas</button>
    								</div>
    								<div class="col-sm-3 col-xs-12">
    									<div class="form-group row">
    										<label for="" class="col-sm-3 form-control-label">Tampilkan</label>
    										<div class="col-sm-9">
    											<select class="form-control" v-model="jmlBaris" v-on:change="showPerPage">
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
    									<th width="30">#</th>
    									<th>Nama Rombel</th>
    									<th>Tingkat Kelas</th>
    									<th>Wali Kelas</th>
    									<th class="text-center">Jumlah Siswa</th>
    									<th colspan="3" width="80" class="text-center">Aksi</th>
    								</tr>
    							</thead>
    							<tbody>
    								<tr v-for="list in daftarRombel">
    									<td class="text-center">
											<label class="md-check"><input type="checkbox">
												<i class="primary"></i>
											</label>
    									</td>
    									<td>{{ list.nama_rombel }}</td>
    									<td>{{ list.tingkat }}</td>
    									<td>{{ list.nama_guru }}</td>
    									<td class="text-center">38</td>
    									<td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">edit</i></td>
    	                                <td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">group</i></td>
    									<td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">delete</i></td>
    								</tr>
    							</tbody>
    							<tfoot>
    								<td colspan="4" class="text-center">
    									<div class="col-sm-8 text-left">
    										<p>Menampilkan baris <b>{{ dataFrom() }}</b> - <b>{{ dataTo() }}</b> dari <b>{{ totalRows }}</b> baris.</p>
    									</div>
    									<div class="col-sm-4 text-center">
    										<ul class="pagination pagination-sm m-a-0">
    											<li><a href="javascript:void(0)" @click="getRombel(limit, first)"><i class="material-icons">skip_previous</i></a></li>
    											<li><a href="javascript:void(0)" @click="getRombel(limit, prev)"><i class="material-icons">navigate_before</i></a></li>
    											<li>
    												<div class="col-xs-3">
    													<input type="text" class="form-control" v-model="setStart" @keyup.enter="getRombel(limit, setStart - 1)">
    												</div>
    											</li>
    											<li><a href="javascript:void(0)" @click="getRombel(limit, next)"><i class="material-icons">navigate_next</i></a></li>
    											<li><a href="javascript:void(0)" @click="getRombel(limit, last)"><i class="material-icons">skip_next</i></a></li>
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

		<!-- KONFIRMASI SALIN ROMBEL  -->
	    <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
	    	<div class="modal ss-modal" data-backdrop="true" v-if="salinConfirm">
	    		<div class="modal-dialog">
	    			<div class="col-sm-8 offset-sm-2">
	    				<div class="modal-content black lt m-b">
	    					<div class="modal-header">
	    						<h5 class="modal-title">Konfirmasi</h5>
	    					</div>
	    					<div class="modal-body">
	    						<p>
									Apakah anda yakin ingin menyalin data rombel dari semester sebelumnya?<br>
									Note:<br>
									<small class="text-yellow">Duplikasi rombel mungkin akan terjadi jika anda telah mengisi data rombel untuk semester ini.</small>
								</p>
	    					</div>
	    					<div class="modal-footer">
	    						<button class="btn white" @click="salinConfirm = false">Cancel</button>
	    						<button class="btn primary" @click="salinRombel">OK</button>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </transition>
		<!-- #END KONFIRMASI SALIN ROMBEL  -->

		<!-- PROGRESS SAAT SALIN ROMBEL  -->
		<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
	    	<div class="modal ss-modal" data-backdrop="true" v-if="salinProgress">
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
	    						<button class="btn primary" @click="salinProgress = false">Tutup</button>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </transition>
		<!-- #END PROGRESS SALIN ROMBEL -->

    </div>
</template>
<script src="../../../scripts/rombel.js" charset="utf-8"></script>
