<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
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
						<div class="box-body">
							<div class="row">
								<div class="col-xs-12">
									<button class="btn btn-fw white" @click="save"><i class="fa fa-save"></i>&nbsp; Simpan</button>
									<router-link to="/kriteria/perbandingan/hasil" tag="a" class="btn btn-fw white"><i class="fa fa-search"></i>&nbsp; Lihat Hasil</router-link>
									<button class="btn btn-fw white" @click="close"><i class="fa fa-close"></i>&nbsp; Tutup</button>
								</div>
							</div>
						</div>
						<form id="formPerbandinganKriteria">
							<input type="hidden" v-model="dataQuery" name="nilai-perbandingan">
						</form>
						<div class="table-responsive">
							<table class="table table-striped b-t">
								<thead>
									<tr>										
										<th>Nama Kriteria</th>
										<th>Skala Perbandingan</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="item in kriteriaToCompare">										
										<td class="nama-kriteria decrease-td-padding">{{ item.nama_kriteria }}</td>    
										<td class="decrease-td-padding">
											<ul class="pagination pagination-sm m-a-0">
												<li v-for="nilai in nilaiPerbandingan" :class="[isActive(item.id_kriteria, nilai.value)]">
													<a href="javascript:void(0)" class="decrease-paging-line-height" @click="setValue(item.id_kriteria, nilai.value)">{{ nilai.text }}</a>
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
import { PerbandinganKriteria } from '../../../scripts/store/PerbandinganKriteria'
import { sserror } from '../../../scripts/modules/Shared'

export default {
    name: 'InputPerbandinganKriteria',
    store: PerbandinganKriteria,
    components: {
    },
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getKriteriaToCompare())
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
			columnSum: [], test: [],
			dataToSend: [], dataQuery: '',
		}
    },
    methods: {
        getKriteriaToCompare() {
            this.$store.dispatch('getKriteriaToCompare', this.$route.params.kriteriaID)
        },
		save() {
			if(this.dataToSend.length === 0) {
				this.$store.commit('showAlert', 'errorSave')
			} else {
				this.$store.dispatch('save')
			}
		},
		setValue(kriteria, value) {
			var data = this.dataToSend
			
			var filtered = data.filter(function(key) { 
				return key.kriteriaID !== kriteria;
			})	

			filtered.push({
				kriteriaID: kriteria,
				value: value,
			})

			this.dataToSend = filtered
			this.setQuery()
		},
		setQuery() {
			var len = this.dataToSend.length
			var wrapper = []
			for(let i = 0; i < len; i++) {
				var str = `${this.$route.params.kriteriaID}+${this.dataToSend[i].kriteriaID}+${this.dataToSend[i].value}`
				wrapper.push(str)
			}
			this.dataQuery = wrapper.join('-')
		},
		isActive(kriteria, value) {
			var data = this.dataToSend
			//var result

			if(data.length !== 0) {
				const result = data.find(function(key) {
					return key.kriteriaID === kriteria && key.value === value
				})

				// const result = data.find(searchObject)
				// const result = { value: value }
				// if(result === undefined) {
				// 	result = { value: value }
				// }

				// if(result.value === value) {
				// 	//console.log('active')
				// 	return 'active'
				// } else {
				// 	//console.log(null)
				// 	return ''
				// }
				//return 'active'
				//return result[value]
				// if(result === undefined) {
				// 	var result = 'active'
				// }
				var eek = result
				console.log(data)
			} 
			//return result
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
            'kriteriaToCompare', 'saveProgress', 'alert',
        ])
    }
}
</script>
