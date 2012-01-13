<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Welcome 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Welcome extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

	public function index()
	{
        $this->load->model('customer_model');
		$this->load_view('home');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
