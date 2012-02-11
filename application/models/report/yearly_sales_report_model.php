<?php
require_once "sales_report_model.php";

/**
 * Yearly_Sales_Report_Model 
 * 
 * @uses Sales_Report_Model
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Yearly_Sales_Report_Model extends Sales_Report_Model {

    public function __construct() {
        parent::__construct();
        $this->_ci->load->model('product_model');
        $this->header_set = array(
            lang('report_month'),
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
    public function init($year = false) {
        $this->year = empty($year) ? (int)date('Y') : $year;
        $this->title = lang('report_sales_report').': '.lang('year').' '.$this->year;
    }

    /**
     * Return a overall result set which are going to display 
     * 
     * @return array
     */
    public function get_column_set() {
        $column_set = array();
        foreach($this->months as $month_idx => $long_month) {
            // Only return the data until last month if it is current year
            if($this->_is_current_year() && $this->_is_current_month($month_idx+1))
                break;

            // month_idx start from 0, whereas MONTH(FROM_UNIXTIME(month)) 
            // start from 1
            $total_set = $this->_get_total($month_idx+1);
            $column_set[$month_idx] = array_merge(
                array('month' => $long_month),
                $total_set
            );
        }
        return $column_set;
    }

    public function to_excel() {
        $this->_ci->load->library('xlsreport');
        $this->_ci->xlsreport->init($this);
        $this->_ci->xlsreport->build_header($this->header_set);

        $row = $this->_ci->xlsreport->get_starting_row();
        foreach($this->get_column_set() as $rs) {
            $col = 0;
            foreach($rs as $k => $v) {
                if($k != 'month') $v = to_currency($v);
                $this->_ci->xlsreport->set_text_by_col_row($col, $row, $v);
                $col++;
            }
            $row++;
        }
        $this->_ci->xlsreport->send_file(true);
    }
}
