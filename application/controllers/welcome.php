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
    }

	public function index()
	{
        $hot_products = Product_Model::hot(10, 5);
        $latest_products = Product_Model::latest(10);
        $this->vars['slideshows']      = $this->_get_slideshows();
        $this->vars['hot_products']    = $hot_products;
        $this->vars['latest_products'] = $latest_products;
		$this->load_view('home', $this->vars);
    }

    /**
     * _get_slideshows 
     * 
     * @return array
     */
    private function _get_slideshows() {
        $files = glob(BASEPATH.'../images/slideshows/*');
        foreach($files as $file) {
            // filter only jpg, jpeg, png files out
            if(preg_match_all('/.jpe?g|.png$/', $file, $temp))
                $images[] = base_url('images/slideshows/'.basename($file));
        }
        return $images;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
