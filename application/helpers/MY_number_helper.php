<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Convert double format to currency value.
 * 
 * @param mixed $value 
 * @param int $decimal 
 * @param string $symbol 
 * @access public
 * @return string
 */
if (!function_exists('to_currency')) {
    function to_currency($value, $decimal = 2, $symbol = 'RM') {
        return $symbol . " " . sprintf("%.".$decimal."f", $value);
    }
}
