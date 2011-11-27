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

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function index() {
        if(get_session('user_id'))
            redirect('admin/dashboard');
        else {
            $this->load->view('admin/login');
        }
    }

    public function login() {
        if(count($_POST)) {
            $this->load->model('admin_model', 'user');
            $user = new Admin_Model();

            $user->email    = get_post('email');
            $user->password = get_post('password');

            $success = $user->login();
            if($success) {
                $session = array(
                    'user_id'   => $user->id,
                    'password'  => $user->password,
                    'user_type' => 'ADMIN'
                );
                $this->session->set_userdata($session);
                redirect('admin/dashboard');
            }
            else {
                $this->session->set_flashdata('login_error', lang('user_invalid_username_or_password'));
                redirect('admin');
            }
        }
        redirect('admin');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('admin');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
