/**
 * Smartscore
 * Aplikasi Pengolahan Nilai Siswa berbasis Kurikulum 2013 untuk tingkat Sekolah Dasar (SD)
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License | https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 * @version     1.0.0
 */

Vue.component('rombeloption', {
    props: ['perpage'],
    template: `
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
                        <select class="form-control">
                            <option @click="perpage(10)" class="text-black">10 baris</option>
                            <option @click="perpage(25)" class="text-black">25 baris</option>
                            <option @click="perpage(50)" class="text-black">50 baris</option>
                            <option @click="perpage(100)" class="text-black">100 baris</option>
                            <option @click="perpage(250)" class="text-black">250 baris</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <input type="text" class="form-control" placeholder="Cari siswa (ketik dan enter)">
            </div>
        </div>
    </div>
    `
})

Vue.component('listrombel', {
    props: ['data', 'get'],
    template: `
    <table class="table table-striped b-t">
        <thead>
            <tr>
                <th width="30">#</th>
                <th>Nama Rombel</th>
                <th>Tingkat Kelas</th>
                <th>Wali Kelas</th>
                <th class="text-center">Jumlah Siswa</th>
                <th colspan="3" width="80" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="list in data">
                <td class="text-center">
                    <label class="control control--checkbox">
                        <input type="checkbox" />
                        <div class="control__indicator"></div>
                    </label>
                </td>
                <td>{{ list.nama_rombel }}</td>
                <td>{{ list.tingkat }}</td>
                <td>{{ list.nama_guru }}</td>
                <td class="text-center">38</td>
                <td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">edit</i></td>
                <td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">group</i></td>
                <td class="text-center ss-cursor-pointer" @click=""><i class="material-icons">delete</i></td>
            </tr>
        </tbody>
        <tfoot>
            <td colspan="4" class="text-center">
                <div class="col-sm-8 text-left">
                    <p>Menampilkan baris <b>{{ paging.dataFrom() }}</b> - <b>{{ paging.dataTo() }}</b> dari <b>{{ paging.totalRows }}</b> baris.</p>
                </div>
                <div class="col-sm-4 text-center">
                    <ul class="pagination pagination-sm m-a-0">
                        <li><a href="javascript:void(0)" @click="get(paging.limit, paging.first)"><i class="material-icons">skip_previous</i></a></li>
                        <li><a href="javascript:void(0)" @click="get(paging.limit, paging.prev)"><i class="material-icons">navigate_before</i></a></li>
                        <li>
                            <div class="col-xs-3">
                                <input type="text" class="form-control" v-model="paging.setStart" @keyup.enter="get(paging.limit, paging.setStart - 1)">
                            </div>
                        </li>
                        <li><a href="javascript:void(0)" @click="get(paging.limit, paging.next)"><i class="material-icons">navigate_next</i></a></li>
                        <li><a href="javascript:void(0)" @click="get(paging.limit, paging.last)"><i class="material-icons">skip_next</i></a></li>
                    </ul>
                </div>
            </td>
        </tfoot>
    </table>`
})

var rombel = new Vue({
    el: '#dataRombel',
    data: {
        showDaftarRombel: false,
        daftarRombel: '',
    },
    methods: {
        getRombel(limit, start) {
            var self = this
            paging.offset = start * limit
            $.ajax({
                url: `${baseUrl}admin/RombelController/fetchRombel/${limit}/${paging.offset}/`,
                type: 'GET',
                dataType: 'json',
                success: data => {
                    self.daftarRombel = data['rombel']
                    setTimeout(() => {
                        self.showDaftarRombel = true
                    }, 400)

                    paging.totalRows = data['baris']
                    paging.create(data['baris'])

                    // atur nilai default untuk next page
                    start === (paging.last -= 1) ? paging.next = start : paging.next = start + 1

                    // atur nilai default untuk previous page
                    start === paging.first ? paging.prev = start : paging.prev = start - 1
                }
            })
        }
    },
})
