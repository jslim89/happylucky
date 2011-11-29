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
    }

    public function index($page = 1) {
        $monk = new Monk_Model();
        $monks = $monk->get_paged($page);
        $this->vars['pagination'] = $monks->get_pagination();
        $this->vars['title'] = lang('monk_management');
        $this->vars['monks'] = $monks;
        $this->load_view('admin/monk/list', $this->vars);
    }

    public function add() {
        // Set an empty object as the monk variable is required
        $this->vars['title'] = lang('monk_edit_monk');
        $this->vars['monk'] = new Monk_Model();
        $this->load->view('admin/monk/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('monk_add_new_monk');
        $monk = new Monk_Model($id);
        $this->vars['monk'] = $monk;
        $this->load->view('admin/monk/add_edit', $this->vars);
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
        $monk->delete();
    }

    public function search() {
        $q = get_post('term');
        $monk = $this->monk_model->ajax_search($q);
        echo json_encode($monk);
    }
}
