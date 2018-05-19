<template>
    <div>
        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
            <div class="padding">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-header">
                                <h2>{{ detailArsip.nama_arsip }}</h2>								
                            </div>     
                            <div class="box-body">
								<div class="row">
									<div class="col-xs-12">
										<button class="btn btn-fw white" @click="kembali"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</button>
                                        <a class="btn btn-fw white" :href="$store.state.shared.apiUrl+'cetak-arsip/'+detailArsip.id_arsip+'/'+token" target="_blank"><i class="fa fa-print"></i>&nbsp; Cetak</a>
									</div>
								</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped b-t">
                                    <thead>
                                        <tr>										
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>NIS / NISN</th>
                                            <th>Nilai Akhir</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in arsipNilai">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ item.nama_siswa }}</td>
                                            <td>{{ item.nis_nisn }}</td>
                                            <td>{{ item.nilai_akhir }}</td>
                                            <td>{{ item.persentase }} %</td>
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

import { Pengaturan } from '../../../scripts/store/Pengaturan'

export default {
    name: 'Pengaturan',
    store: Pengaturan,
    components: {

    },
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getArsipNilai())
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
        ...mapActions([
            
		]),
		...mapMutations([
			
		]),
        getArsipNilai() {
            this.$store.dispatch('getArsipNilai', this.$route.params.idArsip)
        },
        kembali() {
            this.$router.push('/pengaturan')
        }
    },
    computed: {
        ...mapState([
            'arsipNilai', 'detailArsip', 'token',
        ])
    }
}
</script>
