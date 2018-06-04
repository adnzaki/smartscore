<?php defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class PerbandinganKriteriaController extends SSController
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('KriteriaModel');
    }

    public function getDaftarKriteria($token)
    {
        if($this->hasValidToken($token))
        {
            $kriteria = $this->KriteriaModel->getKriteria();
            echo json_encode($kriteria);
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

    public function getPerbandingan($token)
    {
        if($this->hasValidToken($token))
        {
            $kriteria = $this->KriteriaModel->getKriteria();
            $data = [];
            $result = $this->countKriteriaResult();
            foreach($kriteria as $res)
            {
                $data[$res->nama_kriteria] = $this->KriteriaModel->getPerbandingan($res->id_kriteria);
            }

            $dataLengthWrapper = [];
            foreach($kriteria as $res)
            {
                $dataLengthWrapper[] = count($data[$res->nama_kriteria]);
            }

            $filled = array_filter($dataLengthWrapper, function($item) {
                return $item > 0;
            });

            $res = [
                'kriteria' => $data,
                'rows' => $this->KriteriaModel->getKriteriaRows(),
                'filled' => count($filled),
                'jumlahKolom' => $result['sumColumn'],
            ];
    
            echo json_encode($res);
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

    public function getKriteriaToCompare($kriteriID, $token = '')
    {
        if($this->hasValidToken($token))
        {
            $kriteria = $this->KriteriaModel->getSelectedKriteria($kriteriID);
            echo json_encode($kriteria);
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

    public function getComparisonResult($token = '')
    {
        if($this->hasValidToken($token))
        {
            $kriteria = $this->KriteriaModel->getKriteria();
            $result = $this->countKriteriaResult();
            $data = [];
            for($i = 0; $i < count($kriteria); $i++)
            {
                $data[$kriteria[$i]->nama_kriteria]['angka'] = $result['sumResult'][$i];
                $data[$kriteria[$i]->nama_kriteria]['eigen'] = $result['eigen'][$i];
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

    public function getKriteriaName($idKriteria, $token)
    {
        if($this->hasValidToken($token))
        {
            $kriteria = $this->KriteriaModel->getDetailKriteria($idKriteria);
            echo $kriteria->nama_kriteria;
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

    public function save($token)
    {
        if($this->hasValidToken($token))
        {
            $data = $this->input->post('nilai-perbandingan', true);
            $arr = explode('-', $data);
            for($i = 0; $i < count($arr); $i++)
            {
                if(empty($arr[$i]))
                {
                    break;
                }
                else 
                {
                    $value = explode('+', $arr[$i]);
                    $this->KriteriaModel->setNilaiPerbandingan($value[0], $value[1], $value[2]);
                }
            }
            
            $getEigen = $this->countKriteriaResult();
            foreach($getEigen['kriteria'] as $res)
            {
                $this->KriteriaModel->setEigenValue($res->eigen_value, $res->id_kriteria);
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

    private function countKriteriaResult()
    {
        $column = $this->sumKriteriaColumn();
        $kriteria = $this->KriteriaModel->getKriteria();
        $kriteriaLength = count($kriteria);
        $perbandinganLength = $this->KriteriaModel->getPerbandinganRows();
        $idKriteria = [];
        $eigen = [];
        $normalize = [];
        $wrapper = [];
        foreach ($kriteria as $key) 
        {
            $idKriteria[] = $key->id_kriteria;
        }

        foreach($kriteria as $res)
        {
            $pembanding = $this->KriteriaModel->getPembanding($res->id_kriteria, 'id_kriteria');
            $container = [];

            foreach($pembanding as $col)
            {
                $container[] = $col->nilai_perbandingan;
            }

            $normalize[$res->id_kriteria] = $container;
            $wrapper = [];
            for($j = 0; $j < count($normalize); $j++)
            {
                $temp = [];
                for($k = 0; $k < count($normalize[$idKriteria[$j]]); $k++)
                {
                    $divider = $column[$idKriteria[$k]];
                    $hasil = $normalize[$idKriteria[$j]][$k] / $divider;
                    $temp[] = number_format($hasil, 3);
                }
                $wrapper[] = $temp;
            }
        }

        $wrapperLength = count($wrapper);

        if($perbandinganLength === 0)
        {
            $response = [
                'normalize' => $normalize,
                'sumColumn' => $column,
                'kriteria' => $kriteria,
                'perbandinganLength' => $perbandinganLength,
            ];

        }
        else 
        {
            for($x = 0; $x < $wrapperLength; $x++)
            {
                $eigen[] = number_format((array_sum($wrapper[$x]) / $wrapperLength), 3);
                $kriteria[$x]->eigen_value = $eigen[$x];
            }

            $eigenXcolumn = [];
            for($y = 0; $y < count($idKriteria); $y++)
            {
                $eigenXcolumn[] = number_format(($column[$idKriteria[$y]] * $eigen[$y]), 3);
            }

            $maxEigen = array_sum($eigenXcolumn);

            $consistencyIndex = ($maxEigen - $kriteriaLength) / ($kriteriaLength - 1);

            if($this->randomIndex[$kriteriaLength] === 0)
            {
                $consistencyRatio = 0;
            }
            else 
            {
                $consistencyRatio = $consistencyIndex / $this->randomIndex[$kriteriaLength];
            }

            $consistencyLimit = $kriteriaLength / 100;

            $isConsistent = '';
            ($consistencyRatio < $consistencyLimit) ? $isConsistent = 'Konsistensi dapat diterima' 
                                                    : $isConsistent = 'Perbandingan tidak konsisten.';

            $response = [
                'normalize' => $normalize,
                'sumResult' => $wrapper,
                'sumColumn' => $column,
                'eigen' => $eigen,
                'maxEigen' => $maxEigen,
                'eigenXcolumn' => $eigenXcolumn,
                'CI' => number_format($consistencyIndex, 3),
                'CR' => number_format($consistencyRatio, 3),
                'konsistensi' => $isConsistent,
                'kriteria' => $kriteria,
            ];
        }        

        return $response;
    }

    private function sumKriteriaColumn()
    {
        $kriteria = $this->KriteriaModel->getKriteria();
        $result = [];
        foreach($kriteria as $res)
        {
            $pembanding = $this->KriteriaModel->getPembanding($res->id_kriteria, 'pembanding');
            $container = [];
            foreach($pembanding as $col)
            {            
                $container[] = $col->nilai_perbandingan;
            }
            $result[$res->id_kriteria] = number_format(array_sum($container), 2);
        }            
        return $result;             
    }
}