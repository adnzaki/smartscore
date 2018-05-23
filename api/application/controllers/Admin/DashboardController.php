<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class DashboardController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model(['AlternatifModel', 'UserModel', 'SiswaModel']);
    }

    public function getData($token = '')
    {
        if($this->hasValidToken($token))
        {
            $decoded = JWT::decode($token, 'user_key');
            $response = [
                'alternatif' => $this->AlternatifModel->getAlternatifRows(),
                'onlineUser' => $this->UserModel->getOnlineUser($decoded->username),
                'cekAlternatif' => ($this->SiswaModel->checkAlternatif()) ? 1 : 0,
            ];
            echo json_encode($response);
        }
        else 
        {
            echo json_encode([
                'code'  => 0,
                'msg'   => lang('unableToGetData')
            ]);
        }
    }
}