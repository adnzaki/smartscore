<?php

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

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Smartscore Common Helpers
 *
 * @package		Application
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Adnan Zaki
 * @version     1.0
 * @link		https://github.com/adnzaki/ostium_cms/
 */

// ------------------------------------------------------------------------

if(! function_exists('isValidDate'))
{
    /**
     * Is Valid Date?
     * Fungsi untuk mengecek apakah input tanggal dari user
     * merupakan format yang valid atau tidak.
     * Untuk saat ini hanya mendukung format YYYY-MM-DD
     *
     * @param string $date
     * @return bool
     */
    function isValidDate($date)
    {
        $CI =& get_instance();
        if(empty($date))
        {
            return false;
        }
        else
        {
            if(preg_match('/[^0-9-]/', $date, $matches) === 1)
            {
                return false;
            }
            else
            {
                $array = explode("-", $date);
                if(strlen($array[0]) !== 4 OR strlen($array[1]) !== 2 OR strlen($array[2]) !== 2)
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
    }
}

if(! function_exists('isUnique'))
{
    /**
     * Is Unique?
     * Fungsi untuk memfilter masukan dari user
     * apakah sudah ada dalam database atau tidak
     *
     * @param mixed $input
     * @param string $column
     * @param string $table
     * @return bool
     */
    function isUnique($input, $column, $table)
    {
        $root =& get_instance();
        $query = $root->db->select($column)->from($table)
            ->where($column, $input);
        $res = $query->get();
        if($res->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
