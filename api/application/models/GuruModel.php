<?php defined('BASEPATH') OR exit('No direct script access allowed');

class GuruModel extends CI_Model
{
    /**
     * Deklarasi nama tabel di database
     * 
     * @var $table
     */
    private $table = 'guru';

    public function getGuru($limit, $offset, $search = '')
    {
        if(! empty($search))
        {
            $this->db->like('nama_guru', $search);
        }
        $query = $this->db->order_by('nama_guru', 'ASC')->limit($limit, $offset)->get($this->table);
        return $query->result();
    }

    public function getTotalRows($search)
    {
        if(! empty($search))
        {
            $this->db->like('nama_guru', $search);
        }
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }
}