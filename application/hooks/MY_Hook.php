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
                if($class != 'welcome') {
                    if(!get_session('user_id')) {
                        redirect('welcome');
                    }
                }
                break;
        }
    }
}
