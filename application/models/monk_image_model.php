<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyBelongsTo(
    'monk_image', // child table name
    'id', // child primary key
    'monk', // parent table name
    'monk_id', // child foreign key
    'id' // parent primary key
);

/**
 * Monk_Image_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Monk_Image_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'monk_image';
}
