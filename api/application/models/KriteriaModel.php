<?php defined('BASEPATH') OR exit('No direct script access allowed');

class KriteriaModel extends CI_Model
{
    private $table = [
        'kriteria' => 'kriteria',
        'perbandingan' => 'perbandingan_kriteria',
        'alternatif' => 'perbandingan_alternatif'
    ];

    private $reverseValue = [
        '1.00' => 1.00,
        '2.00' => 0.50,
        '3.00' => 0.33,
        '4.00' => 0.25,
        '5.00' => 0.20,
        '6.00' => 0.16,
        '7.00' => 0.14,
        '8.00' => 0.13,
        '9.00' => 0.11,
        '0.50' => 2,
        '0.33' => 3,
        '0.25' => 4,
        '0.20' => 5,
        '0.16' => 6,
        '0.14' => 7,
        '0.13' => 8,
        '0.11' => 9,
    ];

    public function getKriteria($limit = '', $offset = '', $search = '')
    {
        if(! empty($search))
        {
            $this->db->like('nama_kriteria', $search);
        }

        if(! empty($limit) && ! empty($offset))
        {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get($this->table['kriteria'])->result();
    }

    public function getKriteriaRows()
    {
        return $this->db->get($this->table['kriteria'])->num_rows();
    }

    public function getLastID()
    {
        $query = $this->db->select('*')->from($this->table['kriteria'])
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
        return $this->db->select('id_kriteria')->from($this->table['kriteria'])->get()->result();
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
        
        $this->db->query("ALTER TABLE ".$this->table['kriteria']." auto_increment = ".$setAutoIncrement);
        $this->db->insert($this->table['kriteria'], [
            'nama_kriteria' => $this->input->post('nama_kriteria', true),
            'eigen_value' => 0
        ]);

        $insertedID = $this->db->insert_id();

        // check if the record in kriteria table is > 1 or not 
        // if the row > 1, then
        // get the kriteria before the new one inserted
        if($this->getKriteriaRows() > 1) 
        {
            $kriteria = $this->db->get_where($this->table['kriteria'], ['id_kriteria != ' => $insertedID])->result();
            foreach($kriteria as $res)
            {
                $this->db->insert($this->table['perbandingan'], [
                    'id_kriteria'           => $res->id_kriteria,
                    'pembanding'            => $insertedID,
                    'nilai_perbandingan'    => 1
                ]);
            }
        }

        // get the latest kriteria
        $updatedKriteria = $this->getAllKriteriaID();
        foreach($updatedKriteria as $res)
        {
            $this->db->insert($this->table['perbandingan'], [
                'id_kriteria'           => $insertedID,
                'pembanding'            => $res->id_kriteria,
                'nilai_perbandingan'    => 1
            ]);
        }
    }

    public function updateKriteria($id)
    {
        $this->db->update($this->table['kriteria'], [
            'nama_kriteria' => $this->input->post('nama_kriteria', true)
        ], ['id_kriteria' => $id]);
    }

    public function getDetailKriteria($id)
    {
        $query = $this->db->get_where($this->table['kriteria'], ['id_kriteria' => $id])->result();
        return $query[0];
    }

    public function deleteKriteria($id)
    {
        $perbandingan = $this->db->get($this->table['perbandingan'])->num_rows();
        $alternatif = $this->db->get($this->table['alternatif'])->num_rows();
        if($perbandingan > 0)
        {
            $this->db->where('id_kriteria', $id)->or_where('pembanding', $id);
            $this->db->delete($this->table['perbandingan']);
        }

        if($alternatif > 0)
        {
            $this->db->where('id_kriteria', $id);
            $this->db->delete($this->table['alternatif']);
        }

        $this->db->delete($this->table['kriteria'], ['id_kriteria' => $id]);
    }

    public function getPerbandingan($id)
    {
        $this->db->order_by('id_kriteria', 'DESC');
        return $this->db->get_where($this->table['perbandingan'], [
            'id_kriteria' => $id
        ])->result();
    }

    public function getSelectedKriteria($id)
    {
        return $this->db->get_where($this->table['kriteria'], [
            'id_kriteria !=' => $id
        ])->result();
    }

    public function testGetValue($kriteria, $pembanding)
    {
        $this->db->where(['id_kriteria' => $kriteria, 'pembanding' => $pembanding]);
        $this->db->or_where('id_kriteria = '.$pembanding.' AND pembanding = '.$kriteria);
        //$query = $this->db->query("SELECT * FROM perbandingan_kriteria WHERE id_kriteria={$kriteria} AND pembanding={$pembanding} OR id_kriteria={$pembanding} AND pembanding={$kriteria}");
        //return $this->db->get($this->table['perbandingan'])->result();
        return $this->reverseValue['3.00'];
        //return $query->result();
    }

    public function setNilaiPerbandingan($kriteria, $pembanding, $value)
    {
        // update kriteria yang dibandingkan
        $this->db->set('nilai_perbandingan', (string)$value);
        $this->db->where(['id_kriteria' => $kriteria, 'pembanding' => $pembanding]);
        $this->db->update($this->table['perbandingan']);
        
        // update kriteria yang terkena dampak perbandingan
        $kebalikan = $this->reverseValue[(string)$value];  
        $this->db->set('nilai_perbandingan', $kebalikan);
        $this->db->where(['id_kriteria' => $pembanding, 'pembanding' => $kriteria]);
        $this->db->update($this->table['perbandingan']);
    }

    public function setEigenValue($eigen, $kriteria)
    {
        $this->db->set('eigen_value', $eigen);
        $this->db->where(['id_kriteria' => $kriteria]);
        $this->db->update($this->table['kriteria']);
    }

    public function getPembanding($pembanding, $key)
    {
        $this->db->order_by($key, 'DESC');
        return $this->db->get_where($this->table['perbandingan'], [
            $key => $pembanding
        ])->result();
    }

}