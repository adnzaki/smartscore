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
    public function getSiswa()
    {
        $select = 'nama_siswa, j_kelamin_siswa, tempat_lahir_siswa, tgl_lahir_siswa';
        $query = $this->db->select($select)->from('siswa');
        $result = $query->get()->result();
        return $result;
    }
}
