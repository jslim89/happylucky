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
        $this->load->Model('user_model');
        $this->load->Model('country_model');
    }

    public function index($page = 0) {
        $q = get_post('q');
        $user = new User_Model();
        list($users, $total_rows) = (empty($q)) 
            ? $user->get_paged(10, $page)
            : $user->search_related($q, 10, $page);
        /* Pagination */
        $this->vars['pagination'] = $user->get_pagination($total_rows, 10);
        $pagin_first              = ($total_rows == 0) ? $page : $page + 1;
        $pagin_last               = (($page + 10) < $total_rows) ? ($page + 10) : $total_rows;
        $this->vars['pagin']      = $pagin_first.' - '.$pagin_last.' '.lang('of').' '.$total_rows;

        $this->vars['title'] = lang('user_management');
        $this->vars['users'] = $users;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('admin/user/index'),
        );
        $this->load_view('admin/user/list', $this->vars);
    }

    public function add() {
        // Set an empty object as the user variable is required
        $this->vars['title'] = lang('user_add_new_user');
        $user = new User_Model();
        $this->vars['user'] = $user;
        $this->load_view('admin/user/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('user_edit_user');
        $user = new User_Model($id);
        $this->vars['user'] = $user;
        $this->load_view('admin/user/add_edit', $this->vars);
    }

    public function save($id = null) {
        $user = new User_Model($id);
        $user->populate_from_request($_POST);

        if(get_post('password')) {
            $is_match = $user->match_password(get_post('old_password'));
            if( ! $is_match) {
                $this->session->set_flashdata('general_error', lang('user_password_does_not_match'));
                redirect('admin/user/edit/'.$user->id);
            }
            else {
                $user->update_password(get_post('password'));
            }
        }

        if($user->save()) {
            $success = ($id === null) ? lang('inserted') : lang('updated');
            $this->session->set_flashdata('general_success', $success);
            redirect('admin/user/edit/'.$user->id);
        }
        else {
            $error = ($id === null) ? lang('insert_failed') : lang('update_failed');
            $this->session->set_flashdata('general_error', $error);
            redirect('admin/user/index');
        }
    }

    public function delete($id) {
        $user = new User_Model($id);
        $status = $user->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function ajax_search() {
        $q = get_post('term');
        $user_set = $this->user_model->search_related($q, false, false, false);
        echo json_encode($user_set);
    }

    private function _send_activation_mail($user) {
        $this->load->library('email');

        $this->email->from('happylucky@jslim.co.cc');
        $this->email->to('jslim89@msn.com');
        $this->email->subject('testing');
        $this->email->message('just for testing');
        $this->email->send();
        echo $this->email->print_debugger();
    }

    public function check_email() {
        $email = get_post('fieldValue');
        $is_unique = User_Model::is_email_unique($email);
        $to_js = array(
            get_post('fieldId'),
            $is_unique,
            lang('email_already_been_used')
        );
        echo json_encode($to_js);
    }
}
