<?php defined('BASEPATH') OR exit('No direct script access allowed');

class KriteriaModel extends CI_Model
{
    private $table = 'kriteria';

    private $table2 = 'perbandingan_kriteria';

    public function getKriteria($limit, $offset, $search)
    {
        if(! empty($search))
        {
            $this->db->like('nama_kriteria', $search);
        }
        return $this->db->limit($limit, $offset)->get($this->table)->result();
    }

    public function getKriteriaRows()
    {
        return $this->db->get($this->table)->num_rows();
    }

    public function getLastID()
    {
        $query = $this->db->select('*')->from($this->table)
                ->order_by('id_kriteria', 'DESC')->limit(1)->get();
        
        if($query->num_rows() === 0)
        {
            return 0;
        }
        else 
        {
            return $query->result();
        }
    }

    public function getAllKriteriaID()
    {
        return $this->db->select('id_kriteria')->from($this->table)->get()->result();
    }

    public function insertKriteria()
    {
        $getLastID = $this->getLastID();
        if($this->getKriteriaRows() === 0)
        {
            $setAutoIncrement = 1;
        }
        else 
        {
            $setAutoIncrement = $getLastID[0]->id_kriteria + 1;
        }
        
        $this->db->query("ALTER TABLE ".$this->table." auto_increment = ".$setAutoIncrement);
        $this->db->insert($this->table, [
            'nama_kriteria' => $this->input->post('nama_kriteria', true),
            'eigen_value' => 0
        ]);

        $insertedID = $this->db->insert_id();

        // check if the record in kriteria table is > 1 or not 
        // if the row > 1, then
        // get the kriteria before the new one inserted
        if($this->getKriteriaRows() > 1) 
        {
            $kriteria = $this->db->get_where($this->table, ['id_kriteria != ' => $insertedID])->result();
            foreach($kriteria as $res)
            {
                $this->db->insert($this->table2, [
                    'id_kriteria'           => $res->id_kriteria,
                    'pembanding'            => $insertedID,
                    'nilai_perbandingan'    => 0
                ]);
            }
        }

        // get the latest kriteria
        $updatedKriteria = $this->getAllKriteriaID();
        foreach($updatedKriteria as $res)
        {
            $this->db->insert($this->table2, [
                'id_kriteria'           => $insertedID,
                'pembanding'            => $res->id_kriteria,
                'nilai_perbandingan'    => 0
            ]);
        }
    }

    public function updateKriteria($id)
    {
        $this->db->update($this->table, [
            'nama_kriteria' => $this->input->post('nama_kriteria', true)
        ], ['id_kriteria' => $id]);
    }

    public function getDetailKriteria($id)
    {
        $query = $this->db->get_where($this->table, ['id_kriteria' => $id])->result();
        return $query[0];
    }

    public function deleteKriteria($id)
    {
        $this->db->where('id_kriteria', $id)->or_where('pembanding', $id);
        $this->db->delete($this->table2);
        $this->db->delete($this->table, ['id_kriteria' => $id]);
    }

    public function getPerbandingan($id)
    {
        $this->db->order_by('id_kriteria', 'DESC');
        return $this->db->get_where($this->table2, [
            'id_kriteria' => $id
        ])->result();
    }
}