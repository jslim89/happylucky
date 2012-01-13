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
                redirect(site_url());
            }
            else {
                $this->session->set_flashdata('login_error', lang('customer_invalid_customer_name_or_password'));
                redirect(site_url('user/login'));
            }
        }
        else {
            $this->load_view('account/login', $this->vars);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(site_url());
    }

    public function get_details_in_json($id) {
        $customer = new Customer_Model($id);
        $arr_cust = $customer->to_array();
        unset($arr_cust['password']);
        unset($arr_cust['salt']);
        unset($arr_cust['security_answer']);
        echo json_encode($customer->to_array());
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
