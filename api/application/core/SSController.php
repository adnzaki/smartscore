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
     * URLs 
     * Fungsi yang mempermudah ke beberapa URL dala API Smartscore
     * 
     * @return array
     */
    protected function urls()
    {
        return [
            'public' => base_url('public/'),
        ];
    }

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
    
    /**
     * Prioritas Solusi 
     * Fungsi untuk menghitung hasil akhir perbandingan alternatif 
     * terhadap kriteria yang disebut dengan prioritas solusi dalam metode AHP 
     * 
     * @return array
     */
    protected function prioritasSolusi()
    {
        $this->load->model(['AlternatifModel', 'KriteriaModel']);
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
            $nilaiAlternatif[$alternatif[$j]->nama_siswa]['idSiswa'] = $alternatif[$j]->id_siswa;
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

    /**
     * Count Result 
     * Fungsi untuk menghitung hasil perbandingan alternatif terhadap masing-masing kriteria 
     * 
     * @param int $kriteria 
     * 
     * @return array
     */
    protected function countResult($kriteria)
    {
        $column = $this->sumColumn($kriteria);
        $alternatif = $this->AlternatifModel->getDaftarAlternatif();
        $dataLength = $this->AlternatifModel->perbandinganAlternatifRows();
        $idSiswa = [];
        $eigen = [];
        $normalize = [];
        foreach ($column as $key => $val) 
        {
            $idSiswa[] = $key;
        }

        foreach($alternatif as $res)
        {
            $wrapper = [];
            if($this->AlternatifModel->hasComparison($res->id_siswa))
            {
                $pembanding = $this->AlternatifModel->getPembanding($res->id_siswa, 'id_siswa', $kriteria);
                $container = [];
                $i = 0;
                foreach($pembanding as $col)
                {
                    $container[] = $col->nilai_perbandingan;
                }
    
                $normalize[$res->id_siswa] = $container;                
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

            if(count($alternatif) === 1)
            {
                $consistencyIndex = 0;
            }
            else 
            {
                $consistencyIndex = ($maxEigen - count($alternatif)) / (count($alternatif) - 1);
            }

            if($this->randomIndex[count($alternatif)] === 0)
            {
                $consistencyRatio = 0;
            }
            else 
            {
                $consistencyRatio = $consistencyIndex / $this->randomIndex[count($alternatif)];
            }            

            $consistencyLimit = count($alternatif) / 100;

            $isConsistent = '';
            ($consistencyRatio < $consistencyLimit) ? $isConsistent = 'Konsistensi dapat diterima' 
                                                    : $isConsistent = 'Perbandingan tidak konsisten.';

            $response = [
                'normalize' => $normalize,
                'sumResult' => $wrapper,
                'sumColumn' => $column,
                'eigen' => $eigen,
                'eigenXcolumn' => $eigenXcolumn,
                'maxEigen' => $maxEigen,
                'CI' => number_format($consistencyIndex, 3),
                'CR' => number_format($consistencyRatio, 3),
                'konsistensi' => $isConsistent,
                'alternatif'=> $alternatif,
                'dataLength' => $wrapperLength,
            ];
        }        

        return $response;
    } 

    /**
     * Sum Column 
     * Fungsi untuk menjumlahkan nilai pada masing-masing kolom perbandingan 
     * 
     * @param int $kriteria 
     * 
     * @return array
     */
    protected function sumColumn(int $kriteria): array
    {
        $alternatif = $this->AlternatifModel->getDaftarAlternatif();
        $result = [];
        $x = 0;
        foreach($alternatif as $res)
        {
            if($this->AlternatifModel->hasComparison($res->id_siswa))
            {
                $pembanding = $this->AlternatifModel->getPembanding($res->id_siswa, 'pembanding', $kriteria);
                $container = [];
                foreach($pembanding as $col)
                {            
                    $container[] = $col->nilai_perbandingan;
                }
                $result[$res->id_siswa] = number_format(array_sum($container), 2);
            }
        }            
        return $result; 
    }
}