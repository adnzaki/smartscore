<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= $public.'css/laporan.css'?>">    
</head>
<body>
    <?php $this->view('laporan/kop-sekolah') ?>
    <div class="pdf-content">
        <div class="judul-laporan center-align">Arsip Nilai <?= $title ?></div>
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
                <?php $no = 1; foreach($nilai as $res): ?>
                <tr>
                    <td class="center-align"><?= $no ?></td>
                    <td><?= $res->nama_siswa ?></td>
                    <td><?= $res->nis_nisn ?></td>
                    <td class="center-align"><?= $res->nilai_akhir ?></td>
                    <td class="center-align"><?= $res->persentase ?>%</td>
                    <!-- <td></td> -->
                </tr>
                <?php $no++; endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php $this->view('laporan/tanda-tangan-arsip') ?>
</body>
</html>