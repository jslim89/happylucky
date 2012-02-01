<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Banner 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Banner extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->Model('banner_model');
    }

    public function index($page = 0) {
        $this->vars['title'] = lang('banner_management');
        $this->vars['images'] = $this->banner_model->get_all();
        $this->load_view('admin/banner/index', $this->vars);
    }

    /**
     * Must be an existing amulet, if $id is null
     * it is not possible to upload 
     * 
     * @param mixed $id 
     * @return void
     */
    public function upload($id) {
        $conf = array(
            'upload_path' => $this->banner_model->get_upload_path(),
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
        }
        redirect(site_url('admin/banner'));
    }

    public function delete() {
        $images = (array)get_post('check');
        $success = array();
        $error = array();
        foreach($images as $img) {
            $is_deleted = $this->banner_model->delete($img);
            if($is_deleted) {
                $success[] = lang('image').' '.$img.' '.lang('deleted');
            }
            else {
                $error[] = lang('image').' '.$img.' '.lang('failed_to_delete');
            }
        }
        $this->session->set_flashdata('delete_success', implode("\n", $success));
        $this->session->set_flashdata('delete_failed', implode("\n", $error));
        redirect(site_url('admin/banner'));
    }
}
