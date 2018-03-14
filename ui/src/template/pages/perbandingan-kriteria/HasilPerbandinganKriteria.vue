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
											<th>Nama Kriteria</th>
											<th v-for="(value, key, index) in hasilPerbandingan">K{{ index + 1}}</th>
                                            <th>Nilai Eigen</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(value, key, index) in hasilPerbandingan">
											<td class="nama-kriteria">
												{{ key }} (K{{ index + 1 }})
											</td>
											<td v-for="value in hasilPerbandingan[key]['angka']">
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

import { PerbandinganKriteria } from '../../../scripts/store/PerbandinganKriteria'

export default {
    name: 'HasilPerbandinganKriteria',
    store: PerbandinganKriteria,
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
            this.$store.dispatch('getComparisonResult')
        },
		close() {
			this.$router.push('/kriteria/perbandingan')
		},
        ...mapActions([
            
		]),
		...mapMutations([
			
		])
    },
    computed: {
        ...mapState([
            'eigen', 'hasilPerbandingan', 'CR', 'konsistensi',
        ])
    }
}
</script>
