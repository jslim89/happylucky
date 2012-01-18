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
        if(!get_session('customer_id')) redirect(site_url('user/login'));
        $customer = new Customer_Model(get_session('customer_id'));
        $this->vars['title']    = lang('user_account');
        $this->vars['customer'] = $customer;
        $this->load_view('account/index', $this->vars);
	}

    public function register() {
        if(get_session('customer_id')) {
            redirect('user');
        }
        if($_POST) {
            $customer = new Customer_Model();
            $customer->populate_from_request($_POST);
            $ok = $customer->register();

            $this->_send_code($customer);

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

    public function edit($id) {
        $customer = new Customer_Model($id);
        switch(get_post('category')) {
            case 'password':
                $this->_edit_password($customer);
                break;
            case 'address':
                $this->_edit_address($customer);
                break;
            case 'personal':
                $this->_edit_personal($customer);
                break;
        }
    }

    private function _edit_password($customer) {
        if($_POST) {
            $customer->update_password(get_post('password'));
            redirect('user');
        }
        else {
            $this->vars['title'] = lang('user_edit_password');
            $this->load_view('account/edit_password', $this->vars);
        }
    }

    private function _edit_address($customer) {
        if($_POST) {
            $customer->populate_from_request($_POST);
            $customer->save();
            redirect('user');
        }
        else {
            $this->vars['customer'] = $customer;
            $this->vars['title']    = lang('user_edit_address_information');
            $this->load_view('account/edit_address', $this->vars);
        }
    }

    private function _edit_personal($customer) {
        if($_POST) {
            $customer->populate_from_request($_POST);
            $customer->save();
            redirect('user');
        }
        else {
            $this->vars['customer'] = $customer;
            $this->vars['title']    = lang('user_edit_personal_details');
            $this->load_view('account/edit_personal', $this->vars);
        }
    }

    /**
     * _send_code 
     * 
     * @param mixed $customer 
     * @return boolean
     */
    private function _send_code($customer) {
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
        $ok = $this->email->send();
        $this->email->clear();
        /* End Send Email */
        return $ok;
    }

    /**
     * ajax verification 
     * 
     * @return void
     */
    public function send_verification_code($id) {
        $customer = new Customer_Model($id);
        $ok = $this->_send_code($customer);
        echo json_encode(array('status' => $ok));
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
                $this->session->set_flashdata('login_error', lang('user_invalid_username_or_password'));
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

    /**
     * ajax verification 
     * 
     * @return void
     */
    public function verify_password() {
        $customer = new Customer_Model(get_session('customer_id'));
        $password = get_post('fieldValue');
        $match = $customer->match_password($password);
        $to_js = array(
            get_post('fieldId'),
            $match,
        );
        echo json_encode($to_js);
    }

    public function check_email() {
        $email = get_post('fieldValue');
        $is_unique = Customer_Model::is_email_unique($email);
        $to_js = array(
            get_post('fieldId'),
            $is_unique
        );
        echo json_encode($to_js);
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
