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
        $monk = new Monk_Model();
        list($monks, $total_rows) = $monk->get_paged(10, $page);
        $this->vars['pagination'] = $monk->get_pagination($total_rows, 10);
        $this->vars['title'] = lang('monk_management');
        $this->vars['monks'] = $monks;
        $this->load_view('admin/monk/list', $this->vars);
    }

    public function add() {
        // Set an empty object as the monk variable is required
        $this->vars['title'] = lang('monk_edit_monk');
        $this->vars['monk'] = new Monk_Model();
        $this->load_view('admin/monk/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('monk_add_new_monk');
        $monk = new Monk_Model($id);
        $this->vars['monk'] = $monk;
        $this->vars['images'] = $monk->monk_image;
        $this->vars['image_upload'] = array(
            'upload_url' => site_url('admin/monk/upload/'.$monk->id),
            'primary_upload_url' => site_url('admin/monk/upload_primary/'.$monk->id),
            'primary_image_url' => $monk->primary_image_url,
            'primary_image_alt' => $monk->monk_name,
            'delete_image_url' => base_url().'admin/monk/del_monk_image/',
            'save_image_url' => base_url().'admin/monk/save_img_info/',
        );
        $this->load_view('admin/monk/add_edit', $this->vars);
    }

    public function save($id = null) {
        $monk = new Monk_Model($id);
        $monk->monk_name  = get_post('monk_name');
        $monk->monk_story = get_post('monk_story');

        if($monk->save()) {
            redirect('admin/monk/edit/'.$monk->id);
        }
        else
            $this->load->view('admin/monk/index', $this->vars);
    }

    public function delete($id) {
        $monk = new Monk_Model($id);
        $status = $monk->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function search() {
        $q = get_post('term');
        $monk = $this->monk_model->ajax_search($q);
        echo json_encode($monk);
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

            $monk->monk_image = $this->monk_image_model->insert_multiple($monk, $successes);
            foreach($monk->monk_image as $monk_img) {
                $monk_img->save();
            }
        }
        redirect('admin/monk/edit/'.$monk->id);
    }

    public function upload_primary($id) {
        $monk = new Monk_Model($id);
        $conf = array(
            'upload_path' => $monk->get_upload_path(),
            'allowed_types' => 'jpg|png',
            'encrypt_name' => true,
        );

        $this->load->library('my_upload', $conf);
        if( ! $this->my_upload->do_upload('primary_image')) {
            $error = $this->my_upload->error_msg['primary_image'];
        }
        else {
            $success = $this->my_upload->data();
            $monk->primary_image_url = $monk->get_download_path().$success['file_name'];
            $monk->save();
        }
        redirect('admin/monk/edit/'.$monk->id);
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
}
