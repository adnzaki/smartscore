<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AlternatifModel extends CI_Model
{
    private $table = [
        'perbandingan' => 'perbandingan_alternatif',
        'daftar' => 'daftar_alternatif',
        'siswa' => 'siswa'
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

    public function getDaftarAlternatif()
    {
        return $this->db->select($this->table['daftar'].'.id_siswa, id_daftar_alternatif, nama_siswa, nis, nisn')->from($this->table['daftar'])
            ->join($this->table['siswa'], $this->table['siswa'].'.id_siswa = '.$this->table['daftar'].'.id_siswa')
            ->order_by('id_daftar_alternatif', 'ASC')->get()->result();
    }

    public function getPerbandingan($id, $kriteria)
    {
        $this->db->order_by('id_alternatif');
        return $this->db->get_where($this->table['perbandingan'], [
            'id_siswa' => $id, 'id_kriteria' => $kriteria
        ])->result();
    }

    public function getAllPerbandingan($kriteria)
    {
        return $this->db->get_where($this->table['perbandingan'], ['id_kriteria' => $kriteria])->result();
    }

    public function getNilaiPerbandingan($idSiswa, $pembanding, $kriteria)
    {
        $query = $this->db->get_where($this->table['perbandingan'],
            ['id_siswa' => $idSiswa, 'pembanding' => $pembanding, 'id_kriteria' => $kriteria]
        )->result();

        return $query[0]->nilai_perbandingan;
    }

    public function getComparisonLength($kriteria = '')
    {
        if(! empty($kriteria))
        {
            $this->db->where('id_kriteria', $kriteria);
        }
        
        return $this->db->get($this->table['perbandingan'])->num_rows();
    }

    public function getSelectedAlternatif($idSiswa)
    {
        return $this->db->select($this->table['daftar'].'.id_siswa, id_daftar_alternatif, nama_siswa')->from($this->table['daftar'])
            ->join($this->table['siswa'], $this->table['siswa'].'.id_siswa = '.$this->table['daftar'].'.id_siswa')
            ->where($this->table['daftar'].'.id_siswa !=' ,$idSiswa)->order_by('id_daftar_alternatif', 'ASC')->get()->result();
    }

    public function getAlternatifRows()
    {
        return $this->db->get($this->table['daftar'])->num_rows();
    }

    public function getAlternatifName($id)
    {
        return $this->db->select('nama_siswa')->from($this->table['siswa'])
                ->where('id_siswa', $id)->get()->result();
    }

    public function setNilaiPerbandingan($kriteria, $siswa, $pembanding, $value)
    {
        $kebalikan = $this->reverseValue[(string)$value]; 
        if(! $this->kebalikanExists($kriteria, $siswa))
        {
            $this->db->insert($this->table['perbandingan'], [
                'id_siswa' => $siswa,
                'pembanding' => $siswa,
                'id_kriteria' => $kriteria,
                'nilai_perbandingan' => 1
            ]);
        } 
        
        if($this->perbandinganAlternatifExists($kriteria, $siswa, $pembanding))
        {
            // update alternatif yang dibandingkan
            $this->db->set('nilai_perbandingan', (string)$value);
            $this->db->where(['id_kriteria' => $kriteria, 'id_siswa' => $siswa, 'pembanding' => $pembanding]);
            $this->db->update($this->table['perbandingan']);
            
            // update alternatif yang terkena dampak perbandingan
            $this->db->set('nilai_perbandingan', $kebalikan);
            $this->db->where(['id_kriteria' => $kriteria, 'id_siswa' => $pembanding, 'pembanding' => $siswa]);
            $this->db->update($this->table['perbandingan']);
        }
        else 
        {            

            $this->db->insert($this->table['perbandingan'], [
                'id_siswa' => $siswa,
                'pembanding' => $pembanding,
                'id_kriteria' => $kriteria,
                'nilai_perbandingan' => (string)$value
            ]);

            $this->db->insert($this->table['perbandingan'], [
                'id_siswa' => $pembanding,
                'pembanding' => $siswa,
                'id_kriteria' => $kriteria,
                'nilai_perbandingan' => $kebalikan
            ]);
        }
    }

    public function perbandinganAlternatifRows()
    {
        return $this->db->get($this->table['perbandingan'])->num_rows();
    }

    private function kebalikanExists($kriteria, $siswa)
    {
        $query = $this->db->get_where($this->table['perbandingan'], [
            'id_kriteria' => $kriteria, 'id_siswa' => $siswa, 'pembanding' => $siswa
        ]);

        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function perbandinganAlternatifExists($kriteria, $siswa, $pembanding)
    {
        $query = $this->db->get_where($this->table['perbandingan'], [
            'id_kriteria' => $kriteria, 'id_siswa' => $siswa, 'pembanding' => $pembanding
        ]);

        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setEigenValue($eigen, $siswa)
    {
        $this->db->set('eigen_value', $eigen);
        $this->db->where(['id_siswa' => $siswa]);
        $this->db->update($this->table['daftar']);
    }

    public function getNilaiPembanding($pembanding, $key, $kriteria)
    {
        $this->db->order_by('id_alternatif', 'ASC');
        return $this->db->get_where($this->table['perbandingan'], [
            $key => $pembanding, 'id_kriteria' => $kriteria,
        ])->result();
    }

    public function hasComparison($siswa)
    {
        $this->db->where('id_siswa', $siswa)->or_where('pembanding', $siswa);
        $query = $this->db->get($this->table['perbandingan'])->num_rows();
        if($query > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function checkComparison($siswa, $kriteria)
    {
        return $this->db->where(['id_siswa' => $siswa, 'id_kriteria' => $kriteria])
            ->get($this->table['perbandingan'])->result();        
    }
}