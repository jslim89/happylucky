<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Convert double format to currency value.
 * Reference: http://www.php.net/manual/en/function.money-format.php#98783
 * 
 * @param mixed $value 
 * @param mixed $symbol 
 * @param int $decimal 
 * @access public
 * @return string
 */
if (!function_exists('to_currency')) {
    function to_currency($value, $symbol = false, $decimal = 2) {
        $number = sprintf("%.".$decimal."f", $value);
        while (true) { 
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
            if ($replaced != $number) { 
                $number = $replaced; 
            } else { 
                break; 
            } 
        }
        return (!$symbol) ? $number : $symbol . " " . $number;
    }
}
