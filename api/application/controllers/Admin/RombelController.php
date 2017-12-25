<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

/**
 * Smartscore
 * Aplikasi Pengolahan Nilai Siswa berbasis Kurikulum 2013 untuk tingkat Sekolah Dasar (SD)
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License | https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 * @version     1.0.0
 */

class RombelController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('RombelModel');
    }

    public function fetchRombel($limit, $offset, $token = '')
    {
        if(empty($token))
        {            
            echo json_encode('Akses tidak diizinkan');
        }
        else 
        {
            if($this->hasValidToken($token))
            {
                $decodedToken = JWT::decode($token, 'user_key');
                $data = [
                    'rombel' => $this->RombelModel->getRombel($limit, $offset),
                    'baris' => $this->RombelModel->getTotalRows(),
                    'tahun_ajaran' => $decodedToken->tahun_ajaran
                ];
                echo json_encode($data);
            }
            else 
            {
                echo json_encode('Token tidak valid');
            }
        }        
    }

    public function getGuru()
    {
        echo json_encode($this->RombelModel->getGuru());
    }

    public function save($event, $id = '')
    {
        $rules = [
            [
                'field' => 'nama_rombel',
                'label' => 'nama rombel',
                'rules' => 'required|max_length[50]'
            ],
            [
                'field' => 'tingkat',
                'label' => 'tingkat kelas',
                'rules' => 'required|exact_length[1]|numeric'
            ],
            [
                'field' => 'paralel',
                'label' => 'kelas paralel',
                'rules' => 'required|exact_length[1]'
            ],
            [
                'field' => 'wali_kelas',
                'label' => 'wali kelas',
                'rules' => 'required|max_length[3]|numeric'
            ],
        ];

        $this->form_validation->set_rules($rules);
        $this->form_validation->set_message('required', 'Kolom {field} wajib diisi');
        $this->form_validation->set_message('max_length', 'Panjang kolom %s tidak boleh lebih dari %s karakter');
        $this->form_validation->set_message('exact_length', 'Panjang kolom %s harus %s karakter');
        $this->form_validation->set_message('numeric', 'Kolom {field} hanya boleh diisi angka');
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() == FALSE)
        {
            $errors = [
                'nama_rombel'   => form_error('nama_rombel'),
                'tingkat'       => form_error('tingkat'),
                'paralel'       => form_error('paralel'),
                'wali_kelas'    => form_error('wali_kelas'),
            ];
            echo json_encode($errors);
        }
        else 
        {
            if($event === 'insert')
            {
                $this->RombelModel->insertRombel();
            }
            elseif($event === 'update') 
            {
                $this->RombelModel->updateRombel($id);
            }
            echo json_encode('success');
        }
    }

    public function getDetailRombel($id)
    {
        $data = $this->RombelModel->getDetailRombel($id);
        echo json_encode($data);
    }

    public function deleteRombel($id)
    {
        $arrID = explode("-", $id);
        for($i = 0; $i < count($arrID); $i++)
        {
            $this->RombelModel->deleteRombel($arrID[$i]);
        }
        echo 'success';
    }

    public function getAllRombelID()
    {
        $data = $this->RombelModel->getAllRombelID();
        $formatted = [];
        foreach($data as $res)
        {
            $formatted[] = $res->id_rombel;
        }
        echo json_encode($formatted);
    }

    public function naikTingkat($token = '')
    {
        if(empty($token))
        {
            echo 'You do not have access to this page.';
        }
        else 
        {
            if($this->hasValidToken($token))
            {
                $getRombelSiswa = $this->RombelModel->getRombelSiswa();
                // loop data rombel siswa 
                $formatted = [];
                foreach($getRombelSiswa as $res)
                {
                    $nextGrade = $res->tingkat + 1;
        
                    // jika rombel berikutnya tidak ada di database dan tingkat berikutnya kurang dari 6,
                    // buat rombel baru untuk tingkat berikutnya
                    if(! $this->RombelModel->rombelExists($nextGrade, $res->paralel) && $nextGrade < 6)
                    {
                        $this->RombelModel->createRombel($nextGrade, $res->paralel, $res->id_guru);
                        $this->RombelModel->naikTingkat($res->id_siswa, $nextGrade, $res->paralel);
                    }
                    // jika tingkat berikutnya lebih dari 6, luluskan siswa dengan mengganti statusnya
                    // menjadi lulus di tabel siswa
                    elseif($nextGrade > 6)
                    {
                        $this->RombelModel->siswaLulus($res->id_siswa);
                    }
                    else 
                    {
                        $this->RombelModel->naikTingkat($res->id_siswa, $nextGrade, $res->paralel);
                    }
        
                    $formatted[] = [
                        'siswa' => $res->id_siswa,
                        'tingkatSblm' => $res->tingkat,
                        'tingkatSkrg' => $nextGrade
                    ];
                }     
                $res = [
                    'status' => 'ok',
                    'total' => count($formatted),
                ];
                echo json_encode($res);
            }
        }        
    }

    public function copyRombel($token)
    {
        $decoded = JWT::decode($token, 'user_key');
        $tahunSblm = $decoded->tahun_ajaran - 1;
        $tahunSkrg = $decoded->tahun_ajaran;
        if($this->RombelModel->duplicateRombel($tahunSblm, $tahunSkrg))
        {
            $res = [
                'status' => 1,
                'jml_rombel' => $this->RombelModel->getTotalRows($tahunSkrg),
            ];

            echo json_encode($res);
        }
        else 
        {
            echo json_encode(0);
        }
    }
    
}
