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

class SiswaModel extends CI_Model
{
    public function getSiswa($limit, $start)
    {
        $select = 'nama_siswa, j_kelamin_siswa, tempat_lahir_siswa, tgl_lahir_siswa';
        $query = $this->db->select($select)->from('siswa')->limit($limit, $start);
        $result = $query->get()->result();
        return $result;
    }

    public function getTotalRows()
    {
        $query = $this->db->get('siswa');
        return $query->num_rows();
    }

    public function insertSiswa()
    {
        $data = $this->tableSiswaValue();
        $this->db->insert('siswa', $data);
    }

    protected function tableSiswaValue()
    {
        $tgl_lahir = $this->input->post('tgl_lahir_siswa', true);
        $data = [
            'nis'                   => $this->input->post('nis', true),
            'nisn'                  => $this->input->post('nisn', true),
            'nama_siswa'            => $this->input->post('nama_siswa', true),
            'j_kelamin_siswa'       => $this->input->post('j_kelamin_siswa', true),
            'tempat_lahir_siswa'    => $this->input->post('tempat_lahir_siswa', true),
            'tgl_lahir_siswa'       => reverse($tgl_lahir, '/', '-'),
            'agama_siswa'           => $this->input->post('agama_siswa', true),
            'pend_sblm'             => $this->input->post('pend_sblm', true),
            'alamat_siswa'          => $this->input->post('alamat_siswa', true),
            'nama_ayah'             => $this->input->post('nama_ayah', true),
            'nama_ibu'              => $this->input->post('nama_ibu', true),
            'job_ayah'              => $this->input->post('job_ayah', true),
            'job_ibu'               => $this->input->post('job_ibu', true),
            'alamat_ortu'           => $this->input->post('alamat_ortu', true),
            'telp_ortu'             => $this->input->post('telp_ortu', true),
            'nama_wali'             => $this->input->post('nama_wali', true),
            'alamat_wali'           => $this->input->post('alamat_wali', true),
            'job_wali'              => $this->input->post('job_wali', true),
            'telp_wali'             => $this->input->post('job_wali', true),
        ];

        return $data;
    }
}
