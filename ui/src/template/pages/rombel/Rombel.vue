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
										<button class="btn btn-fw white" @click="$store.state.salinConfirm = true" v-if="smtGenap"><i class="fa fa-copy"></i>&nbsp; Lanjutkan Semester</button>
										<button class="btn btn-fw white" @click="" v-if="smtGenap === false"><i class="fa fa-level-up"></i>&nbsp; Naik Kelas</button>
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
	    	<div class="modal ss-modal" data-backdrop="true" v-if="$store.state.salinConfirm">
	    		<div class="modal-dialog">
	    			<div class="col-sm-8 offset-sm-2">
	    				<div class="modal-content black lt m-b">
	    					<div class="modal-header">
	    						<h5 class="modal-title">Konfirmasi</h5>
	    					</div>
	    					<div class="modal-body">
	    						<p>
									Apakah anda yakin ingin melanjutkan data rombel dari semester sebelumnya?<br>
								</p>
	    					</div>
	    					<div class="modal-footer">
	    						<button class="btn white" @click="$store.state.salinConfirm = false">Cancel</button>
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
	    						<button class="btn primary" @click="$store.state.salinProgress = false">Tutup</button>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </transition>
		<!-- #END PROGRESS SALIN ROMBEL -->

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
import ssalert from '../../../template/content/alert.vue'
import { sserror } from '../../../scripts/modules/Shared'

Vue.use(Vuex)

export default {
	name: 'Rombel',
	store: Rombel,
	components: {
		sserror,
		ssalert,
	},
	beforeRouteEnter(to, from, next) {
		next(vm => vm.getRombel(10, 0))
	},
	beforeRouteUpdate(to, from, next) {
		this.resetDaftarRombel()
		next()
	},
	beforeRouteLeave(to, from, next) {
		this.hideDataRombel()
		next()
	},
	data() {
		return {
			cookie: this.$store.state.shared.cookieName
		}
	},
	methods: {
		...mapMutations([
			
		]),
		...mapActions([
			'showPerPage', 'salinRombel'
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
		resetDaftarRombel() {
			this.$store.state.daftarRombel = []
			this.$store.dispatch('runGetRombel')
		},
		hideDataRombel() {
			this.$store.state.showDaftarRombel = false
		},

	},
	computed: {
		...mapState([
			'showDaftarRombel', 'daftarRombel',
			'smtGenap', 'salinConfirm', 'salinProgress', 
			'progressText', 'localLimit',
		]),
	}
}
</script>