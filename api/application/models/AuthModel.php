<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model
{
    static protected $ci;

    public function __construct()
    {
        parent:: __construct();
        self::$ci =& get_instance();
    }
    public static function isValidUser()
    {
        $user = self::$ci->input->post('username', true);
        $pass = self::$ci->input->post('password', true);

        $query = self::$ci->db->get_where('pengguna', [
            'username' => $user,
        ]);

        if($query->num_rows() > 0)
        {
            $query = $query->result();
            if(password_verify($pass, $query[0]->password_pengguna))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public static function getStatus($username)
    {
        return self::$ci->db->select('status_pengguna')->from('pengguna')
                ->where('username', $username)->get()->result();
    }

    public static function getTahunAjaran()
    {
        $query = self::$ci->db->get('tahun_ajaran');
        return $query->result();
    }
}