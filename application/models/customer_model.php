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

    /**
     * constant for sex 
     */
    const MALE   = 'M';
    const FEMALE = 'F';

    /**
     * _encrypt_password 
     * 
     * @return void
     */
    private function _encrypt_password() {
        // Generate a random salt if empty
        if(empty($this->salt)) {
            $this->salt = md5(uniqid(rand(), true));
        }
        $this->password = sha1($this->salt . $this->password);
    }

    /**
     * register 
     * 
     * @return mixed
     */
    public function register() {
        // current timestamp
        $this->registration_date = time();
        $this->is_verified = 0;
        $this->_encrypt_password();
        return $this->save();
    }

    /**
     * login 
     * 
     * @return boolean
     */
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
     * match_password 
     * 
     * @param mixed $password 
     * @return boolean
     */
    public function match_password($password) {
        $c = new Customer_Model($this->id);
        $c->password = $password;
        $c->_encrypt_password();
        return $c->password === $this->password;
    }

    public function update_password($password) {
        $c = new Customer_Model($this->id);
        $c->password = $password;
        $c->_encrypt_password();
        $this->password = $c->password;
        return $this->save();
    }

    /**
     * Generate a random password and auto-populate
     * into current object 
     * 
     * @return string
     */
    public function generate_new_password() {
        $random_string = $this->id
                        .$this->first_name
                        .$this->last_name
                        .$this->password
                        .$this->registration_date;
        $new_password = md5($random_string);
        $this->password = $new_password;
        $this->_encrypt_password();
        $this->save();
        return $new_password;
    }

    /**
     * Generate a verification code for existing user 
     * 
     * @return mixed
     */
    public function generate_verification_code() {
        // not an existing user
        if( ! $this->is_exist()) return false;

        $uniq_str = md5($this->id.$this->registration_date)
                    .substr($this->salt, 0, -15);

        return sha1($uniq_str);
    }

    /**
     * Verify with the hashed code 
     * 
     * @param mixed $code 
     * @return boolean
     */
    public function verify($code) {
        if($this->generate_verification_code() === $code) {
            $this->is_verified = 1;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * A list of orders which are ordered by this customer
     * 
     * @return array
     */
    public function get_order_list($page_limit = false, $offset = false) {
        $this->_get_ci()->load->model('customer_order_model');
        $order = new Customer_Order_Model();
        $sql = "customer_id = ?";
        return $order->search($sql, array($this->id), $page_limit, $offset, true);
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
