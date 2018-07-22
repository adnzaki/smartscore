<template lang="html">
  <div>
      <div class="padding">
		<div class="row">
			<div class="col-xs-12 col-sm-4">
				<div class="box p-a">
					<div class="pull-left m-r">
						<span class="w-48 rounded  accent">
							<i class="material-icons">filter_1</i>
						</span>
					</div>
					<div class="clear">
						<h4 class="m-a-0 text-lg _300"><a href="javascript:void()">{{ nilaiTerbaik }}% <span class="text-sm">{{ siswaTerbaik }}</span></a></h4>
						<small class="text-muted">Rekomendasi Siswa Terbaik</small>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4">
				<div class="box p-a">
					<div class="pull-left m-r">
						<span class="w-48 rounded primary">
							<i class="material-icons">people</i>
						</span>
					</div>
					<div class="clear">
						<h4 class="m-a-0 text-lg _300"><a href="javascript:void()">{{ ringkasan.alternatif }} <span class="text-sm">Alternatif</span></a></h4>
						<small class="text-muted">Nominasi Siswa Terbaik</small>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4">
				<div class="box p-a">
					<div class="pull-left m-r">
						<span class="w-48 rounded warn">
							<i class="material-icons">&#xe8d3;</i>
						</span>
					</div>
					<div class="clear">
						<h4 class="m-a-0 text-lg _300"><a href="javascript:void()">{{ ringkasan.onlineUser }} <span class="text-sm">Online</span></a></h4>
						<small class="text-muted">Pengguna lain yang sedang masuk aplikasi</small>
					</div>
				</div>
			</div>
		</div>
		<!-- batasssss -->
		<div class="row">
			<div class="col-sm-12 col-md-7">
				<div class="box">
					<div class="box-header">
						<h3><b>DATA SEKOLAH</b></h3>
					</div>
					<ul class="list no-border p-b">
						<data-sekolah name="Nama Sekolah" :value="dataSekolah.nama" />
						<data-sekolah name="NPSN" :value="dataSekolah.npsn" />
						<data-sekolah name="Kepala Sekolah" :value="dataSekolah.kepsek" />
						<data-sekolah name="Alamat" :value="dataSekolah.alamat" />
						<data-sekolah name="Kelurahan, Kecamatan" :value="dataSekolah.kelurahan+', '+dataSekolah.kecamatan" />
						<data-sekolah name="Kab/Kota, Provinsi" :value="dataSekolah.kota+', '+dataSekolah.provinsi" />
					</ul>
				</div>
			</div>
			
			<div class="col-sm-12 col-md-5">
				<div class="box">
					<div class="box-header">
						<h3>Tiga Besar Alternatif</h3>
						<small>Alternatif dengan nilai tertinggi.</small>
					</div>
					<div class="box-body">
						<div class="streamline b-l m-b m-l">
							<div class="sl-item" v-for="item in tigaBesar.slice(0, 3)">
								<div class="sl-left">
									<div class="pull-left m-r">
										<span class="w-48 rounded green">
											<i class="material-icons">dvr</i>
										</span>
									</div>								
								</div>
								<div class="sl-content">
									<a href class="text-info">{{ item.namaSiswa }}</a><span class="m-l-sm sl-date">NISN: {{ item.nisn }}</span>
									<div>Mendapatkan nilai: <a href class="text-info">{{ item.jumlah }}</a>.</div>
								</div>
							</div>
						</div>
					</div>
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
import { Dashboard } from '../../../scripts/store/Dashboard'
import DataSekolah from '../../content/DataSekolah.vue'

Vue.use(Vuex)

export default {
	name: 'Dashboard',
	store: Dashboard,
	components: {
		'data-sekolah': DataSekolah,
	},
	beforeRouteEnter(to, from, next) {
		next(vm => vm.getData())
	},
	beforeRouteUpdate(to, from, next) {
		this.getData()
		next()
	},
	beforeRouteLeave(to, from, next) {		
		next()
	},
	data() {
		return {
			dataSekolah: {
				nama: 'SDN Pengasinan VII',
				npsn: '20231526',
				nss: '1010265',
				kepsek: 'NURHASAN EFFENDI, S.Pd.',
				alamat: 'Jl. Telaga Sarangan I Perum Bumi Bekasi Baru Utara',
				kelurahan: 'Pengasinan',
				kecamatan: 'Rawalumbu',
				kota: 'Bekasi',
				provinsi: 'Jawa Barat'
			}
		}
	},
	methods: {
		...mapMutations([

		]),
		...mapActions([
			
		]),
		getData() {
			this.$store.dispatch('getData')
		}
	},
	computed: {
		...mapState([
			'pesan', 'ringkasan', 'tigaBesar'
		]),
		siswaTerbaik() {
			return localStorage.getItem('siswaTerbaik')
		},
		nilaiTerbaik() {
			let nilai = localStorage.getItem('nilaiTerbaik') * 100
			nilai = nilai.toString()
			return nilai.substr(0, 4)
		}
	}
}
</script>