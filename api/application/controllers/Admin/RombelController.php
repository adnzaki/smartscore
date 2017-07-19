<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

/**
 * Smartscore
 * Aplikasi Pengolahan Nilai Siswa berbasis Kurikulum 2013 untuk tingkat Sekolah Dasar (SD)
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License | https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 * @version     1.0.0
 */

class RombelController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('RombelModel');
    }

    public function fetchRombel($limit, $offset, $token = '')
    {
        if(empty($token))
        {            
            echo json_encode('Akses tidak diizinkan');
        }
        else 
        {
            if($this->hasValidToken($token))
            {
                $data = [
                    'rombel' => $this->RombelModel->getRombel($limit, $offset),
                    'baris' => $this->RombelModel->getTotalRows()
                ];
                echo json_encode($data);
            }
            else 
            {
                echo json_encode('Token tidak valid');
            }
        }        
    }
    
}
