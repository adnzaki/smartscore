<template>
  <div>
	<!-- unable to get result -->
	<ssalert :alertClass="'alert-danger'" :target="alert.unableToGetResult" :initMsg="'Error!'" :msg="'Silakan pilih kriteria terlebih dahulu'" />
      <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="padding">
				<div class="row">
                    <div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h2>Perbandingan Alternatif</h2>
							</div>   
                            <div class="box-body">
								<div class="row">
									<div class="col-sm-4 col-xs-12">
                                        <div class="form-group row">
											<label for="" class="col-sm-4 form-control-label">Pilih Kriteria</label>
											<div class="col-sm-8 col-xs-12">
												<select class="form-control" v-model="$store.state.pilihKriteria" @change="getPerbandinganAlternatif">
	    											<option v-for="item in kriteria" :value="item.id_kriteria" class="text-black">{{ item.nama_kriteria }}</option>
	    										</select>
											</div>
										</div>
									</div>
                                    <div class="col-sm-8 col-xs-12" v-if="hasData && showResultButton">
										<a class="btn btn-fw white" @click="lihatHasil"><i class="fa fa-search"></i>&nbsp; Lihat Hasil</a>
										<router-link to="/alternatif/prioritas-solusi" tag="a" class="btn btn-fw white"><i class="fa fa-check"></i>&nbsp; Prioritas Solusi</router-link>
									</div>
									<div class="col-sm-8 col-xs-12" v-else>
										<button class="btn btn-fw white" disabled><i class="fa fa-search"></i>&nbsp; Lihat Hasil</button>
										<button class="btn btn-fw white" disabled><i class="fa fa-check"></i>&nbsp; Prioritas Solusi</button>
									</div>
								</div>
                            </div>                         
                            <table class="table table-striped b-t">
								<thead>
									<tr>										
										<th>Nama Siswa</th>
                                        <th v-for="(item, index) in daftarAlternatif">A{{ index + 1}}</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(value, key, index) in alternatif" v-if="hasData">										
										<td class="nama-kriteria">
											<router-link :to="'/alternatif/perbandingan/input/'+ pilihKriteria + '/' + daftarAlternatif[index].id_siswa" tag="a">
												{{ key }} (A{{ index + 1 }})
											</router-link>
										</td>
                                        <td v-for="value in daftarAlternatif">
											{{ getNilaiPerbandingan(daftarAlternatif[index].id_siswa, value.id_siswa, pilihKriteria) }}
										</td>
									</tr>
									<tr v-for="(item, index) in daftarAlternatif" v-if="hasData === false">
										<td class="nama-kriteria" v-if="pilihKriteria !== ''">
											<router-link :to="'/alternatif/perbandingan/input/'+ pilihKriteria + '/' + item.id_siswa" tag="a">
												{{ item.nama_siswa }} (A{{ index + 1 }})
											</router-link>
										</td>
										<td class="nama-kriteria" v-else>
											{{ item.nama_siswa }} (A{{ index + 1 }})
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
      </transition>
	  <!-- Progress saat menyimpan... -->
		<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="modal ss-modal" data-backdrop="true" v-if="loadProgress">
				<div class="modal-dialog">
					<div class="col-sm-8 offset-sm-2">
						<div class="modal-content black lt m-b">
							<div class="modal-header">
								<h5 class="modal-title">Mohon Tunggu</h5>
							</div>
							<div class="modal-body">
								<p>Mengambil data perbandingan...</p>
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
    name: 'PerbandinganAlternatif',
    store: PerbandinganAlternatif,
    components: {
    },
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getKriteria())
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
        getKriteria() {
            this.$store.dispatch('getKriteria')	
			this.$store.dispatch('getDaftarAlternatif')		
			this.$store.dispatch('getPerbandinganAlternatif')	
        },
		lihatHasil() {
			if(this.pilihKriteria === '') {
				this.$store.commit('showAlert', 'unableToGetResult')
			} else {
				this.$router.push(`/alternatif/perbandingan/hasil/${this.pilihKriteria}`)
			}
		},
		getNilaiPerbandingan(siswa, pembanding, kriteria) {
			let key = `${siswa}-${pembanding}-${kriteria}`
			return this.nilaiPerbandingan.hasOwnProperty(key)
					? this.nilaiPerbandingan[key]
					: '-'
		},
        ...mapActions([
            'getPerbandinganAlternatif'
		]),
		...mapMutations([
			
		])
    },
    computed: {
        ...mapState([
            'alternatif', 'kriteria', 'pilihKriteria', 'daftarAlternatif',
			'hasData', 'alert', 'jumlahKolom', 'loadProgress', 'nilaiPerbandingan',
        ]),
		...mapGetters(['showResultButton'])		
    }
}
</script>
