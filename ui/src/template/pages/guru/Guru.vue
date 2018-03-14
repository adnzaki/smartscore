<<template lang="html">
    <div>
        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
            <div class="padding" v-if="showDaftarGuru">
                <div class="row">
    				<div class="col-sm-12">
    					<div class="box">
    						<div class="box-header">
    							<h2>Data Guru</h2>
    						</div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <button class="btn btn-fw white" @click=""><i class="fa fa-plus"></i>&nbsp; Tambah</button>
                                        <button class="btn btn-fw white" @click=""><i class="fa fa-trash"></i>&nbsp; Hapus</button>
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
										<input type="text" class="form-control" v-model="$store.state.cariGuru" @keyup.enter="getGuru(localLimit, 0, $store.state.cariGuru)" placeholder="Cari guru (ketik dan enter)">
									</div>
                                </div>
                            </div>
                            <table class="table table-striped b-t">
								<thead>
									<tr>
										<th class="text-center">
											<label class="md-check"><input type="checkbox" @click="">
												<i class="primary"></i>
											</label>
    									</th>
										<th>Nama Guru</th>
										<th>Jenis Kelamin</th>
										<th>Tempat Lahir</th>
										<th>Tanggal Lahir</th>
										<th colspan="2" class="text-center">Aksi</th>
									</tr>
								</thead>
                                <tbody>
									<tr v-for="list in daftarGuru">
										<td class="text-center">
											<label class="md-check"><input type="checkbox" v-model="$store.state.selectedID" :value="list.id_guru">
												<i class="primary"></i>
											</label>
										</td>
										<td>{{ list.nama_guru }}</td>
										<td>{{ list.j_kelamin_guru }}</td>
										<td>{{ list.tempat_lahir_guru }}</td>
										<td>{{ list.tgl_lahir_guru }}</td>
										<td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">edit</i></td>
										<td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">delete</i></td>
									</tr>
								</tbody>
								<tfoot>
									<td colspan="7" class="text-center">
										<div class="col-sm-6 text-left">
											<p> {{ $store.getters.getRowsRange }} </p>
										</div>
										<div class="col-sm-6 text-center" v-if="$store.state.paging.showPaging">
											<ul class="pagination pagination-sm m-a-0">
												<li><a href="javascript:void(0)" @click="getGuru(localLimit, paging('first'), cariGuru)"><i class="material-icons">skip_previous</i></a></li>
												<li><a href="javascript:void(0)" @click="getGuru(localLimit, paging('prev'), cariGuru)"><i class="material-icons">navigate_before</i></a></li>
												<li>
													<div class="col-xs-3">
														<input type="text" class="form-control" v-model="$store.state.paging.setStart" @keyup.enter="getGuru(localLimit, $store.state.paging.setStart - 1, cariGuru)">
													</div>
												</li>
												<li><a href="javascript:void(0)" @click="getGuru(localLimit, paging('next'), cariGuru)"><i class="material-icons">navigate_next</i></a></li>
												<li><a href="javascript:void(0)" @click="getGuru(localLimit, paging('last'), cariGuru)"><i class="material-icons">skip_next</i></a></li>
												<li><a href="javascript:void(0)" @click="getGuru(localLimit, ($store.getters.activePage - 1), cariGuru)"><i class="material-icons">refresh</i></a></li>
											</ul>
										</div>
									</td>
								</tfoot>
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

import { Guru } from '../../../scripts/store/Guru'

Vue.use(Vuex)

export default {
    name: 'Guru',
    store: Guru,
    components: {
	},
    beforeRouteEnter(to, from, next) {
		next(vm => vm.getGuru(10, 0, ''))
	},
	beforeRouteUpdate(to, from, next) {
		// this.resetDaftarGuru()
		next()
	},
	beforeRouteLeave(to, from, next) {
		this.$store.state.jmlBaris = 10
		// this.hideDataGuru()
		next()
	},
    data() {
        return {
            hello: 'Selamat datang di modul Guru!'
        }
    },
    methods: {
		...mapActions([
			'showPerPage',
		]),
        getGuru(limit, offset, search) {
            this.$store.dispatch('getGuru', {
                limit,
                offset,
                search
            })
        },
		paging(param) {
			return this.$store.state.paging[param]
		},
    },   
    computed: {
        ...mapState([
            'showDaftarGuru', 'daftarGuru', 'cariGuru', 'localLimit'
        ])
    } 
}

</script>