<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('UserModel');
    }

    public function getUser($limit, $start, $token = '', $search = '')
    {
        if($this->hasValidToken($token))
        {
            $data = $this->UserModel->getUser($limit, $start, $search);
            $rows = $this->UserModel->getTotalRows($search);
            echo json_encode([
                'code' => 'success',
                'data' => $data,
                'rows' => $rows,
            ]);
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