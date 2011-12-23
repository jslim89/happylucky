<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Country 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Country extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->Model('country_model');
    }
    public function ajax_search() {
        $q = get_post('term');
        $country_set = $this->country_model->search_related($q, false, false, false);
        echo json_encode($country_set);
    }
}

