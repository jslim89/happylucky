<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Convert the string DateTime format to unix timestamp
 * 
 * @param mixed $date_time 
 * @param int $default 
 * @access public
 * @return int
 */
if (!function_exists('to_unix_time')) {
    function to_unix_time($date_time, $default = 0) {
        $time = strtotime($date_time);
        return ($time) ? $default : $time;
    }
}

/**
 * Convert the unix timestamp to human readable Date format
 * 
 * @param mixed $time 
 * @param string $format 
 * @access public
 * @return string 
 */
if (!function_exists('to_human_time')) {
    function to_human_date($date, $format = '%j %F %Y') {
        return (is_int($date)) ? mdate($format, $date) : mdate($format, (int)$date);
    }
}

/**
 * Convert the unix timestamp to human readable DateTime format
 * 
 * @param mixed $time 
 * @param string $format 
 * @access public
 * @return string
 */
if (!function_exists('to_human_date_time')) {
    function to_human_date_time($time, $format = '%j %F %Y %h:%i:%A') {
        return to_human_date($time, $format);
    }
}
/**
 * Compute the difference between 2 date in second.
 * 
 * @param mixed $date1 
 * @param mixed $date2 
 * @access public
 * @return int
 */
if (!function_exists('second_difference')) {
    function second_difference($date1, $date2) {
        if (is_string($date1))
            $date1 = strtotime($date1);
        if (is_string($date2))
            $date2 = strtotime($date2);

        $diff = abs($date1 - $date2);
        return $diff;
    }
}

/**
 * Compute the difference between 2 date in day
 * 
 * @param mixed $date1 
 * @param mixed $date2 
 * @access public
 * @return int
 */
if (!function_exists('day_difference')) {
    function day_difference($date1, $date2) {
        $diff = second_difference($date1, $date2);
        return floor($diff/(60*60*24));
    }
}

/**
 * Compute the difference between 2 date in month
 * 
 * @param mixed $date1 
 * @param mixed $date2 
 * @access public
 * @return int
 */
if (!function_exists('month_difference')) {
    function month_difference($date1, $date2) {
        $diff = second_difference($date1, $date2);
        return floor($diff/(60*60*24*12));
    }
}
