<template>
  <div>
      <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
			<div class="padding">
				<div class="row">
                    <div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h2>Kriteria Penilaian</h2>
							</div>
                            <div class="box-body">
								<div class="row">
									<div class="col-sm-6 col-xs-12">
                                        <button class="btn btn-fw white"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
										<button class="btn btn-fw white"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
									</div>
                                    <div class="col-sm-3 col-xs-12">
										<div class="form-group row">
											<label for="" class="col-sm-3 form-control-label">Tampilkan</label>
											<div class="col-sm-9">
												<select class="form-control" v-model="$store.state.jmlBaris" v-on:change="showPerPage">
	    											<option value="10" class="text-black">10 baris</option>
	    											<option value="25" class="text-black">25 baris</option>
	    											<option value="50" class="text-black">50 baris</option>
	    											<option value="100" class="text-black">100 baris</option>
	    											<option value="250" class="text-black">250 baris</option> 
	    										</select>
											</div>
										</div>
									</div>
                                    <div class="col-sm-3 col-xs-12">
										<input type="text" class="form-control" v-model="$store.state.cariKriteria" @keyup.enter="getKriteria(localLimit, 0, $store.state.cariKriteria)" placeholder="Cari siswa (ketik dan enter)">
									</div>
								</div>
                            </div>
                            <table class="table table-striped b-t">
								<thead>
									<tr>
										<th class="text-center">
											<label class="md-check"><input type="checkbox">
												<i class="primary"></i>
											</label>
    									</th>
										<th>Nama Kriteria</th>
                                        <th v-for="(value, key, index) in kriteria" v-bind:key="key">K{{ index + 1}}</th>
										<th colspan="2" class="text-center">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(value, key, index) in kriteria" v-bind:key="key">
										<td class="text-center">
											<label class="md-check"><input type="checkbox" v-model="$store.state.selectedID" :value="value[0].id_kriteria">
												<i class="primary"></i>
											</label>
										</td>
										<td>{{ key }} (K{{ index + 1 }})</td>
                                        <td v-for="value in kriteria[key]">{{ value.nilai_perbandingan }}</td>
										<td class="text-center ss-cursor-pointer"><i class="material-icons">edit</i></td>
										<td class="text-center ss-cursor-pointer"><i class="material-icons">delete</i></td>
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

import { Kriteria } from '../../../scripts/store/Kriteria'
import ssalert from '../../../template/content/alert.vue'
import { sserror } from '../../../scripts/modules/Shared'

export default {
    name: 'Kriteria',
    store: Kriteria,
    components: {
		sserror,
		ssalert,
    },
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getKriteria(10, 0, ''))
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
        getKriteria(limit, offset, search) {
            this.$store.dispatch('getKriteria', {
                limit, offset, search
            })
        },
        ...mapActions([
            'showPerPage'
        ])
    },
    computed: {
        ...mapState([
            'kriteria', 'localLimit', 'selectedID'
        ])
    }
}
</script>
