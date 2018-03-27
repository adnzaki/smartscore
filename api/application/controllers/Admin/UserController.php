<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends SSController
{
    private function validatorMessages()
    {
        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('alpha_numeric', '{field} hanya boleh terdiri dari huruf dan angka');
        $this->form_validation->set_message('max_length', '%s tidak boleh lebih dari %s karakter');
        $this->form_validation->set_message('min_length', '%s tidak boleh kurang dari %s karakter');
        $this->form_validation->set_message('is_unique', '%s sudah pernah didaftarkan');
        $this->form_validation->set_message('valid_email', '{field} harus diisi dengan email yang valid');
        $this->form_validation->set_message('matches', '{field} yang anda masukkan tidak sama');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('UserModel');
        $this->validatorMessages();  
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

    public function insert($token = '')
    {
        if($this->hasValidToken($token))
        {
            $rules = [
                [
                    'field' => 'nama_pengguna',
                    'label' => 'Nama pengguna',
                    'rules' => 'required|min_length[3]|max_length[200]'
                ],
                [
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'required|min_length[3]|max_length[50]|is_unique[pengguna.username]|alpha_numeric'
                ],
                [
                    'field' => 'password_pengguna',
                    'label' => 'Password',
                    'rules' => 'required|min_length[6]|max_length[50]'
                ],
                [
                    'field' => 'konfirmasi_password',
                    'label' => 'Password',
                    'rules' => 'required|min_length[6]|max_length[50]|matches[password_pengguna]'
                ],
                [
                    'field' => 'email',
                    'label' => 'Alamat email',
                    'rules' => 'required|valid_email|is_unique[pengguna.email]'
                ],
            ];     
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() === false)
            {
                $error = [
                    'nama_pengguna'         => form_error('nama_pengguna'),
                    'username'              => form_error('username'),
                    'password_pengguna'     => form_error('password_pengguna'),
                    'konfirmasi_password'   => form_error('konfirmasi_password'),
                    'email'                 => form_error('email')
                ];
                echo json_encode($error);
            }
            else 
            {
                $this->UserModel->insert();
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

    public function resetPassword($id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $rules = [
                [
                    'field' => 'password_pengguna',
                    'label' => 'Password',
                    'rules' => 'required|min_length[6]|max_length[50]'
                ],
                [
                    'field' => 'konfirmasi_password',
                    'label' => 'Password',
                    'rules' => 'required|min_length[6]|max_length[50]|matches[password_pengguna]'
                ],
            ];     
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() === false)
            {
                $error = [
                    'password_pengguna'     => form_error('password_pengguna'),
                    'konfirmasi_password'   => form_error('konfirmasi_password'),
                ];
                echo json_encode($error);
            }
            else 
            {
                $this->UserModel->resetPassword($id);
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

    public function update($id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $rules = [
                [
                    'field' => 'nama_pengguna',
                    'label' => 'Nama pengguna',
                    'rules' => 'required|min_length[3]|max_length[200]'
                ],
                [
                    'field' => 'email',
                    'label' => 'Alamat email',
                    'rules' => 'required|valid_email'
                ],
            ];     
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() === false)
            {
                $error = [
                    'nama_pengguna'         => form_error('nama_pengguna'),
                    'email'                 => form_error('email')
                ];
                echo json_encode($error);
            }
            else 
            {
                $this->UserModel->update($id);
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

    public function editPengguna($id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            echo json_encode($this->UserModel->editPengguna($id));
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

}