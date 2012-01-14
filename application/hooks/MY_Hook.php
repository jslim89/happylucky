<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Hook {

    function post_controller_constructor() {
        $ci =& get_instance();

        $dir   = $ci->router->directory;
        $class = $ci->router->class;

        switch($dir) {
            case 'admin/':
                if($class != 'welcome') {
                    if(!get_session('user_id')) {
                        redirect('admin/welcome');
                    }
                }
                break;
            default:
                if(get_cookie('customer_id') && !get_session('customer_id')) {
                    $ci->load->model('customer_model');
                    $customer = new Customer_Model(get_cookie('customer_id'));
                    $session = array(
                        'customer_id' => $customer->id,
                        'password'    => $customer->password,
                        'username'    => $customer->first_name.', '.$customer->last_name,
                    );
                    $ci->session->set_userdata($session);
                }
                break;
        }
    }
}
