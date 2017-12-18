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

    private function tableRombelValue()
    {
        return [
            'nama_rombel'   => $this->input->post('nama_rombel', true),
            'tingkat'       => $this->input->post('tingkat', true),
            'id_guru'       => $this->input->post('wali_kelas', true)
        ];
    }

    public function duplicateRombel($tahunSblm, $tahunSkrg)
    {
        $createTmp = 'CREATE TEMPORARY TABLE tmp_rombel SELECT * FROM rombel WHERE tahun_ajaran='.$tahunSblm;
        $updateTmp = 'UPDATE tmp_rombel SET id_rombel=NULL, tahun_ajaran='.$tahunSkrg;
        $copyTmp = 'INSERT INTO rombel SELECT * FROM tmp_rombel';
        $dropTmp = 'DROP TEMPORARY TABLE IF EXISTS tmp_rombel';
        $this->db->trans_start();
        $this->db->query($createTmp);
        $this->db->query($updateTmp);
        $this->db->query($copyTmp);
        $this->db->query($dropTmp);
        $this->db->trans_complete();

        if($this->db->trans_status() === false)
        {
            return false;
        }
        else 
        {
            return true;
        }
    }
}
