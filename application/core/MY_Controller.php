<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Controller 
 * 
 * @uses Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license 
 */
class MY_Controller extends CI_Controller {

    var $vars = array();
	
	function __construct () {
		parent::__construct ();
		
		$this->lang->load ('general');
		$this->lang->load ('user');
	}
	
    /**
     * Header and Footer are loaded automatically, user only pass in the 
     * content. 
     * 
     * @param mixed $view 
     * @param mixed $vars 
     * @param mixed $rendered 
     * @access public
     * @return void
     */
	function load_view ($view, $vars = array(), $rendered = false) {
        $this->vars = array_merge($vars, $this->vars);
		$this->load->view ('common/header', $vars, $rendered);
        if(!$this->_is_admin_template())
            $this->load->view('common/user-body', $vars, $rendered);
        else
            $this->load->view('common/admin-body', $vars, $rendered);
		$this->load->view ($view, $vars, $rendered);			
		$this->load->view ('common/footer', $vars, $rendered);
	}

    private function _is_admin_template() {
        return $this->router->directory == 'admin/';
    }
}	
