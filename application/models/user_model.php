<?php
require_once(APPPATH.'core/MY_Active_Record.php');

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

    const ADMIN = 'ADMIN';

    /**
     * Password encryption 
     * 
     * @return string
     */
    private function _encrypt_password() {
        // Generate a random salt if empty
        if(empty($this->salt)) {
            $this->salt = md5(uniqid(rand(), true));
        }
        $this->password = sha1($this->salt . $this->password);
    }

    /**
     * Override parent function (Password has to encrypt) 
     * 
     * @param mixed $post 
     * @return void
     */
    public function populate_from_request($post) {
        unset($post['password']);
        parent::populate_from_request($post);
    }

    /**
     * login 
     * 
     * @return boolean
     */
    public function login() {
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

    /**
     * match_password 
     * 
     * @param mixed $password 
     * @return boolean
     */
    public function match_password($password) {
        $u = new User_Model($this->id);
        $u->password = $password;
        $u->_encrypt_password();
        return $u->password === $this->password;
    }

    /**
     * update_password 
     * 
     * @param mixed $password 
     * @return mixed
     */
    public function update_password($password) {
        $u = new User_Model($this->id);
        $u->password = $password;
        $u->_encrypt_password();
        $this->password = $u->password;
        return $this->save();
    }

    /**
     * Check for email unique 
     * 
     * @param mixed $email 
     * @return boolean
     */
    public static function is_email_unique($email) {
        $user = new User_Model();
        $user->load_by_email($email);
        // exist => Not unique
        return ( ! $user->is_exist());
    }
}
