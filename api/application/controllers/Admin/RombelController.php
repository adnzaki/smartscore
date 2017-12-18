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
                'field' => 'tingkat',
                'label' => 'tingkat kelas',
                'rules' => 'required|max_length[50]|numeric'
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
