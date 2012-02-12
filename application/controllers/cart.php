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
        $this->load->Model('customer_order_model');
        $this->load->Model('product_model');
        $this->load->Model('country_model');
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
     * Add a product to cart by AJAX
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
        $ret = $this->my_cart->insert($item);
        $to_js = array('status' => 0);
        if( ! empty($ret)) {
            $to_js['status'] = 1;
            $this->my_cart->save_to_cookie();
        }
        echo json_encode($to_js);
    }

    public function update() {
        $data_set = array();
        $rowids     = (array)get_post('rowid');
        $quantities = (array)get_post('quantity');
        $i = 0;
        foreach($rowids as $k => $rowid) {
            $data_set[$i]['rowid'] = $rowid;
            $data_set[$i]['qty']   = $quantities[$k];
            $i++;
        }
        $status = $this->my_cart->update($data_set);
        if($status) $this->my_cart->save_to_cookie();
        redirect('cart');
    }

    /**
     * ajax remove an item from cart 
     * 
     * @param mixed $rowid 
     * @return void
     */
    public function remove($rowid) {
        $status = $this->my_cart->update(array(
            array(
                'rowid' => $rowid,
                'qty'   => 0
            )
        ));
        $this->my_cart->save_to_cookie();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function checkout($step = 1) {
        if($this->my_cart->is_empty()) {
            $this->session->set_flashdata('general_error', lang('cart_cart_is_empty'));
            redirect(site_url('product'));
        }
        $this->vars['title'] = lang('cart_check_out');
        $this->vars['step'] = 'cart/steps/step_'.$step;
        $this->vars['breadcrumb'] = $this->_breadcrumb($step);
        switch($step) {
            case 1:
                $this->_step_1();
                break;
            case 3:
                $this->_step_3();
                break;
            case 4:
                $this->_step_4();
                break;
        }
        $this->load_view('cart/checkout', $this->vars);
    }

    private function _step_1() {
        $option = get_post('opt');
        if(get_session('customer_id')) {
            redirect('cart/checkout/2');
        }
        else if($option == 'register') {
            redirect(site_url('user/register').'?url='.site_url('cart/checkout/2'));
        }
        else if($option == 'guest'){
            redirect('cart/checkout/2');
        }
    }

    private function _step_3() {
        $order = new Customer_Order_Model();
        $order->populate_from_request($_POST);
        $this->session->set_userdata('temp_order', $order);
    }

    private function _step_4() {
        $order = new Customer_Order_Model();
        $products = $this->my_cart->get_products();
        $temp_order = (array)get_session('temp_order');
        $order->populate_from_request($temp_order);
        $order->populate_from_request($_POST);
        $this->session->set_userdata('temp_order', $order);
        $this->vars['products'] = $products;
    }

    /**
     * Breadcrumb for checkout steps 
     * 
     * @param mixed $step 
     * @return string
     */
    private function _breadcrumb($step) {
        $breadcrumb = "";
        for($i = 1; $i < $step; $i++) {
            $link = anchor(
                site_url('cart/checkout/'.$i),
                lang('cart_checkout_step_'.$i)
            );
            $breadcrumb .= $link.' > ';
        }
        $breadcrumb .= lang('cart_checkout_step_'.$step);
        return $breadcrumb;
    }
}

/* End of file cart.php */
/* Location: ./application/controllers/cart.php */
