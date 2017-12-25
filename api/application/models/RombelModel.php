<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Smartscore
 * Aplikasi Pengolahan Nilai Siswa berbasis Kurikulum 2013 untuk tingkat Sekolah Dasar (SD)
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License | https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 * @version     1.0.01
 */

class RombelModel extends CI_Model
{
    /**
     * Deklarasi nama tabel di database
     * 
     * @var $table
     */
    private $table = 'rombel';

    public function getRombel($limit, $offset)
    {
        $select = 'id_rombel, nama_rombel, tingkat, nama_guru';
        $query = $this->db->select($select)->from($this->table)->join('guru', 'rombel.id_guru = guru.id_guru')
                ->order_by('nama_rombel', 'ASC')->limit($limit, $offset);
        return $query->get()->result();
    }

    public function getTotalRows()
    {
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function getGuru()
    {
        return $this->db->get('guru')->result();
    }

    public function insertRombel()
    {
        $data = $this->tableRombelValue();
        $this->db->insert($this->table, $data);
    }

    public function updateRombel($id)
    {
        $data = $this->tableRombelValue();
        $this->db->update($this->table, $data, ['id_rombel' => $id]);
    }

    public function getDetailRombel($id)
    {
        return $this->db->get_where($this->table, ['id_rombel' => $id])->result();
    }

    public function deleteRombel($id)
    {
        $this->db->delete($this->table, ['id_rombel' => $id]);
    }

    public function getAllRombelID()
    {
        return $this->db->select('id_rombel')->from($this->table)->get()->result();
    }

    public function naikTingkat($idSiswa, $tingkat, $paralel)
    {
        $getRombel = $this->db->select('id_rombel, tingkat, paralel')->from($this->table)
                    ->where(['tingkat' => $tingkat, 'paralel' => $paralel])
                    ->get()->result();
        
        $this->db->update('siswa', ['id_rombel' => $getRombel[0]->id_rombel], ['id_siswa' => $idSiswa]);
    }
    
    public function createRombel($tingkat, $paralel, $guru)
    {
        $data = [
            'nama_rombel' => 'Kelas '.$tingkat.$paralel,
            'tingkat' => $tingkat,
            'paralel' => $paralel,
            'id_guru' => $guru,
        ];

        $this->db->insert($this->table, $data);
    }

    public function siswaLulus($id)
    {
        $this->db->update('siswa', [
            'status' => 'lulus',
            'id_rombel' => NULL,
        ], ['id_siswa' => $id]);
    }

    public function rombelExists($tingkat, $paralel)
    {
        $query = $this->db->get_where($this->table, [
            'tingkat' => $tingkat,
            'paralel' => $paralel,
        ]);

        if($query->num_rows() > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function getRombelSiswa()
    {
        $query = $this->db->select('id_siswa, siswa.id_rombel, tingkat, paralel, id_guru')
                ->from('siswa')->join($this->table, 'siswa.id_rombel=rombel.id_rombel')
                ->get()->result();
        
        return $query;
    }

    private function tableRombelValue()
    {
        return [
            'nama_rombel'   => $this->input->post('nama_rombel', true),
            'tingkat'       => $this->input->post('tingkat', true),
            'paralel'       => $this->input->post('paralel', true),
            'id_guru'       => $this->input->post('wali_kelas', true)
        ];
    }

}
