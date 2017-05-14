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
 * OstiumCMS Common Helpers
 *
 * @package		Application
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Adnan Zaki
 * @version     1.0
 * @link		https://github.com/adnzaki/ostium_cms/
 */

// ------------------------------------------------------------------------

if(! function_exists('filter_link'))
{
    /**
     * Filter Link
     *
     * This function used to style a link that is currently active.
     *
     * @param mixed $target
     * @param string $word
     * @return string
     */
    function filter_link($target, $word)
    {
        // Get CodeIgniter instance object
        $CI =& get_instance();

        // Style to mark active link
        $current_link = ['<b style=color:#000;>', '</b>'];

        // Check whether $target is array or string
        is_array($target) ? $total = $CI->Posts_data->get_total_post() : $total = $CI->Posts_data->get_total_post($target);

        // Link output
        $active_link = $current_link[0] . $word . " (" . $total . ")" . $current_link[1];
        $inactive_link = $word . " (" . $total . ")";

        if(is_array($target))
        {
            if($CI->uri->segment(1) === $target[0] OR $CI->uri->segment(2) === $target[1] OR $CI->uri->segment(3) === $target[2])
            {
                $output = $active_link;
            }
            else
            {
                $output = $inactive_link;
            }
        }
        else
        {
            if($CI->uri->segment(3) === $target)
            {
                $output = $active_link;
            }
            else
            {
                $output = $inactive_link;
            }
        }

        return $output;
    }
}

if(! function_exists('multidimensional_array_unique'))
{
    /**
     * Multidimensional Array Unique
     * This function was taken from http://php.net/manual/en/function.array-unique.php
     * Thanks to Ghanshyam Katriya for creating this simple-but-cool function
     * It's used to get unique values of a multidimensional array
     *
     * @param array $array
     * @param string $key
     * @return array
     */
    function multidimensional_array_unique($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val)
        {
            if (!in_array($val[$key], $key_array))
            {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }

        return $temp_array;
    }
}

if(! function_exists('offset_generator'))
{
    /**
     * Offset Generator
     * Well, it's a little bit confusing to give the name of this function
     * But because it's related to offset, and return a number, I named it 'Offset Generator'
     *
     * @return int
     */
     function offset_generator()
     {
         $CI =& get_instance();
         $uri_length = $CI->uri->total_segments();

         if($uri_length === 3)
         {
             $offset = $CI->uri->segment(4);
         }
         elseif($uri_length === 4)
         {
             $offset = $CI->uri->segment(5);
         }
         elseif($uri_length === 5 OR $uri_length > 5)
         {
             $offset = $CI->uri->segment(6);
         }

         return $offset;
     }
}

if(! function_exists('check_session'))
{
    /**
     * Check Session
     * A function to check whether the session is exist or not
     *
     * @return bool
     */
     function check_session()
     {
         $CI =& get_instance();
         if($CI->session->has_userdata('username'))
         {
             return TRUE;
         }
         else
         {
             return FALSE;
         }
     }
}

if(! function_exists('in_assoc_array'))
{
    /**
     * In Assoc Array
     * This is a very simple function to check if a value exists in an associative array
     *
     * @param mixed $needle
     * @param array $array
     * @return bool
     */
    function in_assoc_array($needle, $array)
    {
        for($i = 0; $i < count($array); $i++)
        {
            if(in_array($needle, $array[$i]))
            {
                return TRUE;
            }
        }
    }
}

if(! function_exists('menu_active'))
{
    /**
     * Menu Active
     * A function to give a mark whether the menu items is current page
     *
     * @param string $uri
     * @return string
     */
    function menu_active($uri)
    {
        if(! strpos($_SERVER['PHP_SELF'], $uri))
        {
            $class = '';
        }
        else
        {
            $class = 'active';
        }

        return $class;
    }
}

if(! function_exists('user_data'))
{
    /**
     * User Data
     * Display some user data on the sidebar
     *
     * @param string $data
     * @return string
     */
    function user_data($data)
    {
        $CI =& get_instance();
        $query = $CI->db->get_where('os_user', ['user_login' => $CI->session->userdata('username')]);
        $user = $query->result_array();
        return $user[0][$data];
    }
}

if(! function_exists('reverse'))
{
    /**
     * Reverse
     * Reverse the word provided by user
     *
     * @param string $word
     * @param string $separator
     * @return string
     */
    function reverse($word, $separator)
    {
        $explode = explode($separator, $word);
        $reverseWord = '';
        $lastIndex = count($explode) - 1;
        for($i = 0; $i < count($explode); $i++)
        {
            if(count($explode) === 1)
            {
                $reverseWord .= $explode[$i];
            }
            else
            {
                $i === 0 ? $j = $lastIndex : $j = $lastIndex - $i;
                $reverseWord .= $explode[$j] . $separator;
            }
        }

        return substr($reverseWord, 0, strlen($reverseWord) - 1);
    }
}
