<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class KriteriaController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('KriteriaModel');
    }

    public function getKriteria($limit, $offset, $token)
    {
        if($this->hasValidToken($token))
        {
            echo json_encode([
                'kriteria' => $this->KriteriaModel->getKriteria($limit, $offset),
                'rows' => $this->KriteriaModel->getKriteriaRows()
            ]);
        }
        else 
        {
            $res = [
                'code'  => 0,
                'msg'   => lang('unableToGetData')
            ];
        }
    }

    public function save($event, $id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $rules = [
                [
                    'field' => 'nama_kriteria',
                    'label' => 'nama kriteria',
                    'rules' => 'required|max_length[50]'
                ],
            ];
    
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_message('required', 'Kolom {field} wajib diisi');
            $this->form_validation->set_message('max_length', 'Panjang kolom %s tidak boleh lebih dari %s karakter');
            $this->form_validation->set_error_delimiters('', '');

            if($this->form_validation->run() == FALSE)
            {
                echo json_encode(['nama_kriteria' => form_error('nama_kriteria')]);
            }
            else 
            {
                if($event === 'insert' && $id === 'null')
                {
                    $this->KriteriaModel->insertKriteria();
                }
                echo json_encode('success');
            }            
        }
        else 
        {
            $res = [
                'code'  => 0,
                'msg'   => lang('invalidCredential')
            ];
            echo json_encode($res);
        }
    }

    public function getLastID($token = '')
    {
        if($this->hasValidToken($token))
        {
            $result = $this->KriteriaModel->getLastID();
            echo $result[0]->id_kriteria;
        }
    }
}