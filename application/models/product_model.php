<?php
require_once(APPPATH.'core/MY_Active_Record.php');

ADOdb_Active_Record::TableKeyHasMany(
    'product', // parent table name
    'id', // parent primary key
    'product_image', // child table name
    'product_id' // child foreign key
);

ADOdb_Active_Record::TableKeyHasMany(
    'product', // parent table name
    'id', // parent primary key
    'order_detail', // child table name
    'product_id' // child foreign key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'product', // child table name
    'id', // child primary key
    'amulet_product', // parent table name
    'amulet_product_id', // child foreign key
    'id' // parent primary key
);

ADOdb_Active_Record::TableKeyBelongsTo(
    'product', // child table name
    'id', // child primary key
    'supplier', // parent table name
    'supplier_id', // child foreign key
    'id' // parent primary key
);

/**
 * Product_Model 
 * 
 * @uses MY_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Product_Model extends MY_Active_Record {

    /**
     * _table 
     * 
     * @var string
     * @access protected
     */
    var $_table = 'product';

    const BOTH    = 'BOTH';

    const GREATER_EQUAL = 2;
    const GREATER       = 1;
    const EQUAL         = 0;
    const LESS          = -1;
    const LESS_EQUAL    = -2;

    const RETAIL    = 'RETAIL';
    const WHOLESALE = 'WHOLESALE';

    const AMULET      = 'AMULET';
    const ACCESSORIES = 'ACCESSORIES';

    /**
     * Return the upload path for this particular product 
     * 
     * @return mixed
     */
    public function get_upload_path() {
        if(!$this->is_exist()) return false;

        $path_to_product_img = "images/products/".$this->id."/";
        $abs_path = absolute_path().$path_to_product_img;

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
     * Get the path for download image base on a particular product object 
     * 
     * @return string
     */
    public function get_download_path() {
        if(!$this->is_exist()) return false;

        $path_to_product_img = "images/products/".$this->id."/";
        $relative_path = base_url().$path_to_product_img;
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
                'upload_url'         => site_url('admin/product/upload/'.$this->id),
                'primary_upload_url' => site_url('admin/product/upload_primary/'.$this->id),
                'primary_image_url'  => $this->primary_image_url,
                'primary_image_alt'  => $this->product_name,
                'delete_image_url'   => base_url().'admin/product/del_product_image/',
                'save_image_url'     => base_url().'admin/product/save_img_info/',
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

    public function is_amulet() {
        return sizeof($this->amulet_product) > 0;
    }

    public function amulet() {
        if($this->is_amulet()) {
            $this->_get_ci()->load->model('amulet_model');
            $amulet = new Amulet_Model($this->amulet_product->amulet_id);
            return $amulet;
        }
        return false;
    }

    /**
     * I'm using CodeIgniter built-in Cart class.
     * There are several attributes are compulsory, this
     * function is convert the product object to cart item
     * in array form. 
     * 
     * @return array
     */
    public function to_cart_item() {
        return array();
    }

    /**
     * is_product_code_unique 
     * 
     * @param mixed $code 
     * @return boolean
     */
    public static function is_product_code_unique($code) {
        $product = new Product_Model();
        $product->load_by_product_code($code);
        // exist => Not unique
        return ( ! $product->is_exist());
    }
}
