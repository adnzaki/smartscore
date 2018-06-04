<template>
  <div>
      <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="padding">
				<div class="row">
                    <div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h2>Perbandingan Kriteria</h2>								
							</div>     
							<div class="box-body">
								<div class="row">
									<div class="col-xs-12">
										<router-link to="/kriteria/perbandingan/hasil" tag="a" class="btn btn-fw white"><i class="fa fa-search"></i>&nbsp; Lihat Hasil</router-link>
									</div>
								</div>
                            </div>
							<div class="table-responsive">
								<table class="table table-striped b-t">
									<thead>
										<tr>										
											<th>Nama Kriteria</th>
											<th v-for="(value, key, index) in kriteria" v-bind:key="key">K{{ index + 1}}</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(value, key, index) in kriteria" v-bind:key="key" v-if="hasData">										
											<td class="nama-kriteria">
												<router-link :to="'/kriteria/perbandingan/input/'+ kriteria[key][0].id_kriteria" tag="a">{{ key }} (K{{ index + 1 }})</router-link>
											</td>
											<td v-for="value in kriteria[key]">
												{{ value.nilai_perbandingan }}
											</td>
										</tr>
										<tr v-for="(item, index) in daftarKriteria" v-if="hasData === false">										
											<td class="nama-kriteria">
												<router-link :to="'/kriteria/perbandingan/input/'+ item.id_kriteria" tag="a">
													{{ item.nama_kriteria }}
												</router-link>
											</td>
										</tr>
										<tr>
											<td><strong><i>JUMLAH</i></strong></td>
											<td v-for="value in jumlahKolom"><strong><i>{{ value }}</i></strong></td>
										</tr>
									</tbody>
								</table>
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
    name: 'PerbandinganKriteria',
    store: PerbandinganKriteria,
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getPerbandinganKriteria())
	},
	beforeRouteUpdate(to, from, next) {
		this.getPerbandinganKriteria()
		next()
	},
	beforeRouteLeave(to, from, next) {
		this.getPerbandinganKriteria()
		next()
	},
    data() {
        return {}
    },
    methods: {
        getPerbandinganKriteria() {
            this.$store.dispatch('getPerbandinganKriteria')
			this.$store.dispatch('getDaftarKriteria')
        },
        ...mapActions([
            
		]),
		...mapMutations([
			
		])
    },
    computed: {
        ...mapState([
            'kriteria', 'jumlahKolom', 'hasData', 'daftarKriteria',
        ])
    }
}
</script>
