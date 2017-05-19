<transition enter-active-class="animated slideInLeft" leave-active-class="animated slideOutRight">
	<div class="padding" v-if="showFormAdd">
		<div class="row">
			<div class="col-sm-12">
				<div class="box">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="box-header">
        						<h2>Tambah Siswa</h2>
        					</div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <div class="box-header">
                                <button class="btn btn-icon danger" @click="closeForm"><i class="fa fa-remove"></i></button>
        					</div>
                        </div>
                    </div>

					<div class="box-divider m-a-0"></div>
					<div class="box-body">
						<form role="form" id="formTambahSiswa">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Nama Lengkap</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nama_siswa" placeholder="Nama Lengkap">
									<sserror :msg="error.nama"></sserror>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Nomor Induk Sekolah</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nis" placeholder="Nomor Induk Sekolah" minlength="9" maxlength="9">
									<sserror :msg="error.nis"></sserror>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">NISN</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nisn" placeholder="Nomor Induk Siswa Nasional" minlength="10" maxlength="10">
									<sserror :msg="error.nisn"></sserror>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Jenis Kelamin</label>
								<div class="col-sm-10">
									<label class="md-check">
                                        <input type="radio" id="j_laki" checked name="j_kelamin_siswa" value="Laki-laki">
                                        <i class="green"></i>Laki-laki
                                    </label>&nbsp &nbsp &nbsp
									<label class="md-check">
                                        <input type="radio" id="j_perempuan" name="j_kelamin_siswa" value="Perempuan">
                                        <i class="green"></i>Perempuan
                                    </label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Tempat Lahir</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="tempat_lahir_siswa" placeholder="Tempat Lahir">
									<sserror :msg="error.tmptLahir"></sserror>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Tanggal Lahir</label>
								<div class="col-sm-10">
									<div class="form-group">
										<div class='input-group date' id='datetimepicker1'>
						                    <input type='text' class="form-control" name="tgl_lahir_siswa" minlength="10" maxlength="10" />
						                    <span class="input-group-addon">
						                        <span class="fa fa-calendar"></span>
						                    </span>
						                </div>
										<sserror :msg="error.tglLahir"></sserror>
									</div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Agama</label>
								<div class="col-sm-10">
									<div class="form-group">
                                        <select class="form-control c-select" name="agama_siswa">
                                          <option value="Islam">Islam</option>
                                          <option value="Katholik">Katholik</option>
                                          <option value="Protestan">Kristen Protestan</option>
                                          <option value="Hindu">Hindu</option>
                                          <option value="Buddha">Buddha</option>
                                        </select>
									</div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Pendidikan Sebelumnya</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="pend_sblm" placeholder="Nama Taman Kanak-kanak (Kosongkan jika tidak ada)">
									<sserror :msg="error.pendSblm"></sserror>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Alamat Siswa</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="alamat_siswa" rows="2"></textarea>
									<sserror :msg="error.alamatSiswa"></sserror>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Nama Ayah</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nama_ayah" placeholder="Nama Ayah">
									<sserror :msg="error.namaAyah"></sserror>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Nama Ibu</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nama_ibu" placeholder="Nama Ibu">
									<sserror :msg="error.namaIbu"></sserror>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Pekerjaan Ayah</label>
								<div class="col-sm-10">
									<div class="form-group">
                                        <select class="form-control c-select" name="job_ayah">
                                          <option value="PNS">PNS</option>
                                          <option value="Karyawan Swasta">Karyawan Swasta</option>
                                          <option value="Wiraswasta">Wiraswasta</option>
                                          <option value="Buruh">Buruh</option>
                                          <option value="Tidak Bekerja">Tidak Bekerja</option>
                                          <option value="Lain-lain">Lain-lain</option>
                                        </select>
									</div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Pekerjaan Ibu</label>
								<div class="col-sm-10">
									<div class="form-group">
                                        <select class="form-control c-select" name="job_ibu">
                                          <option value="PNS">PNS</option>
                                          <option value="Karyawan Swasta">Karyawan Swasta</option>
                                          <option value="Wiraswasta">Wiraswasta</option>
                                          <option value="Buruh">Buruh</option>
                                          <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                          <option value="Lain-lain">Lain-lain</option>
                                        </select>
									</div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Alamat Orang Tua</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="alamat_ortu" rows="2"></textarea>
									<sserror :msg="error.alamatOrtu"></sserror>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">No. Telp. Orang tua</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="telp_ortu" placeholder="No. Telepon" minlength="12" maxlength="15">
									<sserror :msg="error.telpOrtu"></sserror>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Nama Wali</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nama_wali" placeholder="Nama Wali (Kosongkan jika tidak ada)">
									<sserror :msg="error.namaWali"></sserror>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Alamat Wali</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="alamat_wali" rows="2" placeholder="Alamat Wali (Kosongkan jika tidak ada)"></textarea>
									<sserror :msg="error.alamatWali"></sserror>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Pekerjaan Wali</label>
								<div class="col-sm-10">
									<div class="form-group">
                                        <select class="form-control c-select" name="job_ayah">
                                          <option value="PNS">PNS</option>
                                          <option value="Karyawan Swasta">Karyawan Swasta</option>
                                          <option value="Wiraswasta">Wiraswasta</option>
                                          <option value="Buruh">Buruh</option>
                                          <option value="Tidak Bekerja">Tidak Bekerja</option>
                                          <option value="Lain-lain">Lain-lain</option>
                                        </select>
									</div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">No. Telp. Wali</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="telp_wali" placeholder="No. Telepon Wali (Kosongkan jika tidak ada)" minlength="12" maxlength="15">
									<sserror :msg="error.telpWali"></sserror>
								</div>
							</div>
							<!-- ########################################### -->
							<div class="form-group row m-t-md">
								<div class="offset-sm-8 col-sm-4 text-right">
									<button type="button" class="btn btn-fw success" @click="insertSiswa">Simpan</button>
                                    <button type="button" class="btn btn-fw info" @click="closeForm">Tutup</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</transition>
