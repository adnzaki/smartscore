<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class PerbandinganAlternatifController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model(['AlternatifModel', 'KriteriaModel']);
        $this->load->library('PDFGenerator');
    }

    public function getDaftarAlternatif($token)
    {
        if($this->hasValidToken($token))
        {
            $alternatif = $this->AlternatifModel->getDaftarAlternatif();
            echo json_encode($alternatif);
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

    public function getAlternatif($kriteria, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $alternatif = $this->AlternatifModel->getDaftarAlternatif();
            $data = [];
            $result = $this->countResult($kriteria);
            foreach($alternatif as $res)
            {
                $data[$res->nama_siswa] = $this->AlternatifModel->getPerbandingan($res->id_siswa, $kriteria);                
            }      
            
            $dataLengthWrapper = [];
            foreach($alternatif as $res)
            {
                $dataLengthWrapper[] = count($data[$res->nama_siswa]);
            }

            $filled = array_filter($dataLengthWrapper, function($item) {
                return $item > 0;
            });

            $sumColumn = [];
            foreach($result['sumColumn'] as $res => $val)
            {
                $sumColumn[] = $val;
            }
    
            echo json_encode([
                'alternatif' => $data,
                'filled' => count($filled),
                'jumlahKolom' => $sumColumn,
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

    public function getAlternatifToCompare($idSiswa, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $alternatif = $this->AlternatifModel->getSelectedAlternatif($idSiswa);
            echo json_encode($alternatif);
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

    public function getAlternatifName($idSiswa, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $siswa = $this->AlternatifModel->getAlternatifName($idSiswa);
            echo $siswa[0]->nama_siswa;
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

    public function save($kriteria, $token)
    {
        if($this->hasValidToken($token))
        {
            $data = $this->input->post('nilai-perbandingan', true);
            $arr = explode('-', $data);
            for($i = 0; $i < count($arr); $i++)
            {
                $value = explode('+', $arr[$i]);
                // AlternatifModel::setNilaiPerbandingan($kriteria, $siswa, $pembanding, $value)
                $this->AlternatifModel->setNilaiPerbandingan($kriteria, $value[0], $value[1], $value[2]);
            }
            echo json_encode('success');
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

    public function getComparisonResult($kriteria, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $daftarAlternatif = $this->AlternatifModel->getDaftarAlternatif();
            $alternatif = [];
            $result = $this->countResult($kriteria);
            $data = [];

            foreach($daftarAlternatif as $da)
            {
                if($this->AlternatifModel->hasComparison($da->id_siswa))
                {
                    $alternatif[] = $da;
                }
            }

            for($i = 0; $i < count($alternatif); $i++)
            {
                $data[$alternatif[$i]->nama_siswa]['angka'] = $result['sumResult'][$i];
                $data[$alternatif[$i]->nama_siswa]['eigen'] = $result['eigen'][$i];
            }

            echo json_encode([
                'hasil' => $data,
                'CR' => $result['CR'],
                'konsistensi' => $result['konsistensi'],
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

    public function cetakPrioritasSolusi($token = '')
    {
        if($this->hasValidToken($token))
        {
            $data = $this->urls();
            $data['title'] = 'Laporan Hasil Perbandingan';
            $prioritas = $this->prioritasSolusi();
            $data['prioritas'] = $prioritas['nilaiAlternatif'];
            
            function sortByScore($a, $b)
            {
                $a = $a['jumlah'];
                $b = $b['jumlah'];
    
                if ($a === $b) return 0;
                return ($a > $b) ? -1 : 1;
            }
            usort($data['prioritas'], 'sortByScore');
    
            $html           = $this->load->view('laporan/prioritas-solusi', $data, true);
            $filename       = 'Laporan Perbandingan_'.time();
            $this->pdfgenerator->create($html, $filename, true, 'A4', 'portrait');            
        }
        {
            $res = [
                'code'  => 0,
                'msg'   => lang('unableToGetData')
            ];
            echo json_encode($res);
        }   
    }

    public function getTigaBesar($token = '')
    {
        if($this->hasValidToken($token))
        {
            $prioritas = $this->prioritasSolusi();
            $data['prioritas'] = $prioritas['nilaiAlternatif'];
            function sortByScore($a, $b)
            {
                $a = $a['jumlah'];
                $b = $b['jumlah'];

                if ($a === $b) return 0;
                return ($a > $b) ? -1 : 1;
            }
            usort($data['prioritas'], 'sortByScore');
            echo json_encode($data['prioritas']);
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

    public function getPrioritasSolusi($token = '')
    {
        if($this->hasValidToken($token))
        {
            echo json_encode($this->prioritasSolusi());
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

    public function getSumColumn($kriteria, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $result = $this->sumColumn($kriteria);
            echo json_encode($result);
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

    public function getKriteria($token)
    {
        if($this->hasValidToken($token))
        {
            echo json_encode($this->KriteriaModel->getKriteria());
        }
        else 
        {
            echo json_encode([
                'code'  => 0,
                'msg'   => lang('unableToGetData')
            ]);
        }
    }
}