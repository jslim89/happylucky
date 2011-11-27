<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'user', // parent table name
    'id', // parent primary key
    'customer_order', // child table name
    'user_id' // child foreign key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'user', // child table name
    'id', // child primary key
    'country', // parent table name
    'country_id', // child foreign key
    'id' // parent primary key
);

/**
 * User_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class User_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'user';

    private function _encrypt_password() {
        // Generate a random salt if empty
        if(empty($this->salt)) {
            $this->salt = md5(uniqid(rand(), true));
        }
        $this->password = sha1($this->salt . $this->password);
    }

    public function login($user_type = 'MEMBER') {
        $u = new User_Model();
        $u->load_by_email($this->email);
        if($u->is_exist()) {
            // Must assign a salt value before encrypt
            $this->salt = $u->salt;
            $this->_encrypt_password();

            if($u->password == $this->password) {
                $this->re_assign($u);
                return true;
            }
        }
        return false;
    }
}
