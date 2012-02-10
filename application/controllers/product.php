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

        list($products, $total_rows) = (get_post('search_type') == 'advanced')
            ? $this->product_model->advanced_search($_POST, 10, $page)
            : $this->_general_search($q, $page);

        /* Pagination */
        $this->vars['pagination'] = $this->product_model->get_pagination($total_rows, 10, 3);
        $pagin_first              = $page + 1;
        $pagin_last               = (($page + 10) < $total_rows) ? ($page + 10) : $total_rows;
        $this->vars['pagin']      = $pagin_first.' - '.$pagin_last.' '.lang('of').' '.$total_rows;

        $this->vars['title'] = lang('product');
        $this->vars['products'] = $products;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('product/index'),
        );
        $this->load_view('product/list', $this->vars);
	}

    private function _general_search($q, $page) {
        // either AMULET or ACCESSORIES
        $category = get_post('category', false);
        // either RETAIL or WHOLESALE
        $type     = strtoupper(get_post('type', Product_Model::BOTH));

        $criteria_set = array();
        $sql = 'quantity_available > 0';
        if($type !== Product_Model::BOTH) {
            $sql .= ' AND UPPER(product_type) = ?';
            $criteria_set[] = $type;
        }
        if($category != false) {
            $sql .= (strtoupper($category) === Product_Model::AMULET)
                ? ' AND amulet_product_id > 0'
                : ' AND (amulet_product_id = 0 OR amulet_product_id IS NULL)';
        }

        return (empty($q))
            ? $this->product_model->search($sql, $criteria_set, 10, $page, true)
            : $this->product_model->search_q_with_extra_condition($sql, $criteria_set, $q, 10, $page);
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
