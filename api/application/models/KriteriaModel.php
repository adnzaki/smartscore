<?php defined('BASEPATH') OR exit('No direct script access allowed');

class KriteriaModel extends CI_Model
{
    private $table = 'kriteria';

    public function getKriteria($limit, $offset, $search = '')
    {
        if(! empty($search))
        {
            $this->db->like($search);
        }
        return $this->db->limit($limit, $offset)->get($this->table)->result();
    }

    public function getKriteriaRows()
    {
        return $this->db->get($this->table)->num_rows();
    }

    public function getLastID()
    {
        return $this->db->select('id_kriteria')->from($this->table)
                ->order_by('id_kriteria', 'DESC')->limit(1)->get()->result();
    }

    public function insertKriteria()
    {
        $this->db->insert($this->table, [
            'nama_kriteria' => $this->input->post('nama_kriteria', true),
            'eigen_value' => 0
        ]);
    }

    public function getPerbandingan($id)
    {
        return $this->db->get_where($this->table['perbandingan'], [
            'id_kriteria' => $id
        ])->result();
    }
}