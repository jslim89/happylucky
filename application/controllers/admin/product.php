<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Product 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Product extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('product');
        $this->load->Model('product_model');
        $this->load->Model('supplier_model');
        $this->load->Model('amulet_product_model');
        $this->load->Model('product_image_model');
    }

    public function index($page = 0) {
        $q = get_post('q');
        $product = new Product_Model();
        list($products, $total_rows) = (empty($q)) 
            ? $product->get_paged(10, $page)
            : $product->search_related($q, 10, $page);
        $this->vars['pagination'] = $product->get_pagination($total_rows, 10);
        $this->vars['title'] = lang('product_management');
        $this->vars['products'] = $products;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('admin/product/index'),
        );
        $this->load_view('admin/product/list', $this->vars);
    }

    public function add() {
        // Set an empty object as the product variable is required
        $this->vars['title'] = lang('product_add_new_product');

        $product        = new Product_Model();
        $amulet_product = new Amulet_Product_Model();

        $this->vars['product']        = $product;
        $this->vars['amulet_product'] = $amulet_product;
        $this->vars['image_upload']   = $product->get_image_upload_config();
        $this->load_view('admin/product/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('product_edit_product');

        $product        = new Product_Model($id);
        $amulet_product = new Amulet_Product_Model($product->amulet_product_id);
        $supplier       = new Supplier_Model($product->supplier_id);

        $this->vars['product']        = $product;
        $this->vars['amulet_product'] = $amulet_product;
        $this->vars['supplier']       = $supplier;
        $this->vars['images']         = $product->product_image;
        $this->vars['image_upload']   = $product->get_image_upload_config();
        $this->load_view('admin/product/add_edit', $this->vars);
    }

    public function save($id = null) {
        $product = new Product_Model($id);
        $product->populate_from_request($_POST);

        if($product->save()) {
            if(get_post('amulet_id', false)) {
                if($id !== null) // Existing product
                    $amulet_product = new Amulet_Product_Model($product->amulet_product_id);
                else // Newly added product
                    $amulet_product = new Amulet_Product_Model();
                $amulet_product->populate_from_request($_POST);
                $amulet_product->save();
                $product->amulet_product_id = $amulet_product->id;
                $product->save();
            }
            redirect('admin/product/edit/'.$product->id);
        }
        else
            $this->load->view('admin/product/index', $this->vars);
    }

    public function delete($id) {
        $product = new Product_Model($id);
        $status = $product->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    /**
     * Must be an existing product, if $id is null
     * it is not possible to upload 
     * 
     * @param mixed $id 
     * @return void
     */
    public function upload($id) {
        $product = new Product_Model($id);
        $conf = array(
            'upload_path' => $product->get_upload_path(),
            'allowed_types' => 'jpg|png',
            'encrypt_name' => true,
        );

        $this->load->library('my_upload', $conf);

        $ret = $this->my_upload->multi_upload(get_upload_files_request());

        if(is_array($ret)) {
            list($errors, $successes) = $ret;
            $error_set = array();
            foreach($errors as $k => $err) {
                $error_set[] = $k . " -> " . $err;
            }
            $error_msg = implode(br(1), $error_set);
            $this->session->set_flashdata('upload_error', $error_msg);

            $product->product_image = $this->product_image_model->insert_multiple($product, $successes);
            foreach($product->product_image as $product_img) {
                $product_img->save();
            }
        }
        redirect(site_url('admin/product/edit/'.$product->id)."?tab=1");
    }

    public function upload_primary($id) {
        $product = new Product_Model($id);
        $conf = array(
            'upload_path'   => $product->get_upload_path(),
            'allowed_types' => 'jpg|png',
            'file_name'     => 'primary',
        );

        $this->load->library('my_upload', $conf);
        if( ! $this->my_upload->do_upload('primary_image')) {
            $error = "Primary Image -> ".$this->my_upload->error_msg[0];
            $this->session->set_flashdata('upload_error', $error);
        }
        else {
            $success = $this->my_upload->data();
            $product->delete_primary_image();
            $product->primary_image_url = $product->get_download_path().$success['file_name'];
            $product->save();
        }
        redirect(site_url('admin/product/edit/'.$product->id)."?tab=1");
    }

    public function save_img_info($image_id) {
        $product_image = new Product_Image_Model($image_id);
        $product_image->populate_from_request($_POST);
        $status = $product_image->save();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function del_product_image($image_id) {
        $product_image = new Product_Image_Model($image_id);
        $status = $product_image->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function ajax_search() {
        $q = get_post('term');
        $product_set = $this->product_model->search_related($q, false, false, false);
        echo json_encode($product_set);
    }
}
