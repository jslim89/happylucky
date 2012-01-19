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
        list($orders, $total_rows) = Customer_Order_Model::get_all_by_status(
            get_post('status', false),
            get_post('order_by', 'order_date'),
            get_post('seq', 'ASC'),
            10,
            $page
        );

        $this->vars['pagination'] = $this->customer_order_model->get_pagination($total_rows, 10);
        $this->vars['title'] = lang('order_management');
        $this->vars['orders'] = $orders;
        $this->load_view('admin/order/list', $this->vars);
	}

    public function view($id) {
        $order    = new Customer_Order_Model($id);
        $products = array();
        foreach($order->order_detail as $p) {
            $temp_prod = new Product_Model($p->product_id);
            $p->product_name = $temp_prod->product_name;
            $p->product_code = $temp_prod->product_code;
            $products[] = $p;
        }
        $this->vars['order']    = $order;
        $this->vars['products'] = $products;
        $this->vars['title']    = lang('order_order_information');

        $this->load_view('admin/order/view', $this->vars);
    }

    public function save($id = null) {
        $order = new Customer_Order_Model($id);
        $order->populate_from_request($_POST);

        if($order->save()) {
            redirect('admin/order/view/'.$order->id);
        }
        else {
            $this->load_view('admin/order', $this->vars);
        }
    }
}

/* End of file order.php */
/* Location: ./application/controllers/admin/order.php */
