<template>
  <div>
  		<!-- insert success alert -->
        <ssalert :alertClass="'alert-success'" :target="alert.insert" :initMsg="'Sukses!'" :msg="'Kriteria baru berhasil ditambahkan'"></ssalert>

		<!-- update success alert -->
        <ssalert :alertClass="'alert-success'" :target="alert.update" :initMsg="'Sukses!'" :msg="'Data kriteria berhasil diperbarui'"></ssalert>

		<!-- Unable to delete -->
		<ssalert :alertClass="'alert-danger'" :target="alert.unableToDelete" :initMsg="'Error!'" :msg="'Silakan pilih kriteria yang ingin dihapus.'" />

      	<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="padding" v-if="showDaftarKriteria">
				<div class="row">
                    <div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h2>Kriteria Penilaian</h2>
							</div>
                            <div class="box-body">
								<div class="row">
									<div class="col-sm-6 col-xs-12">
                                        <button class="btn btn-fw white" @click="showForm('showFormAdd')"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
										<button class="btn btn-fw white" @click="multipleDeleteKriteria"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
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
										<input type="text" class="form-control" v-model="$store.state.cariKriteria" @keyup.enter="getKriteria(localLimit, 0, $store.state.cariKriteria)" placeholder="Cari kriteria (ketik dan enter)">
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
										<th>ID Kriteria</th>
										<th>Nama Kriteria</th>
										<th>Nilai Eigen</th>
										<th>Persentase</th>
										<th colspan="3" class="text-center">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(value, index) in kriteria">
										<td class="text-center">
											<label class="md-check"><input type="checkbox" v-model="$store.state.selectedID" :value="value.id_kriteria">
												<i class="primary"></i>
											</label>
										</td>
										<td>{{ value.id_kriteria }}</td>      
										<td class="nama-kriteria">{{ value.nama_kriteria }}</td>   
										<td>{{ value.eigen_value }}</td>
										<td>{{ persentase[index] }}%</td>
										<td class="text-center ss-cursor-pointer" @click="editKriteria(value.id_kriteria)"><i class="material-icons">edit</i></td>
										<td class="text-center ss-cursor-pointer" @click="showDeleteConfirm(value.id_kriteria)"><i class="material-icons">delete</i></td>
										<td class="text-center ss-cursor-pointer">
											<router-link :to="'/kriteria/input-perbandingan/'+ value.id_kriteria" tag="a"><i class="fa fa-th-large"></i></router-link>
										</td>
									</tr>
									<tr>
										<td colspan="3" class="text-center"><strong>JUMLAH</strong></td>
										<td><strong>{{ jumlahEigen }}</strong></td>
										<td><strong>{{ jumlahPersen }}%</strong></td>
									</tr>
								</tbody>
								<tfoot>
    								<td colspan="7" class="text-center">
    									<div class="col-sm-6 text-left">
    										<p> {{ $store.getters.getRowsRange }} </p>
    									</div>
    									<div class="col-sm-6 text-center">
    										<ul class="pagination pagination-sm m-a-0">
    											<li><a href="javascript:void(0)" @click="getKriteria(localLimit, paging('first'), cariKriteria)"><i class="material-icons">skip_previous</i></a></li>
    											<li><a href="javascript:void(0)" @click="getKriteria(localLimit, paging('prev'), cariKriteria)"><i class="material-icons">navigate_before</i></a></li>
    											<li>
    												<div class="col-xs-3">
    													<input type="text" class="form-control" v-model="$store.state.paging.setStart" @keyup.enter="getKriteria(localLimit, $store.state.paging.setStart - 1, cariKriteria)">
    												</div>
    											</li>
    											<li><a href="javascript:void(0)" @click="getKriteria(localLimit, paging('next'), cariKriteria)"><i class="material-icons">navigate_next</i></a></li>
    											<li><a href="javascript:void(0)" @click="getKriteria(localLimit, paging('last'), cariKriteria)"><i class="material-icons">skip_next</i></a></li>
												<li><a href="javascript:void(0)" @click="getKriteria(localLimit, ($store.getters.activePage - 1), cariKriteria)"><i class="material-icons">refresh</i></a></li>
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
								<p>Apakah anda yakin ingin menghapus kriteria yang dipilih?</p>
							</div>
							<div class="modal-footer">
								<button class="btn white" @click="closeDeleteConfirm">Cancel</button>
								<button class="btn primary" @click="deleteKriteria">OK</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</transition>
	  	<TambahKriteria/>
		<EditKriteria/>
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

import { Kriteria } from '../../../scripts/store/Kriteria'
import TambahKriteria from './TambahKriteria.vue'
import EditKriteria from './EditKriteria.vue'

export default {
    name: 'Kriteria',
    store: Kriteria,
    components: {
		TambahKriteria,
		EditKriteria,
    },
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getKriteria(10, 0, ''))
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
        getKriteria(limit, offset, search) {
            this.$store.dispatch('getKriteria', {
                limit, offset, search
            })
        },
		paging(param) {
			return this.$store.state.paging[param]
		},
        ...mapActions([
            'showPerPage', 'editKriteria', 'deleteKriteria',
			'multipleDeleteKriteria',
		]),
		...mapMutations([
			'showForm', 'closeDeleteConfirm', 'showDeleteConfirm',
			'selectAll',
		])
    },
    computed: {
        ...mapState([
            'kriteria', 'persentase', 'jumlahEigen', 'jumlahPersen', 
			'localLimit', 'selectedID',
			'showDaftarKriteria', 'alert', 'showFormAdd',
			'deleteConfirm', 'cariKriteria',
        ])
    }
}
</script>
