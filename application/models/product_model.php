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
    'product_batch', // child table name
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

    /**
     * advanced_search 
     * 
     * @param array $post 
     * @param mixed $limit 
     * @param mixed $offset 
     * @return array
     */
    public function advanced_search(array $post, $limit, $offset) {
        $sql_price = '';
        if(!empty($post['standard_price'])) {
            $sql_price = ' AND standard_price '.Product_Model::price_operator($post['operator']).' '.$post['standard_price'];
        }
        if(!empty($post['product_category'])) {
            switch($post['product_category']) {
                case Product_Model::BOTH:
                    $sql_category = '';
                    break;
                case Product_Model::AMULET:
                    $sql_category = ' AND (amulet_product_id IS NOT NULL OR amulet_product_id > 0)';
                    break;
                case Product_Model::ACCESSORIES:
                    $sql_category = ' AND (amulet_product_id IS NULL OR amulet_product_id = 0)';
                    break;
            }
        }
        unset($post['standard_price']);
        unset($post['operator']);
        unset($post['product_category']);
        list($sql, $values) = $this->_create_criteria_sql($post);
        $sql .= $sql_price.$sql_category.' AND quantity_available > 0';
        return $this->search($sql, $values, $limit, $offset, true);
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
     * stock_in 
     * 
     * @param array $data 
     * @return mixed
     */
    public function stock_in(array $data) {
        $this->_get_ci()->load->model('product_batch_model');
        $batch = new Product_Batch_Model();
        $batch->populate_from_request($data);
        $batch->stock_in_date = time();
        $batch->batch_no = $this->get_last_batch_no() + 1;
        $batch->product_id = $this->id;
        $is_stock_in = $batch->save();
        if($is_stock_in) {
            $this->quantity_available += $batch->quantity_stock_in;
            return $this->save();
        }
        return false;
    }

    /**
     * get_last_batch_no 
     * 
     * @return int
     */
    public function get_last_batch_no() {
        $sql = "SELECT batch_no FROM product_batch"
            . " WHERE product_id = ?"
            . " ORDER BY batch_no DESC";
        $result = $this->_get_ci()->adodb->GetOne($sql, array($this->id));
        return (int)$result;
    }

    /**
     * Price operator in string form 
     * 
     * @param mixed $opr 
     * @return mixed
     */
    public static function price_operator($opr) {
        switch($opr) {
            case Product_Model::EQUAL: 
                return '=';
            case Product_Model::GREATER_EQUAL: 
                return '>=';
            case Product_Model::GREATER: 
                return '>';
            case Product_Model::LESS_EQUAL: 
                return '<=';
            case Product_Model::LESS_EQUAL: 
                return '<';
        }
        return false;
    }

    /**
     * hot 
     * 
     * @param mixed $limit 
     * @param mixed $min_num_sold minimum number must achieve in order to 
     *              consider as hot. i.e. If all products total_num_sold is 0,
     *              then shouldn't return any result
     * @return array
     */
    public static function hot($limit, $min_num_sold) {
        $p = new Product_Model();
        $sql = 'total_num_sold > ? order by total_num_sold desc';
        return $p->search($sql, array($min_num_sold), $limit, 0);
    }

    /**
     * latest 
     * 
     * @param mixed $limit 
     * @return array
     */
    public static function latest($limit) {
        $p = new Product_Model();
        $sql = 'quantity_available > ? order by created_date desc';
        return $p->search($sql, array(0), $limit, 0);
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

    /**
     * Return a list of product which its quantity available is below
     * the treshold 
     * 
     * @return array
     */
    public static function pending_for_reload() {
        $product = new Product_Model();
        $sql = "quantity_available <= min_qty_alert ORDER BY quantity_available";
        $product_list = $product->search($sql);
        return $product_list;
    }
}
