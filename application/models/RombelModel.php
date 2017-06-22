<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Smartscore
 * Aplikasi Pengolahan Nilai Siswa berbasis Kurikulum 2013 untuk tingkat Sekolah Dasar (SD)
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License | https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 * @version     1.0.0
 */

class RombelModel extends CI_Model
{
    public function getRombel($limit, $offset)
    {
        $select = 'id_rombel, nama_rombel, tingkat, nama_guru';
        $query = $this->db->select($select)->from('rombel')->join('guru', 'rombel.id_guru = guru.id_guru')
                ->order_by('nama_rombel', 'ASC')->limit($limit, $offset);
        return $query->get()->result();
    }

    public function getTotalRows()
    {
        $query = $this->db->get('rombel');
        return $query->num_rows();
    }
}
