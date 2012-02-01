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
        $this->load->model('customer_model');
        $this->load->model('product_model');
        $this->load->model('banner_model');
    }

	public function index()
	{
        $hot_products = Product_Model::hot(10, 5);
        $latest_products = Product_Model::latest(10);
        $this->vars['slideshows']      = $this->banner_model->get_all();
        $this->vars['hot_products']    = $hot_products;
        $this->vars['latest_products'] = $latest_products;
		$this->load_view('home', $this->vars);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
