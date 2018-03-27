<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class DashboardController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model(['AlternatifModel', 'UserModel']);
    }

    public function getData($token = '')
    {
        if($this->hasValidToken($token))
        {
            $response = [
                'alternatif' => $this->AlternatifModel->getAlternatifRows(),
                'onlineUser' => $this->UserModel->getOnlineUser(),
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