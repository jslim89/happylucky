<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Amulet 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Amulet extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('amulet');
        $this->load->Model('amulet_model');
        $this->load->Model('amulet_image_model');
        $this->load->Model('monk_model');
        $this->load->Model('amulet_type_model');
    }

    public function index($page = 0) {
        $q = get_post('q');
        $amulet = new Amulet_Model(0);
        list($amulets, $total_rows) = (empty($q)) 
            ? $amulet->get_paged(10, $page)
            : $amulet->search_related($q, 10, $page);
        /* Pagination */
        $this->vars['pagination'] = $amulet->get_pagination($total_rows, 10);
        $pagin_first              = ($total_rows == 0) ? $page : $page + 1;
        $pagin_last               = (($page + 10) < $total_rows) ? ($page + 10) : $total_rows;
        $this->vars['pagin']      = $pagin_first.' - '.$pagin_last.' '.lang('of').' '.$total_rows;

        $this->vars['title'] = lang('amulet_management');
        $this->vars['amulets'] = $amulets;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('admin/amulet/index'),
        );
        $this->load_view('admin/amulet/list', $this->vars);
    }

    public function add() {
        // Set an empty object as the amulet variable is required
        $this->vars['title'] = lang('amulet_add_new_amulet');
        $amulet = new Amulet_Model();
        $this->vars['amulet'] = $amulet;
        $this->vars['image_upload'] = $amulet->get_image_upload_config();
        $this->load_view('admin/amulet/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('amulet_edit_amulet');
        $amulet = new Amulet_Model($id);
        $this->vars['amulet'] = $amulet;
        $this->vars['images'] = $amulet->amulet_image;
        $this->vars['image_upload'] = $amulet->get_image_upload_config();
        $this->load_view('admin/amulet/add_edit', $this->vars);
    }

    public function save($id = null) {
        $amulet = new Amulet_Model($id);
        $amulet->populate_from_request($_POST);

        if($amulet->save()) {
            $success = ($id === null) ? lang('inserted') : lang('updated');
            $this->session->set_flashdata('general_success', $success);
            redirect('admin/amulet/edit/'.$amulet->id);
        }
        else {
            $error = ($id === null) ? lang('insert_failed') : lang('update_failed');
            $this->session->set_flashdata('general_error', $error);
            redirect('admin/amulet/index');
        }
    }

    public function delete($id) {
        $amulet = new Amulet_Model($id);
        $status = $amulet->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    /**
     * Must be an existing amulet, if $id is null
     * it is not possible to upload 
     * 
     * @param mixed $id 
     * @return void
     */
    public function upload($id) {
        $amulet = new Amulet_Model($id);
        $conf = array(
            'upload_path' => $amulet->get_upload_path(),
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

            $amulet->amulet_image = $this->amulet_image_model->insert_multiple($amulet, $successes);
            $success_set = array();
            foreach($amulet->amulet_image as $amulet_img) {
                $amulet_img->save();
                $success_set[] = $amulet_img->image_name.' '.lang('uploaded');
            }
            $this->session->set_flashdata('general_success', implode(br(1), $success_set));
        }
        redirect(site_url('admin/amulet/edit/'.$amulet->id)."?tab=1");
    }

    public function upload_primary($id) {
        $amulet = new Amulet_Model($id);
        $conf = array(
            'upload_path'   => $amulet->get_upload_path(),
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
            $amulet->delete_primary_image();
            $amulet->primary_image_url = $amulet->get_download_path().$success['file_name'];
            $amulet->save();
            $this->session->set_flashdata('general_success', lang('primary_image').' '.lang('updated'));
        }
        redirect(site_url('admin/amulet/edit/'.$amulet->id)."?tab=1");
    }

    public function save_img_info($image_id) {
        $amulet_image = new Amulet_Image_Model($image_id);
        $amulet_image->image_name = get_post('image_name');
        $amulet_image->image_desc = get_post('image_desc');
        $status = $amulet_image->save();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function del_amulet_image($image_id) {
        $amulet_image = new Amulet_Image_Model($image_id);
        $status = $amulet_image->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function ajax_search() {
        $q = get_post('term');
        $amulet_set = $this->amulet_model->search_related($q, false, false, false);
        echo json_encode($amulet_set);
    }

    public function check_amulet_code() {
        $code = get_post('fieldValue');
        $is_unique = Amulet_Model::is_amulet_code_unique($code);
        $to_js = array(
            get_post('fieldId'),
            $is_unique,
        );
        echo json_encode($to_js);
    }
}
