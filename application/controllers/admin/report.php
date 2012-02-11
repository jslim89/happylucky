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
    public function sales_yearly() {
        $this->load->model('report/yearly_sales_report_model', 'yearly_sales_report');

        $this->yearly_sales_report->init(get_post('year', false));
        $column_set = $this->yearly_sales_report->get_column_set();
        $this->vars['title']         = $this->yearly_sales_report->title;
        $this->vars['header_set']    = $this->yearly_sales_report->get_header_set();
        $this->vars['column_set']    = $column_set;
        $this->vars['start_year']    = (int)date('Y') - 5;
        $this->vars['end_year']      = (int)date('Y');
        $this->vars['selected_year'] = get_post('year', (int)date('Y'));
        $this->load_view('admin/report/sales_yearly', $this->vars);
    }

    public function export_sales_yearly($year) {
        $this->load->model('report/yearly_sales_report_model', 'sales_report');
        $this->sales_report->init($year);
        $this->sales_report->to_excel();
    }

    public function sales_monthly() {
        $this->load->model('report/monthly_sales_report_model', 'monthly_sales_report');

        $month = get_post('month', false);
        if($month) $month += 1;
        $this->monthly_sales_report->init(get_post('year', false), $month);
        $column_set = $this->monthly_sales_report->get_column_set();
        $this->vars['title']          = $this->monthly_sales_report->title;
        $this->vars['header_set']     = $this->monthly_sales_report->get_header_set();
        $this->vars['column_set']     = $column_set;
        $this->vars['start_year']     = (int)date('Y') - 5;
        $this->vars['end_year']       = (int)date('Y');
        $this->vars['selected_year']  = get_post('year', (int)date('Y'));
        $this->vars['selected_month'] = $month;
        $this->load_view('admin/report/sales_monthly', $this->vars);
    }

    public function export_sales_monthly($year, $month) {
        $this->load->model('report/monthly_sales_report_model', 'sales_report');
        $this->sales_report->init($year, $month);
        $this->sales_report->to_excel();
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
        $this->vars['title']         = $this->product_report->title;
        $this->vars['header_set']    = $this->product_report->get_header_set();
        $this->vars['column_set']    = $column_set;
        $this->vars['start_year']    = (int)date('Y') - 5;
        $this->vars['end_year']      = (int)date('Y');
        $this->vars['selected_year'] = get_post('year', (int)date('Y'));
        $this->load_view('admin/report/product', $this->vars);
    }

    public function export_product($year) {
        $this->load->model('report/product_report_model', 'product_report');
        $this->product_report->init($year, 10);
        $this->product_report->to_excel();
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
        $this->vars['title']         = $this->customer_report->title;
        $this->vars['header_set']    = $this->customer_report->get_header_set();
        $this->vars['column_set']    = $column_set;
        $this->vars['start_year']    = (int)date('Y') - 5;
        $this->vars['end_year']      = (int)date('Y');
        $this->vars['selected_year'] = get_post('year', (int)date('Y'));
        $this->load_view('admin/report/customer', $this->vars);
    }

    public function export_customer($year) {
        $this->load->model('report/customer_report_model', 'customer_report');
        $this->customer_report->init($year, 10);
        $this->customer_report->to_excel();
    }
}

/* End of file report.php */
/* Location: ./application/controllers/report.php */
