<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Product
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Product extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('product');
        $this->load->Model('product_model');
    }

	public function index($page = 0)
	{
        $q = get_post('q');
        // either AMULET or ACCESSORIES
        $category = strtoupper(get_post('category', Product_Model::AMULET));
        // either RETAIL or WHOLESALE
        $type     = strtoupper(get_post('type', Product_Model::RETAIL));

        $sql = 'quantity_available > 0 AND UPPER(product_type) = ? AND ';
        $sql .= ($category === Product_Model::AMULET)
            ? ' amulet_product_id > 0'
            : ' amulet_product_id = 0';
        $criteria_set = array($type);

        list($products, $total_rows) = (empty($q))
            ? $this->product_model->search($sql, $criteria_set, 10, $page, true)
            : $this->product_model->search_q_with_extra_condition($sql, $criteria_set, $q, 10, $page);

        $this->vars['pagination'] = $this->product_model->get_pagination($total_rows, 10, 3);
        $this->vars['title'] = lang('product');
        $this->vars['products'] = $products;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('product/index'),
        );
        $this->load_view('product/list', $this->vars);
	}

    public function view($id) {
        $product = new Product_Model($id);
        $this->vars['product'] = $product;
        $this->vars['title'] = lang('product');

        $this->load_view('product/view', $this->vars);
    }
}

/* End of file product.php */
/* Location: ./application/controllers/cart.php */
