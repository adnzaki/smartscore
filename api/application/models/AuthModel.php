<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model
{
    static protected $ci;

    static protected $table = 'pengguna';

    public function __construct()
    {
        parent:: __construct();
        self::$ci =& get_instance();
    }
    public static function isValidUser()
    {
        $user = self::$ci->input->post('username', true);
        $pass = self::$ci->input->post('password', true);

        $query = self::$ci->db->get_where(self::$table, [
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

    public static function setStatus($mode, $username)
    {
        ($mode === 'login') ? $status = 'online' : $status = 'offline';
        
        self::$ci->db->update(self::$table, [
            'network_status' => $status
        ], ['username' => $username]);
    }

    public static function getStatus($username)
    {
        return self::$ci->db->select('status_pengguna')->from(self::$table)
                ->where('username', $username)->get()->result();
    }

    public static function getTahunAjaran()
    {
        $query = self::$ci->db->get('tahun_ajaran');
        return $query->result();
    }
}