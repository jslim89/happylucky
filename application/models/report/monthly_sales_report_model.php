<?php
require_once "sales_report_model.php";

/**
 * Monthly_Sales_Report_Model 
 * 
 * @uses Sales_Report_Model
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Monthly_Sales_Report_Model extends Sales_Report_Model {

    public function __construct() {
        parent::__construct();
        $this->header_set = array(
            lang('report_day'),
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
    public function init($year = false, $month = false) {
        $this->year = empty($year) ? (int)date('Y') : $year;
        $this->month = empty($month) ? (int)date('m') : $month;
        $this->title = lang('report_sales_report').': '.$this->months[$this->month-1].' '.$this->year;
    }

    /**
     * Return a overall result set which are going to display 
     * 
     * @return array
     */
    public function get_column_set() {
        $month_set = $this->_get_months_range();
        $column_set = array();
        for($day = 1; $day <= $month_set[$this->month-1]; $day++) {
            // Only return the data until last day if it is current year and month
            if($this->_is_current_year() && $this->_is_current_month($this->month) && $this->_is_current_day($day))
                break;

            // month_idx start from 0, whereas MONTH(FROM_UNIXTIME(month)) 
            // start from 1
            $total_set = $this->_get_total($this->month, $day);
            $column_set[$day] = array_merge(
                array('day' => $day),
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
                if($k != 'day') $v = to_currency($v);
                $this->_ci->xlsreport->set_text_by_col_row($col, $row, $v);
                $col++;
            }
            $row++;
        }
        $this->_ci->xlsreport->send_file(true);
    }
}
