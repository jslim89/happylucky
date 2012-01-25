<?php
require_once "report_model.php";

class Customer_Report_Model extends Report_Model {

    public function __construct() {
        parent::__construct();
        $this->_ci->load->model('customer_model');
    }

    public function init($year, $limit) {
        $this->year  = $year ? $year : (int)date('Y');
        $this->limit = $limit ? $limit : 10;
    }

    public function get_column_set() {
        $sql = $this->_build_sql();
        $result_set = $this->adodb->SelectLimit($sql, $this->limit, 0);
        if($result_set === FALSE)
            echo $this->adodb->ErrorMsg();
        $column_set = array();
        foreach($result_set as $result) {
            $c               = new Customer_Model($result['customer_id']);
            $temp            = $result;
            $temp['customer'] = $c->first_name . ' - ' . $c->last_name;
            $column_set[] = $temp;
        }
        return $column_set;
    }

    protected function _build_sql() {
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
            . " GROUP BY customer_id";
        return $sql;
    }
}
