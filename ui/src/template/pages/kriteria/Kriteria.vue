<template>
  <div>
  		<!-- insert success alert -->
        <ssalert :alertClass="'alert-success'" :target="alert.insert" :initMsg="'Sukses!'" :msg="'Kriteria baru berhasil ditambahkan'"></ssalert>

		<!-- update success alert -->
        <ssalert :alertClass="'alert-success'" :target="alert.update" :initMsg="'Sukses!'" :msg="'Data kriteria berhasil diperbarui'"></ssalert>
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
										<button class="btn btn-fw white"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
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
										<input type="text" class="form-control" v-model="$store.state.cariKriteria" @keyup.enter="getKriteria(localLimit, 0, $store.state.cariKriteria)" placeholder="Cari siswa (ketik dan enter)">
									</div>
								</div>
                            </div>
                            <table class="table table-striped b-t">
								<thead>
									<tr>
										<th class="text-center">
											<label class="md-check"><input type="checkbox">
												<i class="primary"></i>
											</label>
    									</th>
										<th>ID Kriteria</th>
										<th>Nama Kriteria</th>
										<th>Nilai Eigen</th>
										<th colspan="3" class="text-center">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="value in kriteria">
										<td class="text-center">
											<label class="md-check"><input type="checkbox" v-model="$store.state.selectedID" :value="value.id_kriteria">
												<i class="primary"></i>
											</label>
										</td>
										<td>{{ value.id_kriteria }}</td>      
										<td class="nama-kriteria">{{ value.nama_kriteria }}</td>   
										<td>{{ value.eigen_value }}</td>                                     
										<td class="text-center ss-cursor-pointer"><i class="material-icons">edit</i></td>
										<td class="text-center ss-cursor-pointer"><i class="material-icons">delete</i></td>
										<td class="text-center ss-cursor-pointer"><i class="fa fa-th-large"></i></td>
									</tr>
								</tbody>
								<tfoot>
    								<td colspan="7" class="text-center">
    									<div class="col-sm-6 text-left">
    										<p> {{ $store.getters.getRowsRange }} </p>
    									</div>
    									<div class="col-sm-6 text-center">
    										<ul class="pagination pagination-sm m-a-0">
    											<li><a href="javascript:void(0)" @click="getKriteria(localLimit, paging('first'))"><i class="material-icons">skip_previous</i></a></li>
    											<li><a href="javascript:void(0)" @click="getKriteria(localLimit, paging('prev'))"><i class="material-icons">navigate_before</i></a></li>
    											<li>
    												<div class="col-xs-3">
    													<input type="text" class="form-control" v-model="$store.state.paging.setStart" @keyup.enter="getKriteria(localLimit, $store.state.paging.setStart - 1)">
    												</div>
    											</li>
    											<li><a href="javascript:void(0)" @click="getKriteria(localLimit, paging('next'))"><i class="material-icons">navigate_next</i></a></li>
    											<li><a href="javascript:void(0)" @click="getKriteria(localLimit, paging('last'))"><i class="material-icons">skip_next</i></a></li>
												<li><a href="javascript:void(0)" @click="getKriteria(localLimit, ($store.getters.activePage - 1))"><i class="material-icons">refresh</i></a></li>
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
	  	<TambahKriteria/>
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
import ssalert from '../../../template/content/alert.vue'
import { sserror } from '../../../scripts/modules/Shared'

export default {
    name: 'Kriteria',
    store: Kriteria,
    components: {
		TambahKriteria,
		sserror,
		ssalert,
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
            'showPerPage'
		]),
		...mapMutations([
			'showForm'
		])
    },
    computed: {
        ...mapState([
            'kriteria', 'localLimit', 'selectedID',
			'showDaftarKriteria', 'alert', 'showFormAdd'
        ])
    }
}
</script>
