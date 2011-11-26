<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'product', // parent table name
    'id', // parent primary key
    'product_image', // child table name
    'product_id' // child foreign key
);

ADOdb_Active_Record::TableKeyHasMany(
    'product', // parent table name
    'id', // parent primary key
    'order_detail', // child table name
    'product_id' // child foreign key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'product', // child table name
    'id', // child primary key
    'amulet_product', // parent table name
    'amulet_product_id', // child foreign key
    'id' // parent primary key
);

/**
 * Product_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Product_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'product';
}
