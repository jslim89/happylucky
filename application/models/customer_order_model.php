<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'customer_order', // parent table name
    'id', // parent primary key
    'order_detail', // child table name
    'order_id' // child foreign key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'customer_order', // child table name
    'id', // child primary key
    'user', // parent table name
    'user_id', // child foreign key
    'id' // parent primary key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'customer_order', // child table name
    'id', // child primary key
    'country', // parent table name
    'country_id', // child foreign key
    'id' // parent primary key
);

/**
 * Customer_Order_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Customer_Order_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'customer_order';

    const PENDING    = 'PENDING';
    const PROCESSING = 'PROCESSING';
    const SHIPPED    = 'SHIPPED';
    const CANCELLED  = 'CANCELLED';
    const EXPIRED    = 'EXPIRED';
    const COMPLETED  = 'COMPLETED';

    /**
     * Return the status in human readable form 
     * 
     * @param mixed $status 
     * @return string
     */
    public static function status($status) {
        $status_text = "";
        switch($status) {
            case Customer_Order_Model::PENDING:
                $status_text = lang('order_pending');
                break;
            case Customer_Order_Model::PROCESSING:
                $status_text = lang('order_processing');
                break;
            case Customer_Order_Model::SHIPPED:
                $status_text = lang('order_shipped');
                break;
            case Customer_Order_Model::CANCELLED:
                $status_text = lang('order_cancelled');
                break;
            case Customer_Order_Model::EXPIRED:
                $status_text = lang('order_expired');
                break;
            case Customer_Order_Model::COMPLETED:
                $status_text = lang('order_completed');
                break;
        }
        return $status_text;
    }

    public function get_full_address() {
        return $this->shipping_address
            . ", \n" . $this->shipping_town
            . ", \n" . $this->shipping_postcode
            . ", \n" . $this->shipping_city
            . ", \n" . $this->shipping_state
            . ", \n" . $this->country->country_name;
    }

    /**
     * make_order 
     *
     * if is empty array, then order no problem
     * if array, then the order items got some problem
     * if string, then this order doesn't made
     * @return mixed
     */
    public function make_order($order_items) {
        $this->_get_ci()->load->model('product_model');
        $this->order_date = time();
        $this->order_status = Customer_Order_Model::PENDING;
        $this->grand_total = $this->subtotal + $this->shipping_cost;
        $this->customer_id = get_session('customer_id', null);
        $is_order_ok = $this->save();
        if($is_order_ok) {
            $status = array();
            foreach($order_items as $item) {
                if($item->quantity_alert) {
                    $status[] = $item->quantity_alert;
                }
                $item->order_id = $this->id;
                $is_order_item_ok = $item->save();
                if( ! $is_order_item_ok) {
                    $status[] = lang('product')
                        .' '.anchor(
                            site_url('product/view/'.$item->product_id),
                            $item->product->product_name
                        ).' '.lang('is').' '.lang('not')
                        .' '.lang('available').'.';
                }
                $item->update_product_quantity();
            }
            $this->_send_email_acknowledgement($order_items);
        }
        else {
            $status = lang('order').' '.lang('order_cannot_be_made');
        }
        return $status;
    }

    /**
     * Send email acknowledgement after the order has made 
     * 
     * @param mixed $order_items 
     * @return bool
     */
    private function _send_email_acknowledgement($order_items) {
        $this->_get_ci()->load->library('email');
        $subject = "Order from Happy Lucky";

        $text = "Dear ".get_session('username', 'Customer').", ";
        $text .= "\n\nYour order has been successfully made.";
        $text .= "\n<div>".heading('Order ID: '.$this->id, 2)."</div>";

        $table = "<table border='1' width='100%'>";
        foreach($order_items as $item) {
            $table .= "<tr><td>"
                   . $item->product->product_name
                   . "</td>"
                   . "<td>"
                   . $item->quantity
                   . "</td>"
                   . "<td>"
                   . to_currency($item->unit_sell_price)
                   . "</td>"
                   . "<td>"
                   . to_currency($item->subtotal)
                   . "</td></tr>";
        }
        $table .= "<tr>"
               ."<td colspan='3'>Subtotal: </td>"
               ."<td>".to_currency($this->subtotal, 'MYR')."</td>"
               ."</tr>"
               ."<tr>"
               ."<td colspan='3'>Shipping: </td>"
               ."<td>".to_currency($this->shipping_cost, 'MYR')."</td>"
               ."</tr>"
               ."<tr>"
               ."<td colspan='3'>Grand Total: </td>"
               ."<td>".to_currency($this->grand_total, 'MYR')."</td>"
               ."</tr>";
        $table .= "</table>";

        $text .= $table;
        $text .= "\n\n<p>Thank You.</p>";

        $this->_get_ci()->email->from('test.jslim89@qq.com', 'Mr. Happy Lucky');
        $this->_get_ci()->email->to($this->email);
        $this->_get_ci()->email->subject($subject);
        $this->_get_ci()->email->message($text);
        $is_send = $this->_get_ci()->email->send();
        $this->_get_ci()->email->clear();

        return $is_send;
    }

    /**
     * Get the Order list by customer date and ID 
     * 
     * @param mixed $customer_id 
     * @param mixed $start_date 
     * @param mixed $end_date 
     * @return array
     */
    public static function get_by_cust_date(
        $customer_id,
        $start_date = false,
        $end_date = false,
        $limit = false,
        $offset = false
    ) {
        $order_model = new Customer_Order_Model();
        $sql = "customer_id = ?";
        $criteria_set = array($customer_id);
        if($start_date) {
            $sql .= " AND order_date >= ?";
            $criteria_set[] = $start_date;
        }
        if($end_date) {
            $sql .= " AND order_date <= ?";
            $criteria_set[] = $end_date;
        }
        $order_list = $order_model->search($sql, $criteria_set, $limit, $offset, true);
        return $order_list;
    }
}
