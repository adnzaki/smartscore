<?php defined('BASEPATH') OR exit('No direct script access allowed');

class KriteriaModel extends CI_Model
{
    private $table = [
        'kriteria' => 'kriteria',
        'perbandingan' => 'perbandingan_kriteria'
    ];

    public function getKriteria($limit, $offset, $search = '')
    {
        if(! empty($search))
        {
            $this->db->like($search);
        }
        return $this->db->limit($limit, $offset)->get($this->table['kriteria'])->result();
    }

    public function getKriteriaRows()
    {
        return $this->db->get($this->table['kriteria'])->num_rows();
    }

    public function getPerbandingan($id)
    {
        return $this->db->get_where($this->table['perbandingan'], [
            'id_kriteria' => $id
        ])->result();
    }
}