<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Amulet_Type 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Amulet_Type extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('amulet_type');
        $this->load->Model('amulet_type_model');
        $this->load->Model('amulet_type_image_model');
    }

    public function index($page = 0) {
        $q = get_post('q');
        $amulet_type = new Amulet_Type_Model();
        list($amulet_types, $total_rows) = (empty($q)) 
            ? $amulet_type->get_paged(10, $page)
            : $amulet_type->search_related($q, 10, $page);
        /* Pagination */
        $this->vars['pagination'] = $amulet_type->get_pagination($total_rows, 10);
        $pagin_first              = ($total_rows == 0) ? $page : $page + 1;
        $pagin_last               = (($page + 10) < $total_rows) ? ($page + 10) : $total_rows;
        $this->vars['pagin']      = $pagin_first.' - '.$pagin_last.' '.lang('of').' '.$total_rows;

        $this->vars['title'] = lang('amulet_type_management');
        $this->vars['amulet_types'] = $amulet_types;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('admin/amulet_type/index'),
        );
        $this->load_view('admin/amulet_type/list', $this->vars);
    }

    public function add() {
        // Set an empty object as the amulet_type variable is required
        $this->vars['title'] = lang('amulet_type_add_new_amulet_type');
        $amulet_type = new Amulet_Type_Model();
        $this->vars['amulet_type'] = $amulet_type;
        $this->vars['image_upload'] = $amulet_type->get_image_upload_config();
        $this->load_view('admin/amulet_type/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('amulet_type_edit_amulet_type');
        $amulet_type = new Amulet_Type_Model($id);
        $this->vars['amulet_type'] = $amulet_type;
        $this->vars['images'] = $amulet_type->amulet_type_image;
        $this->vars['image_upload'] = $amulet_type->get_image_upload_config();
        $this->load_view('admin/amulet_type/add_edit', $this->vars);
    }

    public function save($id = null) {
        $amulet_type = new Amulet_Type_Model($id);
        $amulet_type->populate_from_request($_POST);

        if($amulet_type->save()) {
            $success = ($id === null) ? lang('inserted') : lang('updated');
            $this->session->set_flashdata('general_success', $success);
            redirect('admin/amulet_type/edit/'.$amulet_type->id);
        }
        else {
            $error = ($id === null) ? lang('insert_failed') : lang('update_failed');
            $this->session->set_flashdata('general_error', $error);
            redirect('admin/amulet_type/index');
        }
    }

    public function delete($id) {
        $amulet_type = new Amulet_Type_Model($id);
        $status = $amulet_type->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    /**
     * Must be an existing amulet_type, if $id is null
     * it is not possible to upload 
     * 
     * @param mixed $id 
     * @return void
     */
    public function upload($id) {
        $amulet_type = new Amulet_Type_Model($id);
        $conf = array(
            'upload_path' => $amulet_type->get_upload_path(),
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
            $this->session->set_flashdata('general_error', $error_msg);

            $amulet_type->amulet_type_image = $this->amulet_type_image_model->insert_multiple($amulet_type, $successes);
            $success_set = array();
            foreach($amulet_type->amulet_type_image as $amulet_type_img) {
                $amulet_type_img->save();
                $success_set[] = $amulet_type_img->image_name.' '.lang('uploaded');
            }
            $this->session->set_flashdata('general_success', implode(br(1), $success_set));
        }
        redirect(site_url('admin/amulet_type/edit/'.$amulet_type->id)."?tab=1");
    }

    public function upload_primary($id) {
        $amulet_type = new Amulet_Type_Model($id);
        $conf = array(
            'upload_path'   => $amulet_type->get_upload_path(),
            'allowed_types' => 'jpg|png',
            'file_name'     => 'primary',
        );

        $this->load->library('my_upload', $conf);
        if( ! $this->my_upload->do_upload('primary_image')) {
            $error = "Primary Image -> ".$this->my_upload->error_msg[0];
            $this->session->set_flashdata('general_error', $error);
        }
        else {
            $success = $this->my_upload->data();
            $amulet_type->delete_primary_image();
            $amulet_type->primary_image_url = $amulet_type->get_download_path().$success['file_name'];
            $amulet_type->save();
            $this->session->set_flashdata('general_success', lang('primary_image').' '.lang('updated'));
        }
        redirect(site_url('admin/amulet_type/edit/'.$amulet_type->id)."?tab=1");
    }

    public function save_img_info($image_id) {
        $amulet_type_image = new Amulet_Type_Image_Model($image_id);
        $amulet_type_image->image_name = get_post('image_name');
        $amulet_type_image->image_desc = get_post('image_desc');
        $status = $amulet_type_image->save();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function del_amulet_type_image($image_id) {
        $amulet_type_image = new Amulet_Type_Image_Model($image_id);
        $status = $amulet_type_image->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function ajax_search() {
        $q = get_post('term');
        $amulet_type_set = $this->amulet_type_model->search_related($q, false, false, false);
        echo json_encode($amulet_type_set);
    }
}
