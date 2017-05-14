<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Smartscore
 * Aplikasi Pengolahan Nilai Siswa berbasis Kurikulum 2013 untuk tingkat Sekolah Dasar (SD)
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     MIT License | https://opensource.org/licenses/MIT
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 * @version     1.0.0
 */

class SiswaController extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('SiswaModel');
    }

    public function fetchSiswa($limit, $start)
    {
        $data = $this->SiswaModel->getSiswa($limit, $start);
        $formatted = [];
        foreach($data as $data)
        {
            $data->tgl_lahir_siswa = $this->ostiumdate->format('d-Mm-y', reverse($data->tgl_lahir_siswa, '-'));
            array_push($formatted, $data);
        }

        $res = [
            'dataSiswa' => $formatted,
            'totalRows' => $this->SiswaModel->getTotalRows()
        ];
        echo json_encode($res);
    }

}
