<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Custom_Rules 
 * 
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license 
 */
class Custom_Rules {

    /**
     * __construct 
     * 
     * @access protected
     * @return void
     */
    function __construct() {
        $ci =& get_instance();
        $ci->lang->load('custom_rules');
    }

    /**
     * Is the string contain any alphabet
     * 
     * @param string $str 
     * @access public
     * @return boolean 
     */
    public function rule_is_str_contain_alphabet($object, $field, $param = '') {
        $error_msg = $object->{$field} . " ";
        $error_msg = . lang('custom_rules_must_contain_at_least_one_alphabet');

        // if the given input is not string, straight away false
        if (!is_string($object->{$field}))
            return $error_msg;

        $is_valid = false;

        foreach ($object->{$field} as $c) {
            if (!is_int($c)) { // NOT YET COMPLETE
                $is_valid = true;
                break;
            }
        }
        return $is_valid ? true : $error_msg;
    }
}
