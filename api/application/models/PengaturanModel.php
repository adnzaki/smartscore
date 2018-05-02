<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PengaturanModel extends CI_Model
{
    private $table = [
        'd_arsip' => 'daftar_arsip',
        'arsip' => 'arsip_nilai',
        'siswa' => 'siswa',
        'd_alternatif' => 'daftar_alternatif',
        'p_alternatif' => 'perbandingan_alternatif',
        'user' => 'pengguna',
    ];

    public function checkPasswordLama($username, $password)
    {
        $passwordLama = $this->db->select('password_pengguna')->from($this->table['user'])
        ->where('username', $username)->get()->result();        
        if(password_verify($password, $passwordLama[0]->password_pengguna))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function setPasswordBaru($username, $password)
    {
        $this->db->set('password_pengguna', password_hash($password, PASSWORD_BCRYPT))
        ->where('username', $username)->update($this->table['user']);
    }

    public function daftarArsip()
    {
        $tgl = $this->input->post('tgl_arsip', true);
        $this->db->insert($this->table['d_arsip'], [
            'nama_arsip' => $this->input->post('nama_arsip', true),
            'tgl_arsip' => reverse($tgl, '/', '-'),
        ]);

        return $this->db->insert_id();
    }

    public function updateArsip($id)
    {
        $tgl = $this->input->post('tgl_arsip', true);
        $this->db->update($this->table['d_arsip'], [
            'nama_arsip' => $this->input->post('nama_arsip', true),
            'tgl_arsip' => reverse($tgl, '/', '-'),
        ], ['id_arsip' => $id]);
    }

    public function getDetailArsip($id)
    {
        return $this->db->get_where(
            $this->table['d_arsip'], 
            ['id_arsip' => $id]
        )->result();
    }

    public function getArsipNilai($id)
    {
        return $this->db->get_where(
            $this->table['arsip'],
            ['id_arsip' => $id]
        )->result();
    }

    public function tambahArsip(array $dataArsip)
    {      
        $this->db->insert($this->table['arsip'], $dataArsip);        
    }

    public function hapusData()
    {
        $this->db->empty_table($this->table['p_alternatif']);
        $this->db->empty_table($this->table['d_alternatif']);
        $this->db->empty_table($this->table['siswa']);
    }

    public function getArsip($limit, $offset, $search)
    {
        if(! empty($search))
        {
            $this->db->like('nama_arsip', $search);
        }

        return $this->db->limit($limit, $offset)->get($this->table['d_arsip'])->result();
    }

    public function getArsipRows($search)
    {
        if(! empty($search))
        {
            $this->db->like('nama_arsip', $search);
        }

        return $this->db->get($this->table['d_arsip'])->num_rows();
    }
}