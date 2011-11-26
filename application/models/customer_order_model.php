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
}
