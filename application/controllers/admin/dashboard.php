<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dashboard 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Dashboard extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('dashboard');
        $this->load->model('dashboard_model', 'dashboard');
    }

    function index() {
        $vars['title'] = lang('dashboard');
        $vars['widgets'] = $this->dashboard->get_widgets();
        $vars['pending_orders'] = array();
        $vars['stocks'] = array();
        $this->load_view('admin/dashboard/index', $vars);
    }
}
