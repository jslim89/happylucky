<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Supplier 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Supplier extends MY_Controller {

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('supplier');
        $this->load->Model('supplier_model');
        $this->load->Model('country_model');
    }

    public function index($page = 0) {
        $q = get_post('q');
        $supplier = new Supplier_Model();
        list($suppliers, $total_rows) = (empty($q)) 
            ? $supplier->get_paged(10, $page)
            : $supplier->search_related($q, 10, $page);
        $this->vars['pagination'] = $supplier->get_pagination($total_rows, 10);
        $this->vars['title'] = lang('supplier_management');
        $this->vars['suppliers'] = $suppliers;
        $this->vars['search_form_info'] = array(
            'search_url' => site_url('admin/supplier/index'),
        );
        $this->load_view('admin/supplier/list', $this->vars);
    }

    public function add() {
        // Set an empty object as the supplier variable is required
        $this->vars['title'] = lang('supplier_add_new_supplier');
        $supplier = new Supplier_Model();
        $this->vars['supplier'] = $supplier;
        $this->load_view('admin/supplier/add_edit', $this->vars);
    }

    public function edit($id) {
        $this->vars['title'] = lang('supplier_edit_supplier');
        $supplier = new Supplier_Model($id);
        $this->vars['supplier'] = $supplier;
        $this->load_view('admin/supplier/add_edit', $this->vars);
    }

    public function save($id = null) {
        $supplier = new Supplier_Model($id);
        $supplier->populate_from_request($_POST);

        if($supplier->save()) {
            redirect('admin/supplier/edit/'.$supplier->id);
        }
        else
            $this->load->view('admin/supplier/index', $this->vars);
    }

    public function delete($id) {
        $supplier = new Supplier_Model($id);
        $status = $supplier->delete();
        echo json_encode(array(
            'status' => $status
        ));
    }

    public function ajax_search() {
        $q = get_post('term');
        $supplier_set = $this->supplier_model->search_related($q, false, false, false);
        echo json_encode($supplier_set);
    }
}
