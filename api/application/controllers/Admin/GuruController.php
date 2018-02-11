<?php defined('BASEPATH') OR exit('No direct script access allowed');

class GuruController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('GuruModel');
    }

    public function fetchGuru($limit, $offset, $token = '', $search = '')
    {
        if($this->hasValidToken($token))
        {
            $data = $this->GuruModel->getGuru($limit, $offset, $search);
            $formatted = [];
            foreach($data as $data)
            {
                $data->tgl_lahir_guru = $this->ostiumdate->format('d-Mm-y', reverse($data->tgl_lahir_guru, '-', '-'));
                array_push($formatted, $data);
            }

            $res = [
                'code'      => 'success',
                'dataGuru'  => $formatted,
                'totalRows' => $this->GuruModel->getTotalRows($search)
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