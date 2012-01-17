<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyBelongsTo(
    'product_batch', // child table name
    'id', // child primary key
    'product', // parent table name
    'product_id', // child foreign key
    'id' // parent primary key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'product_batch', // child table name
    'id', // child primary key
    'supplier', // parent table name
    'supplier_id', // child foreign key
    'id' // parent primary key
);

/**
 * Product_Batch_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Product_Batch_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'product_batch';
}
