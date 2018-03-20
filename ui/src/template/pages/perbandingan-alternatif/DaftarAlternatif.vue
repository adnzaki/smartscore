<template>
  <div>
      <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="padding">
				<div class="row">
                    <div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h2>Daftar Alternatif</h2>
							</div>   
                            <div class="box-body">
								<div class="row">									
                                    <div class="col-xs-12">
										<button class="btn btn-fw white"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
										<router-link to="/alternatif/perbandingan" tag="a" class="btn btn-fw white"><i class="material-icons">compare</i>&nbsp; Perbandingan</router-link>
									</div>
								</div>
                            </div>                         
                            <table class="table table-striped b-t">
								<thead>
									<tr>										
										<th>Nama Siswa</th>
                                        <th class="text-center">Nilai Akhir</th>
										<th class="text-center">Persentase</th>
										<th class="text-center">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="item in daftarAlternatif">										
										<td class="nama-kriteria">{{ item.nama_siswa }}</td>
                                        <td class="text-center">0</td>
										<td class="text-center">10%</td>
										<td class="text-center ss-cursor-pointer"><i class="fa fa-th-large"></i></td>
									</tr>
								</tbody>
							</table>
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

import { PerbandinganAlternatif } from '../../../scripts/store/PerbandinganAlternatif'

export default {
    name: 'DaftarAlternatif',
    store: PerbandinganAlternatif,
    components: {
    },
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getDaftarAlternatif())
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
        getDaftarAlternatif() {
			this.$store.dispatch('getDaftarAlternatif')
        },
        ...mapActions([
            
		]),
		...mapMutations([
			
		])
    },
    computed: {
        ...mapState([
            'daftarAlternatif',
        ])
    }
}
</script>
