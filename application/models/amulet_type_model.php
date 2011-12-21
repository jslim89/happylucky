<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'amulet_type', // parent table name
    'id', // parent primary key
    'amulet', // child table name
    'amulet_type_id' // child foreign key
);

ADOdb_Active_Record::TableKeyHasMany(
    'amulet_type', // parent table name
    'id', // parent primary key
    'amulet_type_image', // child table name
    'amulet_type_id' // child foreign key
);

/**
 * Amulet_Type_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Amulet_Type_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'amulet_type';

    /**
     * Return the upload path for this particular amulet_type 
     * 
     * @return mixed
     */
    public function get_upload_path() {
        if(!$this->is_exist()) return false;

        $path_to_amulet_type_img = "images/amulet_types/".$this->id."/";
        $abs_path = absolute_path().$path_to_amulet_type_img;

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
     * Get the path for download image base on a particular amulet_type object 
     * 
     * @return string
     */
    public function get_download_path() {
        if(!$this->is_exist()) return false;

        $path_to_amulet_type_img = "images/amulet_types/".$this->id."/";
        $relative_path = base_url().$path_to_amulet_type_img;
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
                'upload_url'         => site_url('admin/amulet_type/upload/'.$this->id),
                'primary_upload_url' => site_url('admin/amulet_type/upload_primary/'.$this->id),
                'primary_image_url'  => $this->primary_image_url,
                'primary_image_alt'  => $this->amulet_type_name,
                'delete_image_url'   => base_url().'admin/amulet_type/del_amulet_type_image/',
                'save_image_url'     => base_url().'admin/amulet_type/save_img_info/',
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

    /**
     * Delete the primary image both from file and also database 
     * 
     * @return mixed
     */
    public function delete_primary_image() {
        if( ! $this->is_exist() || empty($this->primary_image_url)) return false;
        if(unlink($this->get_upload_path().basename($this->primary_image_url))) {
            $this->primary_image_url = null;
            return $this->save();
        }
        return false;
    }
}
