<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Monk 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Monk extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('monk');
        $this->load->Model('monk_model');
        $this->load->Model('monk_image_model');
    }

    public function index($page = 0) {
        $q = get_post('q');
        $monk = new Monk_Model();
        list($monks, $total_rows) = (empty($q)) 
            ? $monk->get_paged(10, $page)
            : $monk->search_related($q, 10, $page);
        $this->vars['pagination'] = $monk->get_pagination($total_rows, 10, 3);
        $this->vars['title'] = lang('monk');
        $this->vars['monks'] = $monks;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('monk/index'),
        );
        $this->load_view('monk/list', $this->vars);
    }

}
