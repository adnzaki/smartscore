<template>
    <div>
      	<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="padding">
				<div class="row">
                    <div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h2>Prioritas Solusi</h2>
							</div>
                            <div class="box-body">
								<div class="row">
									<div class="col-xs-12">
										<router-link to="/alternatif/perbandingan" tag="a" class="btn btn-fw white"><i class="material-icons">compare</i>&nbsp; Perbandingan</router-link>
										<a class="btn btn-fw white" :href="$store.state.shared.apiUrl+'cetak-hasil'" target="_blank"><i class="fa fa-print"></i>&nbsp; Cetak</a>
									</div>
								</div>
                            </div>
                            <table class="table table-striped b-t">
								<thead>
									<tr>
										<th>Nama Siswa</th>
										<th v-for="(value, key, index) in prioritasSolusi['eigenKriteria']">K{{ index + 1}} </th>
                                        <th class="text-center">Jumlah</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(value, key, index) in prioritasSolusi['nilaiAlternatif']">
										<td class="nama-kriteria">{{ key }}</td>   
										<td v-for="item in prioritasSolusi['nilaiAlternatif'][key]['nilaiKriteria']">{{ item }}</td>
                                        <td class="text-center"><strong>{{ prioritasSolusi['nilaiAlternatif'][key]['jumlah'] }}</strong></td>
									</tr>
									<tr>
										<td :colspan="jumlahColspan + 1"><strong><i>JUMLAH</i></strong></td>
										<td class="text-center"><strong><i>{{ prioritasSolusi['jumlahNilaiAkhir'] }}</i></strong></td>
									</tr>
								</tbody>
							</table>
                            <div class="box-body">
								<div class="row">
									<div class="col-xs-12">
                                        <p v-if="prioritasSolusi['jumlahNilaiAkhir'] !== '0.000'">Siswa yang direkomendasikan menjadi siswa terbaik: <b class="text-yellow">{{ siswaTertinggi }}</b> dengan nilai <b class="text-yellow">{{ nilaiTertinggi }}</b></p>
										<p :class="noteClass">Keterangan:<br>{{ prioritasSolusi['keterangan'] }}</p>
									</div>
								</div>
                            </div> 
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
    name: 'PrioritasSolusi',
    store: PerbandinganAlternatif,
    components: {
    },
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getPrioritasSolusi())
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
		getPrioritasSolusi() {
			this.$store.dispatch('getPrioritasSolusi')
		},  
        ...mapActions([
            
		]),
		...mapMutations([
			
		])
    },
    computed: {
        ...mapState([
            'prioritasSolusi',
        ]),
		jumlahColspan() {
			if(this.prioritasSolusi['eigenKriteria'] !== undefined) {
				return Object.keys(this.prioritasSolusi['eigenKriteria']).length
			}
		},
		noteClass() {
			if(this.prioritasSolusi['inconsistentCR'] > 0 || this.prioritasSolusi['jumlahNilaiAkhir'] === '0.000') {
				return 'text-red'
			} else {
				return 'text-green'
			}
		},
		nilaiTertinggi() {
			if(this.prioritasSolusi['nilaiTertinggi'] !== undefined) {
				return this.prioritasSolusi['nilaiTertinggi']['nilai']
			} 				
		},
		siswaTertinggi() {
			if(this.prioritasSolusi['nilaiTertinggi'] !== undefined) {
				return this.prioritasSolusi['nilaiTertinggi']['siswa']
			}
		},
    }
}
</script>
