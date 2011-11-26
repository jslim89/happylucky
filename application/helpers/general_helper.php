<?php if (!defined('BASEPATH')) exit('No direct script access allowed!');

/**
 * A debug function which is easy to type and search. 
 * 
 * @param mixed $obj 
 * @param mixed $die 
 * @access public
 * @return void
 */
if (!function_exists('xxx')) {
    function xxx($obj, $die = false) {
        echo "<pre>";
        print_r($obj);
        echo "</pre>";

        if ($die) die();
    }
}

/**
 * This function is same as xxx, but the output is shown on firebug (firefox 
 * plugin). This is useful when there is ajax request and response.
 *
 * To enable this to work, please put the following line to .htaccess first 
 * line.
 * SetEnv APPLICATION_ENV "development"
 *
 * @param mixed $obj 
 * @param mixed $die 
 * @access public
 * @return void
 */
if (!function_exists('firelog')) {
    function firelog($obj, $die = false) {
        $ci =& get_instance();
        $ci->load->library('firephp');

        if (getenv('APPLICATION_ENV') != 'development') 
            $ci->firephp->setEnabled(false);
        $ci->firephp->log($obj);
    }
}

/**
 * Get the session value
 * 
 * @param mixed $key 
 * @param mixed $default 
 * @access public
 * @return mixed
 */
if (!function_exists('get_session')) {
    function get_session($key, $default = null) {
        $ci =& get_instance();
        $ci->load->library('session');
        $value = $ci->session->userdata($key);
        return ($value === false) ? $default : $value;
    }
}

/**
 * Confirm dialog box will be prompt out once this function is call
 * 
 * @param mixed $msg 
 * @param int $default 
 * @access public
 * @return bool
 */
if (!function_exists('confirm')) {
    function confirm($msg, $default = 0) {
        $output = "<div id='dialog-confirm' title='".lang('confirm_delete')."'>";
        $output .= "\n\t<p><span class='ui-icon ui-icon-alert'";
        $output .= " style='float:left; margin: 0 7px 20px 0;'>";
        $output .= "</span>".$msg."</p>\n</div>";
    }
}

/**
 * Message dialog box will be display out.
 * 
 * @param mixed $msg 
 * @access public
 * @return void
 */
if (!function_exists('alert')) {
    function alert($msg) {
        $output = "<script>";
        $output .= "</script>";

        echo $output;
    }
}

/**
 * get_post 
 * 
 * @param mixed $key 
 * @param mixed $default 
 * @param mixed $xss 
 * @access public
 * @return mixed
 */
if (!function_exists ('get_post')) {
	function get_post ($key, $default = null, $xss = false) {
		$CI = & get_instance ();
		$CI->load->library ('input');
		
		$value[0] = $CI->input->get_post ($key, $xss);

		if ($value[0] || $value[0].""=="0") {
			// do nothing
		}
		else {
			$value[0] = $default;
		}
		return $value[0];
	}
}

/**
 * get_post_date 
 * 
 * @param mixed $key 
 * @param mixed $default 
 * @access public
 * @return int 
 */
if (!function_exists ('get_post_date')) {
	function get_post_date ($key, $default = null) {
		if ($date = get_post ($key, $default)) {
			return to_unix_time($date);
		}
		return $default;
	}
}

/**
 * get_session 
 * 
 * @param mixed $key 
 * @param mixed $default 
 * @access public
 * @return mixed 
 */
if (!function_exists ('get_session')) {
	function get_session ($key, $default = null) {
		$CI = & get_instance ();
		$CI->load->library ('session');
		$value = $CI->session->userdata ($key);
        if ( $value === FALSE ) return $default;
        return $value;
	}
}
// 
// if (!function_exists('firelog')) {
// }
