<template>
  <div>
    <div class="padding">
        <div class="row">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <h2>Skala Dasar Perbandingan AHP</h2>								
                    </div>     
                    <div class="table-responsive">
                        <table class="table table-striped b-t">
                            <thead>
                                <tr>
                                    <th class="text-center">No. </th>
                                    <th class="text-center" width="250">Indeks Nilai AHP</th>
                                    <th class="text-center">Penjelasan</th>										
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in skalaAHP">
                                    <td class="text-center">{{ index + 1 }}</td>
                                    <td class="text-center"><b>{{ item.indeks }}</b></td>
                                    <td>{{ item.definisi }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                              
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'

export default {
    name: 'SkalaDasarAHP',
    beforeRouteEnter(to, from, next) {
		next()
	},
	beforeRouteUpdate(to, from, next) {
		next()
	},
	beforeRouteLeave(to, from, next) {
		next()
	},
    data() {
        return {
            skalaAHP: [
                {
                    indeks: 1, definisi: 'Sama penting'
                },
                {
                    indeks: 2, definisi: 'Antara sama penting dan sedikit lebih penting'
                },
                {
                    indeks: 3, definisi: 'Sedikit lebih penting'
                },
                {
                    indeks: 4, definisi: 'Antara sedikit lebih penting dan jelas lebih penting'
                },
                {
                    indeks: 5, definisi: 'Jelas lebih penting'
                },
                {
                    indeks: 6, definisi: 'Antara lebih penting dan sangat penting'
                },
                {
                    indeks: 7, definisi: 'Sangat penting'
                },
                {
                    indeks: 8, definisi: 'Antara sangat penting dan mutlak sangat penting'
                },
                {
                    indeks: 9, definisi: 'Mutlak sangat penting'
                },
                {
                    indeks: 'Nilai Kebalikan', definisi: `Jika variabel (a) mendapat suatu angka bila dibandingkan 
                    dengan variabel (b). Maka variabel (b) mempunyai nilai kebalikannya bila 
                    dibandingkan dengan variabel (a). Contoh: (a) sedikit lebih penting dari (b), maka nilai (a) 
                    terhadap (b) adalah 3, dan nilai (b) terhadap (a) adalah 1/3.`
                },
            ]
        }
    },
}
</script>
