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
        return $this->db->select($select)->from($this->table)->where('status_pengguna !=', 'admin')->limit($limit, $start)->get()->result();
    }

    public function getTotalRows($search)
    {
        if(! empty($search))
        {
            $this->db->like('nama_pengguna', $search);
        }
        $query = $this->db->get_where($this->table, ['status_pengguna !=' => 'admin']);
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

    public function update($id)
    {
        $data = [
            'nama_pengguna' => $this->input->post('nama_pengguna', true),
            'email' => $this->input->post('email', true),
        ];

        $this->db->update($this->table, $data, ['id_pengguna' => $id]);
    }

    public function editPengguna($id)
    {
        $select = 'id_pengguna, nama_pengguna, email';
        return $this->db->select($select)->from($this->table)->where('id_pengguna', $id)->get()->result();
    }

    public function resetPassword($id)
    {
        $data = [
            'password_pengguna' => password_hash($this->input->post('password_pengguna', true), PASSWORD_BCRYPT),
        ];

        $this->db->update($this->table, $data, ['id_pengguna' => $id]);
    }

    public function delete($id)
    {
        $this->db->delete($this->table, ['id_pengguna' => $id]);
    }

    public function getAllUserID()
    {
        return $this->db->select('id_pengguna')->from($this->table)->get()->result();
    }

    public function getOnlineUser($username)
    {
        return $this->db->get_where($this->table, [
            'network_status' => 'online', 'username !=' => $username
        ])->num_rows();
    }
    
}