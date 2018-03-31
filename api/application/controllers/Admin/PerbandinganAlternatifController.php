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
            $alternatif = $this->AlternatifModel->getDaftarAlternatif();
            $result = $this->countResult($kriteria);
            $data = [];
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

    public function cetakPrioritasSolusi()
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

    private function prioritasSolusi()
    {
        $kriteria = $this->KriteriaModel->getKriteria();
        $alternatif = $this->AlternatifModel->getDaftarAlternatif();
        $eigenAlternatif = [];
        $eigenKriteria = [];
        foreach($kriteria as $res)
        {
            $getResult = $this->countResult($res->id_kriteria);

            // mengambil nilai eigen alternatif
            $eigenAlternatif[$res->id_kriteria] = $getResult['eigen'];

            // ambil nilai eigen dari kriteria yang sedang di-loop
            $eigenKriteria[$res->id_kriteria] = $res->eigen_value;
        }

        $eigenXalternatif = [];
        foreach($kriteria as $res)
        {
            // buat empty array dengan index diberi nama sesuai id_kriteria
            $wrapper = [$res->id_kriteria => []];

            // lakukan loop sebanyak data pada array $alternatif
            // untuk mengisi empty array $wrapper yang telah dibuat sebelumnya
            for($i = 0; $i < count($alternatif); $i++)
            {
                $hasil = $eigenAlternatif[$res->id_kriteria][$i] * $eigenKriteria[$res->id_kriteria];
                array_push($wrapper[$res->id_kriteria], number_format($hasil, 3));
            }
            $eigenXalternatif[] = $wrapper;
        }

        $nilaiAlternatif = [];
        $nilaiAkhir = [];

        // loop data alternatif 
        // untuk mendapatkan perkalian eigen tiap kriteria 
        for($j = 0; $j < count($alternatif); $j++)
        {
            $jumlahWrapper = [];
            $inc = 0;
            // jumlahkan hasil perkalian semua eigen pada tiap alternatif 
            foreach($kriteria as $res)
            {
                array_push($jumlahWrapper, $eigenXalternatif[$inc][$res->id_kriteria][$j]);
                $inc++;
            }
            // wrapping data...
            $nilaiAlternatif[$alternatif[$j]->nama_siswa]['namaSiswa'] = $alternatif[$j]->nama_siswa;
            $nilaiAlternatif[$alternatif[$j]->nama_siswa]['nilaiKriteria'] = $jumlahWrapper;
            $nilaiAlternatif[$alternatif[$j]->nama_siswa]['jumlah'] = number_format(array_sum($nilaiAlternatif[$alternatif[$j]->nama_siswa]['nilaiKriteria']), 3);
            $nilaiAlternatif[$alternatif[$j]->nama_siswa]['persentase'] = number_format($nilaiAlternatif[$alternatif[$j]->nama_siswa]['jumlah'] * 100, 1);
            $nilaiAlternatif[$alternatif[$j]->nama_siswa]['nis'] = $alternatif[$j]->nis;
            $nilaiAlternatif[$alternatif[$j]->nama_siswa]['nisn'] = $alternatif[$j]->nisn;
            $nilaiAkhir[$j]['nilai'] = number_format(array_sum($nilaiAlternatif[$alternatif[$j]->nama_siswa]['nilaiKriteria']), 3);
            $nilaiAkhir[$j]['siswa'] = $alternatif[$j]->nama_siswa;
        }

        $nilaiTertinggi = max($nilaiAkhir);

        $jumlahNilai = [];

        foreach($nilaiAkhir as $nilai)
        {
            $jumlahNilai[] = $nilai['nilai'];
        }
        
        $jumlahNilaiAkhir = number_format(array_sum($jumlahNilai), 3);

        $allCR = [];
        $consistencyLimit = count($alternatif) / 100;
        foreach($kriteria as $res)
        {
            $cr = $this->countResult($res->id_kriteria);
            $allCR[] = $cr['CR'];
        }

        $inconsistentCR = array_filter($allCR, function($item) use ($consistencyLimit) {
            return $item > $consistencyLimit;
        });
        
        if(count($inconsistentCR) === 0 && $jumlahNilaiAkhir > 0)
        {
            $keterangan = 'Semua perbandingan alternatif terhadap kriteria konsisten dan dapat diterima.';
        }
        elseif(count($inconsistentCR) === 0 && (string)$jumlahNilaiAkhir === "0.000")
        {
            $keterangan = 'Jumlah nilai perbandingan belum dihitung, silakan lengkapi perbandingan terlebih dahulu';
        }
        elseif(count($inconsistentCR) > 0)
        {
            $keterangan = 'Terdapat '.count($inconsistentCR).' perbandingan alternatif terhadap kriteria 
            yang tidak konsisten dan tidak dapat dijadikan acuan pengambilan keputusan';
        }

        $response = [
            'eigenAlternatif' => $eigenAlternatif,
            'eigenKriteria' => $eigenKriteria,
            'eigenXalternatif' => $eigenXalternatif,
            'nilaiAlternatif' => $nilaiAlternatif,
            'nilaiAkhir' => $nilaiAkhir,
            'nilaiTertinggi' => $nilaiTertinggi,
            'jumlahNilaiAkhir' => $jumlahNilaiAkhir,
            'inconsistentCR' => count($inconsistentCR),
            'keterangan' => $keterangan,
        ];

        return $response;        
    }

    private function countResult($kriteria)
    {
        $column = $this->sumColumn($kriteria);
        $alternatif = $this->AlternatifModel->getDaftarAlternatif();
        $dataLength = $this->AlternatifModel->perbandinganAlternatifRows();
        $idSiswa = [];
        $eigen = [];
        $normalize = [];
        foreach ($alternatif as $key) 
        {
            $idSiswa[] = $key->id_siswa;
        }

        foreach($alternatif as $res)
        {
            $pembanding = $this->AlternatifModel->getPembanding($res->id_siswa, 'id_siswa', $kriteria);
            $container = [];
            $i = 0;
            foreach($pembanding as $col)
            {
                $container[] = $col->nilai_perbandingan;
            }

            $normalize[$res->id_siswa] = $container;
            $wrapper = [];
            for($j = 0; $j < count($normalize); $j++)
            {
                $temp = [];
                for($k = 0; $k < count($normalize[$idSiswa[$j]]); $k++)
                {
                    $divider = $column[$idSiswa[$k]];
                    $hasil = $normalize[$idSiswa[$j]][$k] / $divider;
                    $temp[] = number_format($hasil, 2);
                }
                $wrapper[] = $temp;
            }
        }

        $wrapperLength = count($wrapper);

        if($dataLength === 0)
        {
            $response = [
                'normalize' => $normalize,
                'sumColumn' => $column,
                'alternatif' => $alternatif,
                'dataLength' => $dataLength,
            ];

        }
        else 
        {
            for($x = 0; $x < $wrapperLength; $x++)
            {
                $eigen[] = number_format((array_sum($wrapper[$x]) / $wrapperLength), 2);
            }

            $eigenXcolumn = [];
            for($y = 0; $y < count($idSiswa); $y++)
            {
                $eigenXcolumn[] = number_format(($column[$idSiswa[$y]] * $eigen[$y]), 3);
            }

            $maxEigen = array_sum($eigenXcolumn);

            $consistencyIndex = ($maxEigen - count($alternatif)) / (count($alternatif) - 1);

            $consistencyRatio = $consistencyIndex / $this->randomIndex[count($alternatif)];

            $consistencyLimit = count($alternatif) / 100;

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
                'alternatif'=> $alternatif,
                'dataLength' => $wrapperLength,
            ];
        }        

        return $response;
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

    private function sumColumn(int $kriteria): array
    {
        $alternatif = $this->AlternatifModel->getDaftarAlternatif();
        $result = [];
        foreach($alternatif as $res)
        {
            $pembanding = $this->AlternatifModel->getPembanding($res->id_siswa, 'pembanding', $kriteria);
            $container = [];
            foreach($pembanding as $col)
            {            
                $container[] = $col->nilai_perbandingan;
            }
            $result[$res->id_siswa] = number_format(array_sum($container), 2);
        }            
        return $result; 
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