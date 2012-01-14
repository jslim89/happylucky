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
        $this->load->library('email');
    }

	public function index() {
        $customer = new Customer_Model(1);
	}

    public function register() {
        if($_POST) {
            $customer = new Customer_Model();
            $customer->populate_from_request($_POST);
            $customer->register();

            $link = anchor(
                site_url('user/verify/'.$customer->id).'?vcode='.$customer->generate_verification_code(),
                site_url('user/verify/'.$customer->id).'?vcode='.$customer->generate_verification_code()
            );

            /* Send Email */
            $subject = lang('user_email_verification_subject');
            $message = lang('user_email_verification_message_before_link');
            $message .= $link;
            $message .= lang('user_email_verification_message_after_link');
            $this->email->from('test.jslim89@qq.com', 'Mr Happy Lucky');
            $this->email->to($customer->email);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();
            /* End Send Email */

            $session = array(
                'customer_id' => $customer->id,
                'password'    => $customer->password,
                'username'    => $customer->first_name.', '.$customer->last_name,
            );
            $this->session->set_userdata($session);
            redirect(site_url());

            $this->vars['timeout'] = 10;
            $this->vars['content'] = lang('user_please_check_your_email_for_your_account_verification');
            $this->vars['url']     = site_url('');
            $this->load_view('common/temp', $this->vars);
        }
        else {
            $this->vars['title'] = lang('user_registration');
            $this->load_view('account/register', $this->vars);
        }
    }

    public function verify($id) {
        $code = get_post('vcode');
        $customer = new Customer_Model($id);
        if($customer->verify($code)) {
            $msg = lang('user_verify_successful_message');
        }
        else {
            $msg = lang('user_verify_failed_message');
        }
        $this->vars['content'] = $msg;
        $this->vars['timeout'] = 10;
        $this->vars['url']     = site_url('');
        $this->load_view('common/temp', $this->vars);
    }

    public function forgot_password() {
        $this->vars['title'] = lang('user_forgot_password');
        if(count($_POST)) {
        }
        else {
            $this->load_view('account/forgot_password', $this->vars);
        }
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
                $this->session->set_userdata($session);
                if(get_post('remember_me', false)) {
                    set_cookie(array(
                        'name'   => 'customer_id',
                        'value'  => $customer->id,
                        'expire' => days_to_seconds(7),
                    ));
                }
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
        // delete a cookie
        set_cookie(array(
            'name'   => 'customer_id',
            'expire' => false,
        ));
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

    public function get_security_question() {
        $customer = new Customer_Model();
        $customer->load_by_email(get_post('email'));
        $result = array();
        if($customer->is_exist()) {
            $result['status']            = 1;
            $result['security_question'] = $customer->security_question;
        }
        else {
            $result['status'] = 0;
        }
        echo json_encode($result);
    }

    public function check_security_answer() {
        $customer = new Customer_Model();
        $customer->load_by_email(get_post('email'));
        $result = array();
        if(strtolower($customer->security_answer) === strtolower(get_post('answer'))) {
            /* Send Email */
            $subject = lang('user_email_password_recovery_subject');
            $message = lang('user_email_password_recovery_message_before_password');
            $message .= $customer->generate_new_password();
            $message .= lang('user_email_password_recovery_message_after_password');
            $this->email->from('test.jslim89@qq.com', 'Mr Happy Lucky');
            $this->email->to($customer->email);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();
            /* End Send Email */

            $result['response_text'] = lang('user_correct_answer_response_text');
        }
        else {
            $result['response_text'] = lang('user_incorrect_answer_response_text');
        }
        echo json_encode($result);
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
