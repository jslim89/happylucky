<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Monk 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Monk extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('monk');
        $this->load->Model('monk_model');
        $this->load->Model('monk_image_model');
    }

    public function index($page = 0) {
        $q = get_post('q');
        $monk = new Monk_Model();
        list($monks, $total_rows) = (empty($q)) 
            ? $monk->get_paged(10, $page)
            : $monk->search_related($q, 10, $page);
        /* Pagination */
        $this->vars['pagination'] = $monk->get_pagination($total_rows, 10);
        $pagin_first              = $page + 1;
        $pagin_last               = (($page + 10) < $total_rows) ? ($page + 10) : $total_rows;
        $this->vars['pagin']      = $pagin_first.' - '.$pagin_last.' '.lang('of').' '.$total_rows;

        $this->vars['title'] = lang('monk_management');
        $this->vars['monks'] = $monks;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('admin/monk/index'),
        );
        $this->load_view('admin/monk/list', $this->vars);
    }

    public function add() {
        // Set an empty object as the monk variable is required
        $this->vars['title'] = lang('monk_add_new_monk');
        $monk = new Monk_Model();
        $this->vars['monk'] = $monk;
        $this->vars['image_upload'] = $monk->get_image_upload_config();
        $this->load_view('admin/monk/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('monk_edit_monk');
        $monk = new Monk_Model($id);
        $this->vars['monk'] = $monk;
        $this->vars['images'] = $monk->monk_image;
        $this->vars['image_upload'] = $monk->get_image_upload_config();
        $this->load_view('admin/monk/add_edit', $this->vars);
    }

    public function save($id = null) {
        $monk = new Monk_Model($id);
        $monk->populate_from_request($_POST);

        if($monk->save()) {
            $success = ($id === null) ? lang('inserted') : lang('updated');
            $this->session->set_flashdata('general_success', $success);
            redirect('admin/monk/edit/'.$monk->id);
        }
        else {
            $error = ($id === null) ? lang('insert_failed') : lang('update_failed');
            $this->session->set_flashdata('general_error', $error);
            redirect('admin/monk/index');
        }
    }

    public function delete($id) {
        $monk = new Monk_Model($id);
        $status = $monk->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    /**
     * Must be an existing monk, if $id is null
     * it is not possible to upload 
     * 
     * @param mixed $id 
     * @return void
     */
    public function upload($id) {
        $monk = new Monk_Model($id);
        $conf = array(
            'upload_path' => $monk->get_upload_path(),
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

            $monk->monk_image = $this->monk_image_model->insert_multiple($monk, $successes);
            $success_set = array();
            foreach($monk->monk_image as $monk_img) {
                $monk_img->save();
                $success_set[] = $monk_img->image_name.' '.lang('uploaded');
            }
            $this->session->set_flashdata('general_success', implode(br(1), $success_set));
        }
        redirect(site_url('admin/monk/edit/'.$monk->id)."?tab=1");
    }

    public function upload_primary($id) {
        $monk = new Monk_Model($id);
        $conf = array(
            'upload_path'   => $monk->get_upload_path(),
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
            $monk->delete_primary_image();
            $monk->primary_image_url = $monk->get_download_path().$success['file_name'];
            $monk->save();
            $this->session->set_flashdata('general_success', lang('primary_image').' '.lang('updated'));
        }
        redirect(site_url('admin/monk/edit/'.$monk->id)."?tab=1");
    }

    public function save_img_info($image_id) {
        $monk_image = new Monk_Image_Model($image_id);
        $monk_image->image_name = get_post('image_name');
        $monk_image->image_desc = get_post('image_desc');
        $status = $monk_image->save();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function del_monk_image($image_id) {
        $monk_image = new Monk_Image_Model($image_id);
        $status = $monk_image->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function ajax_search() {
        $q = get_post('term');
        $monk_set = $this->monk_model->search_related($q, false, false, false);
        echo json_encode($monk_set);
    }
}
