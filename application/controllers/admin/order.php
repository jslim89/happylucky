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
        $this->load->Model('country_model');
        $this->load->Model('customer_order_model');
        $this->load->Model('order_detail_model');
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

        $this->vars['seq_order_id']      = get_post('seq', 'DESC');
        $this->vars['seq_customer_name'] = get_post('seq', 'DESC');
        $this->vars['seq_order_date']    = get_post('seq', 'DESC');
        $this->vars['seq_subtotal']      = get_post('seq', 'DESC');
        $this->vars['seq_shipping']      = get_post('seq', 'DESC');
        $this->vars['seq_grand_total']   = get_post('seq', 'DESC');
        $this->vars['seq_status']        = get_post('seq', 'DESC');

        $order_by = get_post('order_by', 'order_status');
        switch($order_by) {
            case 'id':
                $this->vars['seq_order_id']    = (get_post('seq', 'ASC') == 'ASC') ? 'DESC' : 'ASC';
                break;
            case 'customer_name':
                $this->vars['seq_customer_name']    = (get_post('seq', 'ASC') == 'ASC') ? 'DESC' : 'ASC';
                break;
            case 'order_date':
                $this->vars['seq_order_date']    = (get_post('seq', 'ASC') == 'ASC') ? 'DESC' : 'ASC';
                break;
            case 'subtotal':
                $this->vars['seq_subtotal']    = (get_post('seq', 'ASC') == 'ASC') ? 'DESC' : 'ASC';
                break;
            case 'shipping_cost':
                $this->vars['seq_shipping']    = (get_post('seq', 'ASC') == 'ASC') ? 'DESC' : 'ASC';
                break;
            case 'grand_total':
                $this->vars['seq_grand_total']    = (get_post('seq', 'ASC') == 'ASC') ? 'DESC' : 'ASC';
                break;
            case 'order_status':
                $this->vars['seq_status']    = (get_post('seq', 'ASC') == 'ASC') ? 'DESC' : 'ASC';
                break;
        }

        /* Pagination */
        $this->vars['pagination'] = $this->customer_order_model->get_pagination($total_rows, 10);
        $pagin_first              = $page + 1;
        $pagin_last               = (($page + 10) < $total_rows) ? ($page + 10) : $total_rows;
        $this->vars['pagin']      = $pagin_first.' - '.$pagin_last.' '.lang('of').' '.$total_rows;

        $this->vars['title']           = lang('order_management');
        $this->vars['status_selected'] = get_post('status', Customer_Order_Model::PENDING);
        $this->vars['orders']          = $orders;
        $this->load_view('admin/order/list', $this->vars);
	}

    public function add() {
        // Set an empty object as the order variable is required
        $this->vars['title'] = lang('order_add_new_order');
        $order = new Customer_Order_Model();
        $this->vars['order'] = $order;
        $this->load_view('admin/order/add', $this->vars);
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
        // if is add new order
        if($id === null) {
            $order->subtotal      = 0.00;
            $order->shipping_cost = 0.00;
            $order->grand_total   = 0.00;
        }

        $is_saved = $order->save();
        if($is_saved) {
            $success = ($id === null) ? lang('inserted') : lang('updated');
            $this->session->set_flashdata('general_success', $success);
            redirect('admin/order/view/'.$order->id);
        }
        else {
            $error = ($id === null) ? lang('insert_failed') : lang('update_failed');
            $this->session->set_flashdata('general_error', $error);
            redirect('admin/order/index');
        }
    }

    public function add_products($order_id) {
        $this->vars['title']    = lang('order_add_products');
        if($_POST) {
            $product_id_set      = (array)get_post('product_id');
            $quantity_set        = (array)get_post('quantity');
            $unit_sell_price_set = (array)get_post('unit_sell_price');

            foreach($product_id_set as $k => $product_id) {
                $order_detail = new Order_Detail_Model();
                $order_detail->order_id = $order_id;
                $order_detail->quantity = $quantity_set[$k];
                $order_detail->unit_sell_price = $unit_sell_price_set[$k];
                $order_detail->product_id = $product_id;
                $order_detail->subtotal = $order_detail->quantity * $order_detail->unit_sell_price;
                $order_detail->save();
                $order_detail->update_product_quantity();
            }
            $order = new Customer_Order_Model($order_id);
            $order->update_total();
            $this->session->set_flashdata('general_success', lang('updated'));
            redirect('admin/order/view/'.$order_id);
        }
        else {
            $this->vars['order_id'] = $order_id;
            $this->load_view('admin/order/add_products', $this->vars);
        }
    }
     
    public function send_email_acknowledge_customer($order_id) {
        $order = new Customer_Order_Model($order_id);
        $cust_name = $order->first_name.', '.$order->last_name;
        $is_send = $order->send_email_acknowledgement($order->order_detail, $cust_name);
        echo json_encode(array(
            'status' => $is_send
        ));
    }
}

/* End of file order.php */
/* Location: ./application/controllers/admin/order.php */
