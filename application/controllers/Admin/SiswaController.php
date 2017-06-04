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

class SiswaController extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('SiswaModel');
    }

    public function fetchSiswa($limit, $start)
    {
        $data = $this->SiswaModel->getSiswa($limit, $start);
        $formatted = [];
        foreach($data as $data)
        {
            $data->tgl_lahir_siswa = $this->ostiumdate->format('d-Mm-y', reverse($data->tgl_lahir_siswa, '-', '-'));
            array_push($formatted, $data);
        }

        $res = [
            'dataSiswa' => $formatted,
            'totalRows' => $this->SiswaModel->getTotalRows()
        ];
        echo json_encode($res);
    }

    public function setSiswa($event, $key = '')
    {
        if($event === 'insert')
        {
            $is_unique = [
                '|is_unique[siswa.nis]',
                '|is_unique[siswa.nisn]',
            ];
        }
        else
        {
            $is_unique = ['', ''];
        }

        $rules = [
            [
                'field' => 'nama_siswa',
                'label' => 'nama siswa',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'nis',
                'label' => 'Nomor Induk Sekolah',
                'rules' => 'required'.$is_unique[0].'|exact_length[9]|numeric'
            ],
            [
                'field' => 'nisn',
                'label' => 'NISN',
                'rules' => 'required'.$is_unique[1].'|exact_length[10]|numeric'
            ],
            [
                'field' => 'tempat_lahir_siswa',
                'label' => 'tempat lahir',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'tgl_lahir_siswa',
                'label' => 'tanggal lahir',
                'rules' => 'required|exact_length[10]'
            ],
            [
                'field' => 'pend_sblm',
                'label' => 'pendidikan sebelumnya',
                'rules' => 'max_length[100]'
            ],
            [
                'field' => 'alamat_siswa',
                'label' => 'alamat siswa',
                'rules' => 'required|max_length[250]'
            ],
            [
                'field' => 'nama_ayah',
                'label' => 'nama ayah',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'nama_ibu',
                'label' => 'nama ibu',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'alamat_ortu',
                'label' => 'alamat orang tua',
                'rules' => 'required|max_length[255]'
            ],
            [
                'field' => 'telp_ortu',
                'label' => 'nomor telepon orang tua',
                'rules' => 'required|min_length[11]|max_length[15]|numeric'
            ],
            [
                'field' => 'nama_wali',
                'label' => 'nama wali',
                'rules' => 'max_length[50]'
            ],
            [
                'field' => 'alamat_wali',
                'label' => 'alamat wali',
                'rules' => 'max_length[255]'
            ],
            [
                'field' => 'telp_wali',
                'label' => 'nomor telepon wali',
                'rules' => 'min_length[11]|max_length[15]|numeric'
            ],
        ];

        $this->form_validation->set_rules($rules);
        $this->form_validation->set_message('required', 'Kolom {field} wajib diisi');
        $this->form_validation->set_message('max_length', 'Panjang kolom %s tidak boleh lebih dari %s karakter');
        $this->form_validation->set_message('min_length', 'Panjang kolom %s minimal %s karakter');
        $this->form_validation->set_message('exact_length', 'Panjang kolom %s harus %s karakter');
        $this->form_validation->set_message('numeric', 'Kolom {field} hanya boleh diisi angka');
        $this->form_validation->set_message('is_unique', 'Data %s sudah ada');
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() == FALSE)
        {
            $errors = [
                'nama_siswa'    => form_error('nama_siswa'),
                'nis'           => form_error('nis'),
                'nisn'          => form_error('nisn'),
                'tempat_lahir_siswa' => form_error('tempat_lahir_siswa'),
                'tgl_lahir_siswa' => form_error('tgl_lahir_siswa'),
                'pend_sblm'     => form_error('pend_sblm'),
                'alamat_siswa'  => form_error('alamat_siswa'),
                'nama_ayah'     => form_error('nama_ayah'),
                'nama_ibu'      => form_error('nama_ibu'),
                'alamat_ortu'   => form_error('alamat_ortu'),
                'telp_ortu'     => form_error('telp_ortu'),
                'nama_wali'     => form_error('nama_wali'),
                'alamat_wali'   => form_error('alamat_wali'),
                'telp_wali'     => form_error('telp_wali'),
            ];
            echo json_encode($errors);
        }
        else
        {
            if($event === 'insert')
            {
                $this->SiswaModel->insertSiswa();
            }
            elseif($event === 'update')
            {
                $this->SiswaModel->updateSiswa($key);
            }

            $data = [
                'msg'   => 'success',
                'id'    => $this->SiswaModel->getIdSiswa()
            ];
            echo json_encode($data);
        }
    }

    public function editSiswa($id)
    {
        $data = $this->SiswaModel->getDetailSiswa($id);
        $formatted = [];
        foreach($data as $data)
        {
            $data->tgl_lahir_siswa = reverse($data->tgl_lahir_siswa, '-', "/");
            array_push($formatted, $data);
        }
        echo json_encode($data);
    }

    public function deleteSiswa($id)
    {
        $this->SiswaModel->deleteSiswa($id);
    }

    public function importSiswa()
    {
        $config['upload_path']      = "./public/upload/";
        $config['allowed_types']    = 'xls|xlsx|csv';
        $config['max_size']         = 10000;
        $this->upload->initialize($config);
        if(! $this->upload->do_upload('file'))
        {
            echo json_encode(0);
        }
        else
        {
            $this->load->library('PHPExcel');
            $fileData = $this->upload->data();
            $fileInput = "./public/upload/".$fileData['file_name'];
            try
            {
                $objPHPExcel = PHPExcel_IOFactory::load($fileInput);
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }

            $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $numRows = count($worksheet);

            $importFailed = [];
            $importSuccess = [];

            for($i = 2; $i < ($numRows + 1); $i++)
            {
                $data = [
                    'nis'                   => $worksheet[$i]['C'],
                    'nisn'                  => $worksheet[$i]['D'],
                    'nama_siswa'            => $worksheet[$i]['E'],
                    'j_kelamin_siswa'       => $worksheet[$i]['F'],
                    'tempat_lahir_siswa'    => $worksheet[$i]['G'],
                    'tgl_lahir_siswa'       => $worksheet[$i]['H'],
                    'agama_siswa'           => $worksheet[$i]['I'],
                    'pend_sblm'             => $worksheet[$i]['J'],
                    'alamat_siswa'          => $worksheet[$i]['K'],
                    'nama_ayah'             => $worksheet[$i]['L'],
                    'nama_ibu'              => $worksheet[$i]['M'],
                    'job_ayah'              => $worksheet[$i]['N'],
                    'job_ibu'               => $worksheet[$i]['O'],
                    'alamat_ortu'           => $worksheet[$i]['P'],
                    'telp_ortu'             => $worksheet[$i]['Q'],
                    'nama_wali'             => $worksheet[$i]['R'],
                    'alamat_wali'           => $worksheet[$i]['S'],
                    'job_wali'              => $worksheet[$i]['T'],
                    'telp_wali'             => $worksheet[$i]['U'],
                ];

                $agama = [
                    'Islam', 'Katholik',
                    'Kristen Protestan',
                    'Hindu', 'Buddha'
                ];

                $jobAyah = [
                    'PNS', 'Karyawan Swasta', 'Wiraswasta',
                    'Buruh', 'Tidak Bekerja', 'Lain-lain'
                ];

                $jobIbu = [
                    'PNS', 'Karyawan Swasta', 'Wiraswasta',
                    'Buruh', 'Ibu Rumah Tangga', 'Lain-lain'
                ];

                if(
                    preg_match('/[^0-9]/', $data['nis']) === 1 OR preg_match('/[^0-9]/', $data['nisn']) === 1
                    OR (strlen($data['nis']) !== 9) OR (strlen($data['nisn']) !== 10)
                    OR isUnique($data['nis'], 'nis', 'siswa') OR isUnique($data['nisn'], 'nisn', 'siswa')
                    OR empty($data['nis']) OR empty($data['nisn']) OR empty($data['nama_siswa']) OR empty($data['j_kelamin_siswa'])
                    OR (strlen($data['j_kelamin_siswa']) !== 1) OR empty($data['tempat_lahir_siswa']) OR empty($data['tgl_lahir_siswa'])
                    OR !isValidDate($data['tgl_lahir_siswa']) OR empty($data['agama_siswa']) OR !in_array($data['agama_siswa'], $agama)
                    OR empty($data['alamat_siswa']) OR empty($data['nama_ayah']) OR empty($data['nama_ibu'])
                    OR empty($data['job_ayah']) OR empty($data['job_ibu']) OR !in_array($data['job_ayah'], $jobAyah) OR !in_array($data['job_ibu'], $jobIbu)
                    OR empty($data['alamat_ortu']) OR empty($data['telp_ortu']) OR preg_match('/[^0-9]/', $data['telp_ortu']) === 1
                    OR (strlen($data['telp_ortu']) < 11) OR (strlen($data['telp_ortu']) > 15)
                )
                {
                    array_push($importFailed, $i);
                }
                else
                {
                    $this->db->insert('siswa', $data);
                    array_push($importSuccess, $i);
                }
            }

            $status = [
                'failed'    => count($importFailed) . " data gagal diimpor",
                'success'   => count($importSuccess) . " data berhasil diimpor",
            ];
            delete_files($fileData['file_path']);
            echo json_encode($status);
        }
    }

}
