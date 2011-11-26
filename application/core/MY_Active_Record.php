<?php
/**
 * To enable back the auto-pluralize table name
 * Go to application/third_party/adodb5/adodb-active-record.inc.php
 * static $_changeNames = false; // dynamically pluralize table names
 * set to true
 */

// Use default values of table definition when creating new active record
$ADODB_ACTIVE_DEFVALS = true;

/**
 * MY_Active_Record 
 * 
 * @uses ADODB_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class MY_Active_Record extends ADOdb_Active_Record {

    /**
     * __construct 
     * 
     * @param mixed $table 
     * @param mixed $pk 
     * @param mixed $db 
     * @return void
     */
    public function __construct($table = false, $pk = false, $db = false) {
        parent::__construct($table, $pk, $db);
    }
}
