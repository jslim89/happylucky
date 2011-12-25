<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'customer', // parent table name
    'id', // parent primary key
    'customer_order', // child table name
    'customer_id' // child foreign key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'customer', // child table name
    'id', // child primary key
    'country', // parent table name
    'country_id', // child foreign key
    'id' // parent primary key
);

/**
 * Customer_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Customer_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'customer';

    private function _encrypt_password() {
        // Generate a random salt if empty
        if(empty($this->salt)) {
            $this->salt = md5(uniqid(rand(), true));
        }
        $this->password = sha1($this->salt . $this->password);
    }

    public function login() {
        $c = new Customer_Model();
        $c->load_by_email($this->email);
        if($c->is_exist()) {
            // Must assign a salt value before encrypt
            $this->salt = $c->salt;
            $this->_encrypt_password();

            if($c->password == $this->password) {
                $this->re_assign($c);
                return true;
            }
        }
        return false;
    }

    /**
     * Check for email unique 
     * 
     * @param mixed $email 
     * @return boolean
     */
    public static function is_email_unique($email) {
        $customer = new Customer_Model();
        $customer->load_by_email($email);
        // exist => Not unique
        return ( ! $customer->is_exist());
    }
}
