<?php
require_once "sales_report_model.php";

/**
 * Daily_Sales_Report_Model 
 * 
 * @uses Sales_Report_Model
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Daily_Sales_Report_Model extends Sales_Report_Model {

    public function __construct() {
        parent::__construct();
        $this->header_set = array(
            lang('report_products'),
            lang('report_number_sold'),
            lang('report_revenue'),
            lang('report_cost'),
            lang('report_profit'),
        );
    }

    /**
     * initialization 
     * 
     * @param mixed $year default value is current year
     * @return void
     */
    public function init($year = false, $month = false, $day = false) {
        $this->year  = empty($year) ? (int)date('Y') : $year;
        $this->month = empty($month) ? (int)date('m') : $month;
        $this->day   = empty($day) ? (int)date('j') : $day;
        $this->title = lang('report_sales_report').': '.$this->day
            .' '.$this->months[$this->month-1]
            .' '.$this->year;
    }

    /**
     * Return a overall result set which are going to display 
     * 
     * @return array
     */
    public function get_column_set() {
        $this->_ci->load->model('product_model');
        $sql = $this->_build_sql();
        $result_set = $this->adodb->GetAll($sql);
        $column_set = array();
        foreach($result_set as $k => $result) {
            $product = new Product_Model($result['product_id']);
            $column_set[$k]['product_id']   = $result['product_id'];
            $column_set[$k]['product_code'] = $product->product_code;
            $column_set[$k]['product_name'] = $product->product_name;
            $column_set[$k]['total_sold']   = $result['total_sold'];
            $column_set[$k]['revenue']      = $result['revenue'];
            $column_set[$k]['cost']         = $result['cost'];
            $column_set[$k]['profit']       = $result['profit'];
        }
        return $column_set;
    }

    public function to_excel() {
        $this->_ci->load->library('xlsreport');
        $this->_ci->xlsreport->init($this);
        $this->_ci->xlsreport->build_header($this->header_set);

        $row = $this->_ci->xlsreport->get_starting_row();
        foreach($this->get_column_set() as $rs) {
            $product = $rs['product_code'].' - '.$rs['product_name'];
            unset($rs['product_id']);
            unset($rs['product_code']);
            unset($rs['product_name']);

            // first column is product
            $this->_ci->xlsreport->set_text_by_col_row(0, $row, $product);
            $col = 1;
            foreach($rs as $k => $v) {
                if($k != 'total_sold') $v = to_currency($v);
                $this->_ci->xlsreport->set_text_by_col_row($col, $row, $v);
                $col++;
            }
            $row++;
        }
        $this->_ci->xlsreport->send_file(true);
    }

    protected function _build_sql() {
        $sql = "SELECT product_id"
            . ", SUM(d.quantity) AS total_sold"
            . ", SUM(d.subtotal) AS revenue"
            . ", SUM(d.total_cost) AS cost"
            . ", SUM(d.subtotal - d.total_cost) AS profit"
            . " FROM customer_order o JOIN order_detail d ON o.id = d.order_id"
            . " WHERE YEAR(FROM_UNIXTIME(order_date)) = $this->year"
            . " AND MONTH(FROM_UNIXTIME(order_date)) = $this->month"
            . " AND DAY(FROM_UNIXTIME(order_date)) = $this->day"
            . " GROUP BY product_id";
        return $sql;
    }
}
