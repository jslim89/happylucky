<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyBelongsTo(
    'order_detail', // child table name
    'id', // child primary key
    'customer_order', // parent table name
    'order_id', // child foreign key
    'id' // parent primary key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'order_detail', // child table name
    'id', // child primary key
    'product', // parent table name
    'product_id', // child foreign key
    'id' // parent primary key
);

/**
 * Order_Detail_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Order_Detail_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'order_detail';

    /**
     * update_product_quantity 
     * 
     * @return mixed
     */
    public function update_product_quantity() {
        $qty_left = $this->product->quantity_available;
        $this->product->quantity_available -= $this->quantity;
        $this->product->total_num_sold += $this->quantity;
        return $this->product->save();
    }
}
