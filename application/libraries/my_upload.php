<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Upload 
 * 
 * @uses CI_Upload
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class MY_Upload extends CI_Upload {

    /**
     * Upload multiple files 
     * REFERENCE: http://codeigniter.com/forums/viewthread/94695/
     * 
     * @param mixed $files 
     * @access public
     * @return mixed
     */
    public function multi_upload($files) {
        if(count($files) < 1) return false;

        $errors = $successes = array();

        foreach($files as $key => $file) {
            if( ! $this->do_upload($file)) {
                $errors[$file] = $this->error_msg[$key];
            }
            else {
                $successes[$file] = $this->data();
            }
        }
        return array($errors, $successes);
    }
}
