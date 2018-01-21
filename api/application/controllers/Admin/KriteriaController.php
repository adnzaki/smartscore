<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class KriteriaController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('KriteriaModel');
    }

    public function getKriteria()
    {
        echo json_encode($this->KriteriaModel->getKriteria());
    }

    public function getPerbandingan($limit, $offset, $token)
    {
        if($this->hasValidToken($token))
        {
            $kriteria = $this->KriteriaModel->getKriteria($limit, $offset);
            $data = [];
            foreach($kriteria as $res)
            {
                $data[$res->nama_kriteria] = $this->KriteriaModel->getPerbandingan($res->id_kriteria);
            }

            $res = [
                'kriteria' => $data,
                'rows' => $this->KriteriaModel->getKriteriaRows()
            ];
    
            echo json_encode($res);
        }
        else
        {
            $res = [
                'code'  => 0,
                'msg'   => lang('unableToGetData')
            ];
            echo json_encode($res);
        }
    }
}