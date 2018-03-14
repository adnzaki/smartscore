<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class KriteriaController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('KriteriaModel');
    }

    public function getKriteria($limit, $offset, $token = '', $search = '')
    {
        if($this->hasValidToken($token))
        {
            $kriteria = $this->KriteriaModel->getKriteria($limit, $offset, $search);
            $persentase = [];
            $eigenArray = [];
            foreach($kriteria as $res)
            {
                $hasil = $res->eigen_value * 100;
                $eigenArray[] = $res->eigen_value;
                $persentase[] = number_format($hasil, 1);
            }
            echo json_encode([
                'kriteria' => $kriteria,
                'persentase' => $persentase,
                'jumlahEigen' => number_format(array_sum($eigenArray), 3, '.', ','),
                'jumlahPersen' => number_format(array_sum($persentase), 1),
                'rows' => $this->KriteriaModel->getKriteriaRows()
            ]);
        }
        else 
        {
            echo json_encode([
                'code'  => 0,
                'msg'   => lang('unableToGetData')
            ]);
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
                elseif($event === 'update')
                {
                    $this->KriteriaModel->updateKriteria($id);
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

    public function editKriteria($id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            echo json_encode($this->KriteriaModel->getDetailKriteria($id));
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

    public function deleteKriteria($id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $arrID = explode("-", $id);
            for($i = 0; $i < count($arrID); $i++)
            {
                $this->KriteriaModel->deleteKriteria($arrID[$i]);
            }
            echo 'success';
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

    public function getAllKriteriaID($token = '')
    {      
        if($this->hasValidToken($token))
        {
            $data = $this->KriteriaModel->getAllKriteriaID();
            $formatted = [];
            foreach($data as $res)
            {
                $formatted[] = $res->id_kriteria;
            }
            echo json_encode($formatted);
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
            if($result === 0)
            {
                echo json_encode($result + 1);
            }
            else 
            {
                echo json_encode($result[0]->id_kriteria + 1);
            }
        }
    }
}