<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model
{
    static protected $ci;

    public function __construct()
    {
        parent:: __construct();
        self::$ci =& get_instance();
    }
    public static function isValidUser($user, $pass)
    {
        $query = self::$ci->db->get_where('pengguna', [
            'user_id' => $user,
            'password_pengguna' => $pass
        ]);

        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function getTahunAjaran()
    {
        $query = self::$ci->db->get('tahun_ajaran');
        return $query->result();
    }
}