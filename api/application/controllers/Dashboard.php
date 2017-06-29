<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
    }

    public function index()
    {
        $data = [
            'css'   => base_url('public/css/'),
            'js'    => base_url('public/js/'),
            'fonts' => base_url('public/fonts/'),
            'img'   => base_url('public/img/'),
            'base_url' => base_url(),
            'title' => 'Smartscore App',
            'welcome_message'   => 'Selamat Datang di Smartscore',
            'app_description'   => 'Aplikasi Pengolahan Nilai Siswa berbasis Kurikulum 2013 untuk tingkat Sekolah Dasar'
        ];
        $this->parser->parse('home', $data);
    }

}
