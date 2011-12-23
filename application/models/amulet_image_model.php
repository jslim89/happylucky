<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyBelongsTo(
    'amulet_image', // child table name
    'id', // child primary key
    'amulet', // parent table name
    'amulet_id', // child foreign key
    'id' // parent primary key
);

/**
 * Amulet_Image_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Amulet_Image_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'amulet_image';

    public function insert_multiple($amulet, $attribs) {
        $amulet_image = array();
        foreach($attribs as $key => $img) {
            $amulet_image[$key] = new Amulet_Image_Model();
            $amulet_image[$key]->image_name = $img['client_name'];
            $amulet_image[$key]->url        = $amulet->get_download_path().$img['file_name'];
            $amulet_image[$key]->extension  = $img['file_ext'];
            $amulet_image[$key]->alt        = $img['client_name'];
            $amulet_image[$key]->image_desc = $img['client_name'];
            $amulet_image[$key]->amulet_id    = $amulet->id;
        }
        return $amulet_image;
    }

    /**
     * override the parent method, delete from database at the same time
     * delete the physical file 
     * 
     * @return boolean
     */
    public function delete() {
        // NOTE: $this->amulet->get_upload_path() doesn't work, thus
        //       I add one more addtional step
        $amulet = new Amulet_Model($this->amulet->id);
        if(unlink($amulet->get_upload_path().basename($this->url))) {
            return parent::delete();
        }
        return false;
    }
}
