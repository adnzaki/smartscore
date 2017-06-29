<?php

/**
 * OstiumCMS
 * A simple, fast and extensible Content Management System
 * for website made by Wolestech (Software Development Agency)
 *
 * @copyright   Copyright (c) 2016-2017, Wolestech | Adnan Zaki
 * @license     MIT License | https://github.com/adnzaki/ostium_cms/blob/master/LICENSE
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * OstiumCMS Indonesia Date Class
 *
 * Menyediakan sekumpulan fungsi untuk menampilkan tanggal dengan format berbahasa Indonesia
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Adnan Zaki
 * @link		http://wolestech.com
 */

class OstiumDate
{
    /**
     * Pemanggil fungsi getdate()
     *
     * @var array()
     */
    protected $date;

    /**
     * Nama-nama hari dalam bahasa Indonesia
     *
     * @var array()
     */
    protected $dayName = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');

    /**
     * Nama-nama bulan dalam bahasa Indonesia
     *
     * @var array()
     */
    protected $monthName = array(
        1 => 'Januari', 2 => 'Februari',    3 => 'Maret',
        4 => 'April',   5 => 'Mei',         6 => 'Juni',
        7 => 'Juli',    8 => 'Agustus',     9 => 'September',
        10 => 'Oktober', 11 => 'November',  12 => 'Desember',
    );

    /**
     * Memanggil fungsi getdate()
     *
     * @return array
     */
    public function __construct()
    {
        $this->date = getdate();
    }

    /**
     * Mengambil nama hari ini
     *
     * @return string
     */
    protected function getDayName()
    {
        $day = $this->date['wday'];

        return $this->dayName[$day];
    }

    /**
     * Mengambil nama bulan
     *
     * @param mixed $mon
     * @return string
     */
    protected function getMonthName($mon = '')
    {
        if(empty($mon))
        {
            $mon = $this->date['mon'];
        }

        return $this->monthName[$mon];
    }

    protected function error($option, $hint)
    {
        $error = [
            'date' => "Invalid date input: <b>" . $hint . "</b>",
            'format' => "Invalid date format: <b>" . $hint . "</b",
        ];

        return $error[$option];
    }

    // --------------------------- DATE SETTER ----------------------------------------

    /**
     * Set tanggal dengan tampilan lengkap
     * Misalnya: Sabtu, 1 Oktober 2016
     * Format: fullDate(1, 10, 2016)
     * Jika argumen kosong akan menampilkan tanggal hari ini
     *
     * @param mixed $date
     * @param mixed $month
     * @param mixed $year
     * @return string
     */
    public function fullDate($date = '', $month = '', $year ='')
    {
        if(empty($date) && empty($month) && empty($year))
        {
            $day = $this->getDayName();
            $date = $this->date['mday'];
            $month = $this->getMonthName();
            $year = $this->date['year'];
        }
        else
        {
            if(! $this->dateValidation($date, $month, $year))
            {
                $hint = $date . "-" . $month . "-" . $year;
                return $this->error('date', $hint);
            }
            else
            {
                $date = intval($date);
                $month = intval($month);
                $day = $this->setDay($date, $month, $year);
                $month = $this->getMonthName($month);
            }
        }

        return $day . ", " . $date . " " . $month . " " . $year;
    }

    /**
     * Set tanggal dengan tampilan ringkas
     * Misalnya: 26-12-2016
     * Format: shortDate(26, 12, 2016, '-')
     * Jika argumen kosong akan menampilkan tanggal hari ini,
     * dengan pemisah tanggal default adalah tanda strip (-)
     *
     * @param mixed $date
     * @param mixed $month
     * @param mixed $year
     * @param string $separator
     * @return string
     */
    public function shortDate($date = '', $month = '', $year = '', $separator = '-')
    {
        if(empty($date) && empty($month) && empty($year))
        {
            $mon = $this->date['mon'];
            $mon < 10 ? $mon = '0' . $mon : $mon = $mon;

            $monthDay = $this->date['mday'];
            $monthDay < 10 ? $monthDay = '0' . $monthDay : $monthDay = $monthDay;

            return $monthDay . $separator . $mon . $separator . $this->date['year'];
        }
        else
        {
            if(! $this->dateValidation($date, $month, $year))
            {
                $hint = $date . "-" . $month . "-" . $year;
                return $this->error('date', $hint);
            }
            else
            {
                $date   = intval($date);
                $month  = intval($month);
                $date < 10 ? $date = 0 . $date : $date = $date;
                $month < 10 ? $month = 0 . $month : $month = $month;
            }

            return $date . $separator . $month . $separator . $year;
        }
    }

    /**
     * Format tanggal khusus dengan pilihan format d, D, Dd, m, M, Mm, Y
     * Contoh: 'd' = 26, 'D' = Sen, 26, 'Dd' = Senin, 26
     *         'm' = 12, 'M' = Des, Mm = Desember, Y = 2016
     * Contoh eksekusi: format('D-M-Y', '1-9-2016', '-')
     * akan menampilkan hasil: Kam, 1-Sep-2016
     * => argumen ke-3 akan menghasilkan spasi jika dikosongkan
     *
     * @param string $pattern
     * @param string $date
     * @param string $separator
     * @return string
     */
    public function format($pattern, $date, $separator = " ")
    {
        $date   = explode("-", $date);
        $day    = intval($date[0]);
        $month  = intval($date[1]);
        $year   = $date[2];
        
        if(! $this->dateValidation($day, $month, $year))
        {
            $hint = $day . "-" . $month . "-" . $year;
            return $this->error('date', $hint);
        }
        elseif(! strpos($pattern, '-'))
        {
            return $this->error('format', $pattern);
        }
        else
        {
            $pattern = explode("-", $pattern);
            if(sizeof($pattern) < 3)
            {
                $hint = $pattern[0];
            }
            else
            {
                $hint = $pattern[0] . "-" . $pattern[1] . "-" . $pattern[2];
            }

            if($pattern[0] === 'd')
            {
                $day < 10 ? $day = 0 . $day : $day = $day;
                $output = $day;
            }
            elseif($pattern[0] === 'D')
            {
                $dayName = $this->setDay($day, $month, $year);
                $dayName = substr($dayName, 0, 3);
                $output = $dayName . ", " . $day;
            }
            elseif($pattern[0] === 'Dd')
            {
                $dayName = $this->setDay($day, $month, $year);
                $output = $dayName . ", " . $day;
            }
            else
            {
                return $this->error('format', $hint);
            }

            if($pattern[1] === 'm')
            {
                $month < 10 ? $month = '0' . $month : $month = $month;
                $output .= $separator . $month;
            }
            elseif($pattern[1] === 'M')
            {
                $month = $this->getMonthName($month);
                $month = substr($month, 0, 3);
                $output .= $separator . $month;
            }
            elseif($pattern[1] === 'Mm')
            {
                $month = $this->getMonthName($month);
                $output .= $separator . $month;
            }
            else
            {
                return $this->error('format', $hint);
            }

            if($pattern[2] === 'y' OR $pattern[2] === 'Y')
            {
                $output .= $separator . $year;
            }
            else
            {
                return $this->error('format', $hint);
            }
        }

        return $output;
    }

    /**
     * Fungsi ini berperan dalam menampilkan nama hari
     * berdasarkan input dari user.
     *
     * @param int $date
     * @param int $month
     * @param int $year
     * @return string
     */
    protected function setDay($date, $month, $year)
    {
        $day = date("l", mktime(0,0,0, $month, $date, $year));
        switch($day)
        {
            case 'Sunday':      $day = $this->dayName[0]; break;
            case 'Monday':      $day = $this->dayName[1]; break;
            case 'Tuesday':     $day = $this->dayName[2]; break;
            case 'Wednesday':   $day = $this->dayName[3]; break;
            case 'Thursday':    $day = $this->dayName[4]; break;
            case 'Friday':      $day = $this->dayName[5]; break;
            case 'Saturday':    $day = $this->dayName[6]; break;
            default: 'Not a date'; break;
        }

        return $day;
    }

    /**
     * Validasi input tanggal dan bulan
     *
     * @param int $date
     * @param int $month
     * @param int $year
     * @return bool
     */
    protected function dateValidation($date, $month, $year)
    {
        if($month > 12 OR $month < 1 OR $date > $this->daysInMonth($month, $year) OR $date < 1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Fungsi yang digunakan untuk mengambil jumlah hari dalam bulan
     * yang diinput untuk divalidasi oleh fungsi dateValidation()
     *
     * @param int $month
     * @param int $year
     * @return int
     */
    protected function daysInMonth($month, $year)
    {
        $totalDays = [
            1 => 31, 2 => $this->daysOfFebruary($year), 3 => 31,
            4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 30,
            9 => 30, 10 => 31, 11 => 30, 12 => 31
        ];

        return $totalDays[$month];
    }

    /**
     * Fungsi yang digunakan untuk mengetahui jumlah hari di bulan Februari
     * apakah berjumlah 28 hari atau 29 hari jika pada tahun kabisat
     *
     * @param int $year
     * @return int
     */
    protected function daysOfFebruary($year)
    {
        return ($year % 4 === 0) ? $days = 29 : $days = 28;
    }

}
