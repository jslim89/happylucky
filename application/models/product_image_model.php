<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyBelongsTo(
    'product_image', // child table name
    'id', // child primary key
    'product', // parent table name
    'product_id', // child foreign key
    'id' // parent primary key
);

/**
 * Product_Image_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Product_Image_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'product_image';

    public function insert_multiple($product, $attribs) {
        $product_image = array();
        foreach($attribs as $key => $img) {
            $product_image[$key] = new Product_Image_Model();
            $product_image[$key]->image_name = $img['client_name'];
            $product_image[$key]->url        = $product->get_download_path().$img['file_name'];
            $product_image[$key]->extension  = $img['file_ext'];
            $product_image[$key]->alt        = $img['client_name'];
            $product_image[$key]->image_desc = $img['client_name'];
            $product_image[$key]->product_id    = $product->id;
        }
        return $product_image;
    }

    /**
     * override the parent method, delete from database at the same time
     * delete the physical file 
     * 
     * @return boolean
     */
    public function delete() {
        // NOTE: $this->product->get_upload_path() doesn't work, thus
        //       I add one more addtional step
        $product = new Product_Model($this->product->id);
        if(unlink($product->get_upload_path().basename($this->url))) {
            return parent::delete();
        }
        return false;
    }
}
