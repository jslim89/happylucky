<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Order
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Order extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('order');
        $this->lang->load('product');
        $this->load->library('my_cart');
        $this->load->Model('product_model');
        $this->load->Model('customer_order_model');
    }

	public function index($page = 0)
	{
        list($orders, $total_rows) = $this->customer_order_model->get_by_cust_date(
            get_session('customer_id'),
            get_post_date('start_date'),
            get_post_date('end_date'),
            10,
            $page
        );

        $this->vars['pagination'] = $this->customer_order_model->get_pagination($total_rows, 10, 3);
        $this->vars['title'] = lang('order_history');
        $this->vars['orders'] = $orders;
        $this->load_view('order/list', $this->vars);
	}

    public function view($id) {
        $order = new Customer_Order_Model($id);
        $this->vars['order'] = $order;
        $this->vars['title'] = lang('order_order_information');

        $this->load_view('order/view', $this->vars);
    }

    public function make_order() {
        $order = new Customer_Order_Model();
        $temp_order = (array)$this->session->flashdata('temp_order');
        $order->populate_from_request($temp_order);
        $order->populate_from_request($_POST);
        $status = $order->make_order($this->my_cart->to_order_items());
        if(is_array($status)) {
            // The order made successful
            if(sizeof($status) === 0) {
                $error = false;
            }
            else { // some problems on order items
                $error = implode("\n", $status);
            }
        }
        else { // order cannot be made
            $error = $status;
        }

        $this->vars['error'] = $error;
        $this->vars['order'] = $order;
        $this->load_view('order/made', $this->vars);
    }
}

/* End of file order.php */
/* Location: ./application/controllers/order.php */
