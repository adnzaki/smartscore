<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

/**
 * Smartscore
 * Aplikasi Sistem Pendukung Keputusan Pemilihan Siswa Berprestasi menggunakan metode 
 * Analytical Hierarchy Process (AHP) berdasarkan 5 kriteria penilaian yaitu 
 * rerata nilai rapor, absensi, keterampilan, sikap sosial dan sikap spiritual. 
 * Kriteria penilaian pada aplikasi Smartscore mengacu pada standar penilaian terbaru Kurikulum 2013.
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License | https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 * @version     1.0.0
 */

class SSController extends CI_Controller
{
    /** 
     * Core Class Constructor  
     * Load the JSON Web Token library for all children controller 
     *
     * @return void
     */
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('JWT/JWT');
        $this->load->helper('cookie');
    }    

    /**
     * Random Index
     * Random Index (RI) adalah nilai index acak yang telah ditentukan berdasarkan
     * teori Saaty.
     * 
     * @var array
     */

    protected $randomIndex = [
        '1' => 0, '2' => 0, '3' => 0.58,
        '4' => 0.9, '5' => 1.12, '6' => 1.24,
        '7' => 1.32, '8' => 1.41, '9' => 1.45,
        '10' => 1.49, '11' => 1.51
    ];

    /**
     * Has Valid Token?
     * Fungsi untuk mengecek apakah sebuah request memiliki token yang valid atau tidak 
     * 
     * @param string $token 
     * @param string $requestType
     * 
     * @return void|bool
     */
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