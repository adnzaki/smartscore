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
            $data->tgl_lahir_siswa = $this->ostiumdate->format('d-Mm-y', reverse($data->tgl_lahir_siswa, '-', '-'));
            array_push($formatted, $data);
        }

        $res = [
            'dataSiswa' => $formatted,
            'totalRows' => $this->SiswaModel->getTotalRows()
        ];
        echo json_encode($res);
    }

    public function setSiswa($event, $key = '')
    {
        $this->form_validation->set_message('required', 'Kolom {field} wajib diisi');
        $this->form_validation->set_message('max_length', 'Panjang kolom %s tidak boleh lebih dari %s karakter');
        $this->form_validation->set_message('exact_length', 'Panjang kolom %s harus %s karakter');
        $this->form_validation->set_message('numeric', 'Kolom {field} hanya boleh diisi angka');
        $this->form_validation->set_message('is_unique', 'Data %s sudah ada');
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() == FALSE)
        {
            $errors = [
                'nama_siswa'    => form_error('nama_siswa'),
                'nis'           => form_error('nis'),
                'nisn'          => form_error('nisn'),
                'tempat_lahir_siswa' => form_error('tempat_lahir_siswa'),
                'tgl_lahir_siswa' => form_error('tgl_lahir_siswa'),
                'pend_sblm'     => form_error('pend_sblm'),
                'alamat_siswa'  => form_error('alamat_siswa'),
                'nama_ayah'     => form_error('nama_ayah'),
                'nama_ibu'      => form_error('nama_ibu'),
                'alamat_ortu'   => form_error('alamat_ortu'),
                'telp_ortu'     => form_error('telp_ortu'),
                'nama_wali'     => form_error('nama_wali'),
                'alamat_wali'   => form_error('alamat_wali'),
                'telp_wali'      => form_error('telp_wali'),
            ];
            echo json_encode($errors);
        }
        else
        {
            if($event === 'insert')
            {
                $this->SiswaModel->insertSiswa();
            }
            elseif($event === 'update')
            {
                $this->SiswaModel->updateSiswa($key);
            }

            echo json_encode('success');
        }
    }

}