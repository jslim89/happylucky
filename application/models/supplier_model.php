<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'supplier', // parent table name
    'id', // parent primary key
    'product_batch', // child table name
    'supplier_id' // child foreign key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'supplier', // child table name
    'id', // child primary key
    'country', // parent table name
    'country_id', // child foreign key
    'id' // parent primary key
);

/**
 * Supplier_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Supplier_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'supplier';

    /**
     * A list of products which are order from this supplier 
     * 
     * @return array
     */
    public function get_product_list($page_limit = false, $offset = false) {
        $this->_get_ci()->load->model('product_model');
        $product_set = array();
        foreach($this->product_batch as $batch) {
            $p = new Product_Model($batch->product_id);
            // user defined attributes
            $p->stock_in_date     = $batch->stock_in_date;
            $p->quantity_stock_in = $batch->quantity_stock_in;
            $p->unit_cost         = $batch->unit_cost;
            $product_set[] = $p;
        }
        if($page_limit !== false && $offset !== false) {
            $result_set = array();
            $limit = (sizeof($product_set) < $page_limit) ? sizeof($product_set) : $page_limit;
            $result_set = array_slice($product_set, $offset, $limit);
        }
        else {
            $result_set = $product_set;
        }
        return ($page_limit !== false && $offset !== false)
            ? array($result_set, sizeof($product_set))
            : $result_set;
    }
}
