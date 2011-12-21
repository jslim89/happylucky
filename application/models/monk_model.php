<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'monk', // parent table name
    'id', // parent primary key
    'monk_image', // child table name
    'monk_id' // child foreign key
);

ADOdb_Active_Record::TableKeyHasMany(
    'monk', // parent table name
    'id', // parent primary key
    'amulet', // child table name
    'monk_id' // child foreign key
);

/**
 * Monk_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Monk_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'monk';

    /**
     * Return the upload path for this particular monk 
     * 
     * @return mixed
     */
    public function get_upload_path() {
        if(!$this->is_exist()) return false;

        $path_to_monk_img = "images/monks/".$this->id."/";
        $abs_path = absolute_path().$path_to_monk_img;

        if(!file_exists($abs_path)) {
            // umask is to revoke permission
            // i.e. chmod('file', 0777)
            //      umask(0022)
            //      file permission will be 0755
            umask(0000);
            mkdir($abs_path, 0777);
        }
        return $abs_path;
    }

    /**
     * Get the path for download image base on a particular monk object 
     * 
     * @return string
     */
    public function get_download_path() {
        if(!$this->is_exist()) return false;

        $path_to_monk_img = "images/monks/".$this->id."/";
        $relative_path = base_url().$path_to_monk_img;
        return $relative_path;
    }

    /**
     * All the configuration about uploading images
     * 
     * @return array
     */
    public function get_image_upload_config() {
        if($this->is_exist()) {
            $conf = array(
                'upload_url'         => site_url('admin/monk/upload/'.$this->id),
                'primary_upload_url' => site_url('admin/monk/upload_primary/'.$this->id),
                'primary_image_url'  => $this->primary_image_url,
                'primary_image_alt'  => $this->monk_name,
                'delete_image_url'   => base_url().'admin/monk/del_monk_image/',
                'save_image_url'     => base_url().'admin/monk/save_img_info/',
            );
        }
        else {
            $conf = array(
                'upload_url'         => '',
                'primary_upload_url' => '',
                'primary_image_url'  => '',
                'primary_image_alt'  => '',
                'delete_image_url'   => '',
                'save_image_url'     => '',
            );
        }
        return $conf;
    }
}
