<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'supplier_order', // parent table name
    'id', // parent primary key
    'supplier_order_detail', // child table name
    'supplier_order_id' // child foreign key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'supplier_order', // child table name
    'id', // child primary key
    'supplier', // parent table name
    'supplier_id', // child foreign key
    'id' // parent primary key
);

/**
 * Supplier_Order_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Supplier_Order_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'supplier_order';
}
