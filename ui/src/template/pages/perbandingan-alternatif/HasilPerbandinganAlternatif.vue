<template>
  <div>
      <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="padding">
				<div class="row">
                    <div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h2>Hasil Perbandingan</h2>								
							</div>     
							<div class="box-body">
								<div class="row">
									<div class="col-xs-12">
										<button class="btn btn-fw white" @click="close"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali ke Perbandingan</button>
									</div>
								</div>
                            </div>
							<div class="table-responsive">
								<table class="table table-striped b-t">
									<thead>
										<tr>										
											<th>Nama Siswa</th>
											<th v-for="(value, key, index) in hasilPerbandingan">A{{ index + 1}}</th>
                                            <th>Nilai Eigen</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(value, key, index) in hasilPerbandingan">
											<td class="nama-kriteria">
												{{ key }} (A{{ index + 1 }})
											</td>
											<td v-if="hasilPerbandingan[key]['angka'].length === panjangHasil"
											 v-for="value in hasilPerbandingan[key]['angka']">
												{{ value }}
											</td> 
											<td v-else 
											 v-for="value in hasilPerbandingan[key]['angka']"
											 :colspan="(panjangHasil - hasilPerbandingan[key]['angka'].length) + hasilPerbandingan[key]['angka'].length">
												{{ value }}
											</td> 
                                            <td><strong>{{ value['eigen'] }}</strong></td>
										</tr>
									</tbody>
								</table>
							</div>                              
							<div class="box-body">
								<div class="row">
									<div class="col-xs-12">
                                        <p>Rasio Konsistensi: {{ CR }} ({{ konsistensi }})</p>
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
    name: 'HasilPerbandinganAlternatif',
    store: PerbandinganAlternatif,
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getComparisonResult())
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
        getComparisonResult() {
            this.$store.dispatch('getComparisonResult', this.$route.params.kriteriaID)
        },
		close() {
			this.$router.push('/alternatif')
		},
        ...mapActions([
            
		]),
		...mapMutations([
			
		])
    },
    computed: {
        ...mapState([
            'eigen', 'hasilPerbandingan', 'CR', 'konsistensi',
        ]),
		panjangHasil() {
			let arr = Object.keys(this.hasilPerbandingan)
			return arr.length
		}
    }
}
</script>
