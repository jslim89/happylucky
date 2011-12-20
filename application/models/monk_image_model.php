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

    public function insert_multiple($monk, $attribs) {
        $monk_image = array();
        foreach($attribs as $key => $img) {
            $monk_image[$key] = new Monk_Image_Model();
            $monk_image[$key]->image_name = $img['client_name'];
            $monk_image[$key]->url        = $monk->get_download_path().$img['file_name'];
            $monk_image[$key]->extension  = $img['file_ext'];
            $monk_image[$key]->alt        = $img['client_name'];
            $monk_image[$key]->image_desc = $img['client_name'];
            $monk_image[$key]->monk_id    = $monk->id;
        }
        return $monk_image;
    }

    /**
     * override the parent method, delete from database at the same time
     * delete the physical file 
     * 
     * @return boolean
     */
    public function delete() {
        // NOTE: $this->monk->get_upload_path() doesn't work, thus
        //       I add one more addtional step
        $monk = new Monk_Model($this->monk->id);
        if(unlink($monk->get_upload_path().basename($this->url))) {
            return parent::delete();
        }
        return false;
    }
}
