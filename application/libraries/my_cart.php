<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Cart 
 * 
 * @uses CI_Cart
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class MY_Cart extends CI_Cart {

    /**
     * Cookie name for the shopping cart 
     */
    const COOKIE = 'happylucky_cart';

    /**
     * Import the cart item from cookie (which will convert to JSON) 
     * i.e. {"1":"2","3":"10","5":"50"}
     * means product_id = 1, qty = 2
     *       product_id = 2, qty = 3
     *       product_id = 3, qty = 2
     * 
     * @param mixed $json 
     * @return void
     */
    public function load_from_cookie($cookie) {
        $this->_get_ci()->load->model('product_model');
        $minimized_cart = json_decode(get_cookie($cookie), TRUE);
        foreach($minimized_cart as $product_id => $qty) {
            $product = new Product_Model($product_id);
            $item = array(
                'id'    => $product->id,
                'qty'   => $this->_get_available_qty($product->id, $qty),
                'price' => $product->standard_price,
                'name'  => $product->product_name,
            );
            $this->insert($item);
        }
    }

    /**
     * Save the cart items to cookie 
     * 
     * @return void
     */
    public function save_to_cookie() {
        $cookie = array(
            'name' => MY_Cart::COOKIE,
            'value' => $this->to_cookie_string(),
            'expire' => days_to_seconds(7), // 1 week
        );
        set_cookie($cookie);
    }

    /**
     * Example:
     * array(
     *     1 => 2,
     *     2 => 3,
     *     3 => 2
     * )
     * product_id => quantity
     * {"1":"2","3":"10","5":"50"}
     * 
     * @return string
     */
    public function to_cookie_string() {
        $minimized_cart = array();
        foreach($this->contents() as $item) {
            $minimized_cart[$item['id']] = $item['qty'];
        }
        return json_encode($minimized_cart);
    }

    /**
     * For pagination used 
     * 
     * @param int $page_limit default is 10
     * @param int $offset default is 0
     * @param int $to_product Whether in Product object or not
     * @return array
     */
    public function get_paged($page_limit = 10, $offset = 0, $to_product = FALSE) {
        $items = $this->contents();
        if($to_product) {
            $items = $this->get_products();
        }
        $result_set = array();
        $limit = (sizeof($items) < $page_limit) ? sizeof($items) : $page_limit;
        $result_set = array_slice($items, $offset, $limit);
        return $result_set;
    }

    /**
     * get_pagination 
     * 
     * @param mixed $page_limit 
     * @return mixed
     */
    public function get_pagination($page_limit = 10) {
        $this->_get_ci()->load->library('pagination');
        $conf = array(
            'total_rows'       => sizeof($this->get_products()),
            'base_url'         => base_url('cart/index'),
            'per_page'         => $page_limit,
            'use_page_numbers' => FALSE,
            'uri_segment'      => 3,
        );
        $pagination = new CI_Pagination();
        $pagination->initialize($conf);
        return $pagination;
    }

    /**
     * Get the cart items as products 
     * 
     * @return array
     */
    public function get_products() {
        $products = array();
        foreach($this->contents() as $item) {
            $product = new Product_Model($item['id']);
            // user defined attribute which only apply for this case
            $product->qty      = $item['qty'];
            $product->subtotal = $item['subtotal'];
            // use the cart's rowid as key
            $products[$item['rowid']] = $product;
        }
        return $products;
    }

    /**
     * Because the cart item is stored in session and cookie,
     * in multi-user environment, the quantity available may not
     * guarantee more than quantity ordered. In such a case, the
     * ordered quantity will be the quantity available 
     * 
     * @param mixed $product_id 
     * @param mixed $qty_ordered 
     * @return int
     */
    private function _get_available_qty($product_id, $qty_ordered) {
        $qty = $qty_ordered;
        $product = new Product_Model($product_id);
        if($product->quantity_available < $qty_ordered)
            $qty = $product->quantity_available;
        return $qty;
    }

    /**
     * CodeIgniter object 
     * 
     * @return CodeIgniter
     */
    private function _get_ci() {
        $ci =& get_instance();
        return $ci;
    }
}
