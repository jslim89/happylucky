<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get the file name recursively together with its path 
 * 
 * @param mixed $path 
 * @access public
 * @return array
 */
if(!function_exists('get_files_recursive')) {
    function get_files_recursive($path, $extension = '') {
        $files = get_filenames($path, true);
        $ret = array();
        foreach($files as $file) {
            $temp = explode($path, $file);
            $before_filter = $temp[count($temp)-1];
            $sub_start = strlen($before_filter) - strlen($extension);
            if(substr($before_filter, $sub_start) == $extension)
                $ret[] = $before_filter;
        }
        return $ret;
    }
}
