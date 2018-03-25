<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model
{
    private $table = 'pengguna';

    public function getUser($limit, $start, $search)
    {
        if(! empty($search))
        {
            $this->db->like('nama_pengguna', $search);
        }
        $select = 'id_pengguna, nama_pengguna, email, username';
        return $this->db->select($select)->from($this->table)->limit($limit, $start)->get()->result();
    }

    public function getTotalRows($search)
    {
        if(! empty($search))
        {
            $this->db->like('nama_pengguna', $search);
        }
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }
}