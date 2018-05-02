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

class PengaturanController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('PengaturanModel');
        $this->load->library('PDFGenerator');
    }

    public function setPasswordBaru($token)
    {
        if($this->hasValidToken($token))
        {
            $rules = [
                [
                    'field' => 'password-lama',
                    'label' => 'Password lama',
                    'rules' => 'required'
                ],
                [
                    'field' => 'password-baru',
                    'label' => 'Password baru',
                    'rules' => 'required|min_length[6]|max_length[50]'
                ],
                [
                    'field' => 'konfirmasi-password',
                    'label' => 'Konfirmasi password',
                    'rules' => 'required|matches[password-baru]'
                ],
            ];    
            $this->form_validation->set_rules($rules); 
            $this->form_validation->set_message('required', '{field} harus diisi');
            $this->form_validation->set_message('min_length', '%s tidak boleh kurang dari %s karakter');
            $this->form_validation->set_message('max_length', '%s tidak boleh lebih dari %s karakter');
            $this->form_validation->set_message('matches', '{field} tidak cocok');
            $this->form_validation->set_error_delimiters('', '');
            if($this->form_validation->run() === false)
            {
                $error = [
                    'passwordLama'          => form_error('password-lama'),
                    'passwordBaru'          => form_error('password-baru'),
                    'konfirmasiPassword'    => form_error('konfirmasi-password'),
                ];
    
                $res = [
                    'code' => 225,
                    'msg' => $error
                ];
                echo json_encode($res);
            }
            else 
            {
                $decoded = JWT::decode($token, 'user_key');
                $username = $decoded->username;
                $passwordLama = $this->input->post('password-lama', true);
                $passwordBaru = $this->input->post('password-baru', true);
                $check = $this->PengaturanModel->checkPasswordLama($username, $passwordLama);
                if(! $check)
                {
                    $res = [
                        'code' => 150,
                        'msg' => 'Password lama tidak sesuai'
                    ];
                    echo json_encode($res);
                }
                else 
                {
                    $this->PengaturanModel->setPasswordBaru($username, $passwordBaru);
                    $res = [
                        'code' => 25,
                        'msg' => 'Password telah diubah'
                    ];
                    echo json_encode($res);
                }
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

    public function simpanDataArsip($event, $id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $rules = [
                [
                    'field' => 'nama_arsip',
                    'label' => 'nama arsip',
                    'rules' => 'required|max_length[100]'
                ],
                [
                    'field' => 'tgl_arsip',
                    'label' => 'tanggal arsip',
                    'rules' => 'required|exact_length[10]'
                ],
            ];

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_message('required', 'Kolom {field} wajib diisi');
            $this->form_validation->set_message('max_length', 'Panjang kolom %s tidak boleh lebih dari %s karakter');
            $this->form_validation->set_message('exact_length', 'Panjang kolom %s harus %s karakter');
            $this->form_validation->set_error_delimiters('', '');
            
            if($this->form_validation->run() == FALSE)
            {
                echo json_encode([
                    'nama_arsip' => form_error('nama_arsip'),
                    'tgl_arsip' => form_error('tgl_arsip'),
                ]);
            }
            else 
            {
                if($event === 'insert' && $id === 'null')
                {
                    $prioritas = $this->prioritasSolusi();
                    $data = $prioritas['nilaiAlternatif'];
                    $arsip = $this->PengaturanModel->daftarArsip();
                    foreach($data as $key => $val)
                    {   
                        $value = [
                            'nama_siswa' => $key,
                            'nis_nisn' => $val['nis'].' / '.$val['nisn'],
                            'nilai_akhir' => $val['jumlah'],
                            'persentase' => $val['persentase'],
                            'id_arsip' => $arsip,
                        ];

                        $this->PengaturanModel->tambahArsip($value);
                    }

                    $this->PengaturanModel->hapusData();
                }
                elseif($event === 'update')
                {
                    $this->PengaturanModel->updateArsip($id);
                }
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

    public function getArsipNilai($id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $data = $this->PengaturanModel->getArsipNilai($id);
            $arsip = $this->PengaturanModel->getDetailArsip($id);
            function sortByScore($a, $b)
            {
                $a = $a->nilai_akhir;
                $b = $b->nilai_akhir;

                if ($a === $b) return 0;
                return ($a > $b) ? -1 : 1;
            }
            usort($data, 'sortByScore');
            echo json_encode([
                'arsip' => $arsip[0],
                'data' => $data,
            ]);
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

    public function cetakArsip($id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $data = $this->urls();
            $arsip = $this->PengaturanModel->getDetailArsip($id);
            $data['title'] = $arsip[0]->nama_arsip;
            $data['tanggal'] = $arsip[0]->tgl_arsip;
            $data['nilai'] = $this->PengaturanModel->getArsipNilai($id);
            function sortByScore($a, $b)
            {
                $a = $a->nilai_akhir;
                $b = $b->nilai_akhir;

                if ($a === $b) return 0;
                return ($a > $b) ? -1 : 1;
            }
            usort($data['nilai'], 'sortByScore');
            $html           = $this->load->view('laporan/arsip-nilai', $data, true);
            $filename       = 'Arsip_'.$data['title'].'_'.time();
            $this->pdfgenerator->create($html, $filename, true, 'A4', 'portrait');
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

    public function getDetailArsip($id, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $data = $this->PengaturanModel->getDetailArsip($id);
            $formatted = $data[0];
            $formatted->tgl_arsip = reverse($formatted->tgl_arsip, '-', '/');
            echo json_encode($formatted);
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

    public function getArsip($limit, $offset, $token = '', $search = '')
    {
        if($this->hasValidToken($token))
        {
            $data = $this->PengaturanModel->getArsip($limit, $offset, $search);
            $formatted = [];
            foreach($data as $res)
            {
                $res->tgl_arsip = $this->ostiumdate->format('d-Mm-y', reverse($res->tgl_arsip, '-', '-'));
                array_push($formatted, $res);
            }
            echo json_encode([
                'response' => $formatted,
                'rows' => $this->PengaturanModel->getArsipRows($search),
            ]);
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