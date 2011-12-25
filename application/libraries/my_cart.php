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
        $ci =& get_instance();
        $ci->load->model('product_model');
        $minimized_cart = json_decode(get_cookie($cookie), TRUE);
        foreach($minimized_cart as $product_id => $qty) {
            $product = new Product_Model($product_id);
            $item = array(
                'id'    => $product->id,
                'qty'   => $qty,
                'price' => $product->standard_price,
                'name'  => $product->product_name,
            );
            $this->insert($item);
        }
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
}
