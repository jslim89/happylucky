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
