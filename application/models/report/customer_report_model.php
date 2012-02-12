<?php
require_once "report_model.php";

class Customer_Report_Model extends Report_Model {

    public $title;

    protected $header_set;
    protected $auto_fit_width;

    public function __construct() {
        parent::__construct();
        $this->_ci->load->model('customer_model');
        $this->header_set = array_merge(
            array(lang('report_customer_name')),
            parent::get_short_month_dropdown_list(),
            array(lang('report_total'))
        );

        $this->title = lang('report_total_customer_spent');
        $this->auto_fit_width = true;
    }

    public function init($year, $limit) {
        $this->year  = $year ? $year : (int)date('Y');
        $this->limit = $limit ? $limit : 10;
    }

    public function to_excel() {
        $this->_ci->load->library('xlsreport');
        $this->_ci->xlsreport->init($this);
        $this->_ci->xlsreport->build_header($this->header_set);

        $row = $this->_ci->xlsreport->get_starting_row();
        foreach($this->get_column_set() as $rs) {
            $col = 0;
            foreach($rs as $k => $v) {
                if($k === 'customer_id') continue;
                if($k != 'customer') $v = to_currency($v);
                $this->_ci->xlsreport->set_text_by_col_row($col, $row, $v);
                $col++;
            }
            $row++;
        }
        $this->_ci->xlsreport->send_file(true);
    }

    public function get_header_set() {
        return $this->header_set;
    }

    public function get_column_set() {
        $sql = $this->_build_sql();
        $result_set = $this->adodb->SelectLimit($sql, $this->limit, 0);
        if($result_set === FALSE)
            echo $this->adodb->ErrorMsg();
        $column_set = array();
        foreach($result_set as $result) {
            if(empty($result['customer_id'])) { // Not a member
                $cust_name    = lang('report_non_member');
            }
            else {
                $c            = new Customer_Model($result['customer_id']);
                $cust_name    = $c->first_name . ', ' . $c->last_name;
            }
            $temp         = array_merge(array('customer' => $cust_name), $result);
            $column_set[] = $temp;
        }
        return $column_set;
    }

    protected function _build_sql() {
        $this->_ci->load->model('customer_order_model');
        $sql = "SELECT customer_id"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 1, grand_total, 0)) AS january"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 2, grand_total, 0)) AS february"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 3, grand_total, 0)) AS march"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 4, grand_total, 0)) AS april"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 5, grand_total, 0)) AS may"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 6, grand_total, 0)) AS june"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 7, grand_total, 0)) AS july"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 8, grand_total, 0)) AS august"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 9, grand_total, 0)) AS september"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 10, grand_total, 0)) AS october"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 11, grand_total, 0)) AS november"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(order_date)) = 12, grand_total, 0)) AS december"
            . ", SUM(grand_total) AS total"
            . " FROM customer_order"
            . " WHERE YEAR(FROM_UNIXTIME(order_date)) = $this->year"
            . " AND order_status = '".Customer_Order_Model::COMPLETED."'"
            . " GROUP BY customer_id"
            . " ORDER BY total";
        return $sql;
    }
}
