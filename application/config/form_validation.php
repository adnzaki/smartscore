<?php

if($event = 'insert')
{
    $is_unique = [
        '|is_unique[siswa.nis]',
        '|is_unique[siswa.nisn]',
    ];
}
else
{
    $is_unique = ['', ''];
}

$config = [
    'SiswaController/setSiswa' => [
        [
            'field' => 'nama_siswa',
            'label' => 'nama siswa',
            'rules' => 'required|max_length[100]'
        ],
        [
            'field' => 'nis',
            'label' => 'Nomor Induk Sekolah',
            'rules' => 'required'.$is_unique[0].'|exact_length[9]|numeric'
        ],
        [
            'field' => 'nisn',
            'label' => 'NISN',
            'rules' => 'required'.$is_unique[1].'|exact_length[10]|numeric'
        ],
        [
            'field' => 'tempat_lahir_siswa',
            'label' => 'tempat lahir',
            'rules' => 'required|max_length[100]'
        ],
        [
            'field' => 'tgl_lahir_siswa',
            'label' => 'tanggal lahir',
            'rules' => 'required|exact_length[10]'
        ],
        [
            'field' => 'pend_sblm',
            'label' => 'pendidikan sebelumnya',
            'rules' => 'max_length[100]'
        ],
        [
            'field' => 'alamat_siswa',
            'label' => 'alamat siswa',
            'rules' => 'required|max_length[250]'
        ],
        [
            'field' => 'nama_ayah',
            'label' => 'nama ayah',
            'rules' => 'required|max_length[100]'
        ],
        [
            'field' => 'nama_ibu',
            'label' => 'nama ibu',
            'rules' => 'required|max_length[100]'
        ],
        [
            'field' => 'alamat_ortu',
            'label' => 'alamat orang tua',
            'rules' => 'required|max_length[255]'
        ],
        [
            'field' => 'telp_ortu',
            'label' => 'nomor telepon orang tua',
            'rules' => 'required|min_length[11]|max_length[15]|numeric'
        ],
        [
            'field' => 'nama_wali',
            'label' => 'nama wali',
            'rules' => 'max_length[50]'
        ],
        [
            'field' => 'alamat_wali',
            'label' => 'alamat wali',
            'rules' => 'max_length[255]'
        ],
        [
            'field' => 'telp_wali',
            'label' => 'nomor telepon wali',
            'rules' => 'min_length[11]|max_length[15]|numeric'
        ],
    ]
];
