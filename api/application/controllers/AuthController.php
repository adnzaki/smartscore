<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class AuthController extends SSController 
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('AuthModel');
    }

    public function validate()
    {
        $user = $this->input->post('username', true);
        $pass = $this->input->post('password', true);
        if(AuthModel::isValidUser($user, $pass)) 
        {            
            $token = [
                'username' => $user
            ];
            $encoded = JWT::encode($token, 'user_key');
            set_cookie('ss_session', $encoded, 3600, '', '/', '', false, true);
            $cookie = get_cookie('ss_session');
            $res = [
                'code' => 1,
                'msg' => 'Login berhasil, mengalihkan halaman...',
                'cookie' => $encoded
            ];
        }
        else 
        {
            $res = [
                'code' => 0,
                'msg' => 'Username atau password yang anda masukkan salah'
            ];
        }

        echo json_encode($res);
    }
    
    public function logout() 
    {
        delete_cookie('ss_session');
        header('Location: http://localhost:8080/');
    }

}