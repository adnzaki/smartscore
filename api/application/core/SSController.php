<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class SSController extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('JWT/JWT');
        $this->load->helper('cookie');
    }    

    public function hasValidToken($token = '', $requestType = 'php')
    {
        if(empty($token))
        {
            if($requestType === 'php')
            {
                return false;
            }
            else 
            {
                echo '0';
            }
        }
        else 
        {
            try
            {
                $decoded = JWT::decode($token, 'user_key');
                $msg = 'Token valid untuk ' . json_encode($decoded);
                $res = ['code' => 1, 'msg' => $msg];
                if($requestType === 'php')
                {
                    return true;
                }
                else 
                {
                    echo '1';
                }
            }
            catch(Exception $e)
            {
                echo json_encode($e->getMessage());
            }      
        }              
    }    
    
}