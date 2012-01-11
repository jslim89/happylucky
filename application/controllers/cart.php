<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cart 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Cart extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('product');
        $this->lang->load('cart');
        $this->load->library('my_cart');
        $this->load->Model('product_model');
    }

	public function index($page = 0)
	{
        $this->my_cart->load_from_cookie(MY_Cart::COOKIE);
        $products = $this->my_cart->get_paged(10, $page, TRUE);
        $this->vars['pagination'] = $this->my_cart->get_pagination();
        $this->vars['title'] = lang('shopping_cart');
        $this->vars['products'] = $products;
        $this->load_view('cart/list', $this->vars);
	}

    /**
     * Add a product to cart 
     * 
     * @param mixed $id 
     * @param int $qty 
     * @return void
     */
    public function add($id, $qty = 1) {
        $product = new Product_Model($id);
        $item = array(
            'id'    => $product->id,
            'qty'   => $qty,
            'price' => $product->standard_price,
            'name'  => $product->product_name,
        );
        $this->my_cart->insert($item);
        $cookie = array(
            'name' => MY_Cart::COOKIE,
            'value' => $this->my_cart->to_cookie_string(),
            'expire' => days_to_seconds(7), // 1 week
        );
        set_cookie($cookie);
    }
}

/* End of file cart.php */
/* Location: ./application/controllers/cart.php */