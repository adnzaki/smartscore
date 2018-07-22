<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Member</title>
    <link rel="stylesheet" href="<?= $public.'css/laporan.css'?>">    
</head>
<body>
    <?php $this->view('laporan/kop-sekolah') ?>
    <div class="pdf-content">
        <div class="judul-laporan center-align">Rekapitulasi Hasil Penilaian Siswa Terbaik<br>SDN Pengasinan VII</div>
        <table>
            <thead>
                <tr>
                    <th class="center-align">No.</th>
                    <th>Nama</th>
                    <th>NIS / NISN</th>
                    <th class="center-align">Nilai Akhir</th>
                    <th class="center-align">Persentase</th>
                    <!-- <th>Ket.</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($prioritas as $key => $val): ?>
                <tr>
                    <td class="center-align"><?= $no ?></td>
                    <td><?= $val['namaSiswa'] ?></td>
                    <td><?= $val['nis'] ?> / <?= $val['nisn'] ?></td>
                    <td class="center-align"><?= $val['jumlah'] ?></td>
                    <td class="center-align"><?= $val['persentase'] ?>%</td>
                    <!-- <td></td> -->
                </tr>
                <?php $no++; endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php $this->view('laporan/tanda-tangan') ?>
</body>
</html>