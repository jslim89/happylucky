<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Customer 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Customer extends MY_Controller {

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

    public function index($page = 0) {
        $q = get_post('q');
        $customer = new Customer_Model();
        list($customers, $total_rows) = (empty($q)) 
            ? $customer->get_paged(10, $page)
            : $customer->search_related($q, 10, $page);
        $this->vars['pagination'] = $customer->get_pagination($total_rows, 10);
        $this->vars['title'] = lang('customer_management');
        $this->vars['customers'] = $customers;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('admin/customer/index'),
        );
        $this->load_view('admin/customer/list', $this->vars);
    }

    public function add() {
        // Set an empty object as the customer variable is required
        $this->vars['title'] = lang('user_new_customer');
        $customer = new Customer_Model();
        $this->vars['customer'] = $customer;
        $this->load_view('admin/customer/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('edit');
        $customer = new Customer_Model($id);
        $this->vars['customer'] = $customer;
        $this->load_view('admin/customer/add_edit', $this->vars);
    }

    public function save($id = null) {
        $customer = new Customer_Model($id);
        // If is add new
        if( ! $customer->is_exist()) {
            $customer->populate_from_request($_POST);
            $status = $customer->register();
        }
        else {
            if(get_post('password')) {
                $is_match = $customer->match_password(get_post('old_password'));
                if($is_match) {
                    $customer->update_password(get_post('password'));
                }
                else {
                    $this->session->set_flashdata('password_not_match', lang('user_password_does_not_match'));
                    redirect('admin/customer/edit/'.$customer->id);
                }
            }
            unset($_POST['password']);
            $customer->populate_from_request($_POST);
            $status = $customer->save();
        }

        if($status) {
            $this->session->set_flashdata('record_saved', lang('updated'));
            redirect('admin/customer/edit/'.$customer->id);
        }
        else
            redirect('admin/customer');
    }

    public function delete($id) {
        $customer = new Customer_Model($id);
        $status = $customer->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function ajax_search() {
        $q = get_post('term');
        $customer_set = $this->customer_model->search_related($q, false, false, false);
        echo json_encode($customer_set);
    }

    private function _send_activation_mail($customer) {
        $this->load->library('email');

        $this->email->from('happylucky@jslim.co.cc');
        $this->email->to('jslim89@msn.com');
        $this->email->subject('testing');
        $this->email->message('just for testing');
        $this->email->send();
        echo $this->email->print_debugger();
    }
}
