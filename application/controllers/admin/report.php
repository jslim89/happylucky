<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Report 
 * 
 * @uses MY_Controller
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Report extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect('admin');
    }

    /**
     * Sales Report 
     * 
     * @return void
     */
    public function sales() {
        $this->load->model('report/sales_report_model', 'sales_report');

        $this->sales_report->init(get_post('year', false));
        $column_set = $this->sales_report->get_column_set();
        $this->vars['title']         = lang('report_sales_report');
        $this->vars['column_set']    = $column_set;
        $this->vars['start_year']    = (int)date('Y') - 5;
        $this->vars['end_year']      = (int)date('Y');
        $this->vars['selected_year'] = get_post('year', (int)date('Y'));
        $this->load_view('admin/report/sales', $this->vars);
    }

    /**
     * Product Report 
     * 
     * @return void
     */
    public function product() {
        $this->load->model('report/product_report_model', 'product_report');

        $this->product_report->init(get_post('year', false), 10);
        $column_set                  = $this->product_report->get_column_set();
        $this->vars['title']         = lang('report_total_product_sold');
        $this->vars['column_set']    = $column_set;
        $this->vars['start_year']    = (int)date('Y') - 5;
        $this->vars['end_year']      = (int)date('Y');
        $this->vars['selected_year'] = get_post('year', (int)date('Y'));
        $this->load_view('admin/report/product', $this->vars);
    }

    /**
     * Customer Report 
     * 
     * @return void
     */
    public function customer() {
        $this->load->model('report/customer_report_model', 'customer_report');

        $this->customer_report->init(get_post('year', false), 10);
        $column_set                  = $this->customer_report->get_column_set();
        $this->vars['title']         = lang('report_total_customer_spent');
        $this->vars['column_set']    = $column_set;
        $this->vars['start_year']    = (int)date('Y') - 5;
        $this->vars['end_year']      = (int)date('Y');
        $this->vars['selected_year'] = get_post('year', (int)date('Y'));
        $this->load_view('admin/report/customer', $this->vars);
    }
}

/* End of file report.php */
/* Location: ./application/controllers/report.php */
