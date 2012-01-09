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

    public function login() {
        if(count($_POST)) {
            $customer = new Customer_Model();

            $customer->email    = get_post('email');
            $customer->password = get_post('password');

            $success = $customer->login();
            if($success) {
                $session = array(
                    'customer_id' => $customer->id,
                    'password'    => $customer->password,
                    'username'    => $customer->first_name.', '.$customer->last_name,
                );
                $this->session->set_customerdata($session);
                redirect('admin/dashboard');
            }
            else {
                $this->session->set_flashdata('login_error', lang('customer_invalid_customername_or_password'));
                redirect('home');
            }
        }
        redirect('home');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('home');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
