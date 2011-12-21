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
        $this->load->Model('monk_model');
        $this->load->Model('amulet_type_model');
    }

    public function index($page = 0) {
        $q = get_post('q');
        $amulet = new Amulet_Model(0);
        list($amulets, $total_rows) = (empty($q)) 
            ? $amulet->get_paged(10, $page)
            : $amulet->search_related($q, 10, $page);
        $this->vars['pagination'] = $amulet->get_pagination($total_rows, 10);
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
        $this->load_view('admin/amulet/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('amulet_edit_amulet');
        $amulet = new Amulet_Model($id);
        $this->vars['amulet'] = $amulet;
        $this->load_view('admin/amulet/add_edit', $this->vars);
    }

    public function save($id = null) {
        $amulet = new Amulet_Model($id);
        $amulet->populate_from_request($_POST);

        if($amulet->save()) {
            redirect('admin/amulet/edit/'.$amulet->id);
        }
        else
            $this->load->view('admin/amulet/index', $this->vars);
    }

    public function delete($id) {
        $amulet = new Amulet_Model($id);
        $status = $amulet->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }
}
