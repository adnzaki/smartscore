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

    public function insert()
    {
        $data = [
            'nama_pengguna' => $this->input->post('nama_pengguna', true),
            'email' => $this->input->post('email', true),
            'username' => $this->input->post('username', true),
            'password_pengguna' => password_hash($this->input->post('password_pengguna', true), PASSWORD_BCRYPT),
            'status_pengguna' => 'user',
            'network_status' => 'offline',
        ];

        $this->db->insert($this->table, $data);
    }
    
}