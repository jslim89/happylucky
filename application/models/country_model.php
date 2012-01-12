<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'country', // parent table name
    'id', // parent primary key
    'supplier', // child table name
    'country_id' // child foreign key
);

ADOdb_Active_Record::TableKeyHasMany(
    'country', // parent table name
    'id', // parent primary key
    'user', // child table name
    'country_id' // child foreign key
);

ADOdb_Active_Record::TableKeyHasMany(
    'country', // parent table name
    'id', // parent primary key
    'customer_order', // child table name
    'country_id' // child foreign key
);

/**
 * Country_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Country_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'country';

    /**
     * Get all the countries 
     * 
     * @return array
     */
    public static function get_dropdown_list() {
        $result_set = array();
        $country = new Country_Model();
        $countries = $country->search('');
        foreach($countries as $c) {
            $result_set[$c->id] = $c->country_name;
        }
        return $result_set;
    }
}
