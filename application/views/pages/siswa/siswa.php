<div id="dataSiswa">
    <transition enter-active-class="animated slideInLeft" leave-active-class="animated slideOutRight">
        <div class="padding" v-if="showDaftarSiswa">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h2>Data Siswa</h2>
                            <small>
                            Use .table-striped to add zebra-striping to any table row within the &lt;tbody>.
                          </small>
                        </div>
                        <table class="table table-striped b-t">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                </tr>
                            </thead>
                            <tbody>{{ tglLahir }}
                                <tr v-for="list in daftarSiswa">
                                    <td>{{ list.nama_siswa }}</td>
                                    <td>{{ list.j_kelamin_siswa }}</td>
                                    <td>{{ list.tempat_lahir_siswa }}</td>
                                    <td>{{ list.tgl_lahir_siswa }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</div>
