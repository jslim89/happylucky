<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Information 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Information extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

	public function index()
	{
    }

    public function about_us() {
        $this->load_view('information/about_us', $this->vars);
    }

    public function delivery_info() {
        $this->load_view('information/delivery_info', $this->vars);
    }

    public function privacy_and_policy() {
        $this->load_view('information/privacy_and_policy', $this->vars);
    }

    public function terms_and_conditions() {
        $this->load_view('information/terms_and_conditions', $this->vars);
    }

    public function contact_us() {
        $this->load_view('information/contact_us', $this->vars);
    }

    public function ordering() {
        $this->load_view('information/ordering', $this->vars);
    }
}

/* End of file information.php */
/* Location: ./application/controllers/information.php */
