<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class User extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('user');
        $this->load->Model('customer_model');
        $this->load->Model('country_model');
    }

	public function index() {
	}

    public function register() {
        $customer = new Customer_Model();
        $customer->populate_from_request($_POST);
        $this->vars['title'] = lang('user_registration');
        $this->load_view('account/register', $this->vars);
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
