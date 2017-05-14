<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
