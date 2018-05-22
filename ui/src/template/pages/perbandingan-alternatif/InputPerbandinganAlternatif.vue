<template>  
    <div>
		<!-- saving successfully -->
        <ssalert :alertClass="'alert-success'" :target="alert.successSave" :initMsg="'Sukses!'" :msg="'Data perbandingan kriteria berhasil disimpan'"></ssalert>
		<!-- error saving data -->
		<ssalert :alertClass="'alert-danger'" :target="alert.errorSave" :initMsg="'Error!'" :msg="'Tidak dapat menyimpan data perbandingan. Silakan isi skala perbandingan dengan benar'" />
		<div class="padding">
			<div class="row">
				<div class="col-sm-12">
					<div class="box">	
						<div class="box-header">
								<h2>Input Perbandingan untuk Alternatif: {{ namaAlternatif }}</h2>								
							</div>   
						<div class="box-body">
							<div class="row">
								<div class="col-xs-12">
									<button class="btn btn-fw white" @click="save"><i class="fa fa-save"></i>&nbsp; Simpan</button>
									<router-link :to="'/alternatif/perbandingan/hasil/'+ $route.params.kriteriaID" tag="a" class="btn btn-fw white" v-if="hasData && showResultButton"><i class="fa fa-search"></i>&nbsp; Lihat Hasil</router-link>
									<button class="btn btn-fw white" disabled v-else><i class="fa fa-search"></i>&nbsp; Lihat Hasil</button>
									<button class="btn btn-fw white" @click="close"><i class="fa fa-close"></i>&nbsp; Tutup</button>
								</div>
							</div>
						</div>
						<form id="formPerbandinganAlternatif">
							<input type="hidden" v-model="dataQuery" name="nilai-perbandingan">
						</form>
						<div class="table-responsive">
							<table class="table table-striped b-t">
								<thead>
									<tr>										
										<th>Nama Alternatif (ID)</th>
										<th>Skala Perbandingan</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="item in alternatifToCompare">										
										<td class="nama-kriteria decrease-td-padding">{{ item.nama_siswa }} ({{ item.id_daftar_alternatif }}) </td>    
										<td class="decrease-td-padding">
											<ul class="pagination pagination-sm m-a-0">
												<li v-for="nilai in nilaiPerbandingan" :class="[isActive(item.id_siswa, nilai.value)]">
													<a href="javascript:void(0)" class="decrease-paging-line-height" @click="setValue(item.id_siswa, nilai.value)">{{ nilai.text }}</a>
												</li>
											</ul>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Progress saat menyimpan... -->
						<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
							<div class="modal ss-modal" data-backdrop="true" v-if="saveProgress">
								<div class="modal-dialog">
									<div class="col-sm-8 offset-sm-2">
										<div class="modal-content black lt m-b">
											<div class="modal-header">
												<h5 class="modal-title">Mohon Tunggu</h5>
											</div>
											<div class="modal-body">
												<p>Menyimpan data perbandingan...</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</transition>				
					</div>
				</div>
			</div>
		</div>
        
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
    name: 'InputPerbandinganAlternatif',
    store: PerbandinganAlternatif,
    components: {
    },
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getAlternatifToCompare())
	},
	beforeRouteUpdate(to, from, next) {
		next()
	},
	beforeRouteLeave(to, from, next) {
		next()
	},
	mounted() {
	},
    data() {
        return {
			nilaiPerbandingan: [
				{ value: '1.00', text: '1' }, { value: '2.00', text: '2' }, { value: '3.00', text: '3' },
				{ value: '4.00', text: '4' }, { value: '5.00', text: '5' }, { value: '6.00', text: '6' },
				{ value: '7.00', text: '7' }, { value: '8.00', text: '8' }, { value: '9.00', text: '9' },
				{ value: '0.50', text: '1/2' }, { value: '0.33', text: '1/3' }, { value: '0.25', text: '1/4' }, 
				{ value: '0.20', text: '1/5' }, { value: '0.16', text: '1/6' }, { value: '0.14', text: '1/7' },
				{ value: '0.13', text: '1/8' }, { value: '0.11', text: '1/9' },
			],
			dataToSend: [], dataQuery: '',
		}
    },
    methods: {
        getAlternatifToCompare() {
            this.$store.dispatch('getAlternatifToCompare', this.$route.params.siswaID)
			this.$store.dispatch('getAlternatifName', this.$route.params.siswaID)
        },
		save() {
			if(this.dataToSend.length === 0) {
				this.$store.commit('showAlert', 'errorSave')
			} else {
				this.$store.dispatch('save', this.$route.params.kriteriaID)
			}
		},
		setValue(siswa, value) {
			var data = this.dataToSend
			
            // filter data yang sudah ada agar tidak masuk ke dalam 
            // {this.dataToSend} lagi
			var filtered = data.filter(key => key.siswaID !== siswa)

            // masukkan data baru ke dalam {this.dataToSend}
			filtered.push({
				siswaID: siswa,
				value: value,
			})

			this.dataToSend = filtered
			this.setQuery()
		},
		setQuery() {
			var len = this.dataToSend.length
			var wrapper = []
			for(let i = 0; i < len; i++) {
				var str = `${this.$route.params.siswaID}+${this.dataToSend[i].siswaID}+${this.dataToSend[i].value}`
				wrapper.push(str)
			}
			this.dataQuery = wrapper.join('-')
		},
		isActive(siswa, value) {
			var data = this.dataToSend
			if(data.length !== 0) {
				for(let i = 0; i < data.length; i++) {
					if(data[i].siswaID === siswa && data[i].value === value) {
						return 'active'
					}
				}
			}
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
            'alternatifToCompare', 'saveProgress', 'alert', 'namaAlternatif',
			'hasData'
        ]),
		...mapGetters(['showResultButton'])	
    }
}
</script>
