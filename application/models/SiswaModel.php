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
}
