<?php
require_once "report_model.php";

class Product_Report_Model extends Report_Model {

    public $title;

    protected $header_set;
    protected $auto_fit_width;

    public function __construct() {
        parent::__construct();
        $this->_ci->load->model('product_model');
        $this->header_set = array_merge(
            array(lang('report_product')),
            parent::get_short_month_dropdown_list(),
            array(lang('report_total'))
        );

        $this->title = lang('report_total_product_sold');
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
                if($k === 'product_id') continue;
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
            $p            = new Product_Model($result['product_id']);
            $prod_name    = $p->product_code . ' - ' . $p->product_name;
            $temp         = array_merge(array('product' => $prod_name), $result);
            $column_set[] = $temp;
        }
        return $column_set;
    }

    protected function _build_sql() {
        $sql = "SELECT product_id"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 1, d.quantity, 0)) AS january"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 2, d.quantity, 0)) AS february"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 3, d.quantity, 0)) AS march"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 4, d.quantity, 0)) AS april"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 5, d.quantity, 0)) AS may"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 6, d.quantity, 0)) AS june"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 7, d.quantity, 0)) AS july"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 8, d.quantity, 0)) AS august"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 9, d.quantity, 0)) AS september"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 10, d.quantity, 0)) AS october"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 11, d.quantity, 0)) AS november"
            . ", SUM(IF(MONTH(FROM_UNIXTIME(o.order_date)) = 12, d.quantity, 0)) AS december"
            . ", SUM(quantity) AS total"
            . " FROM customer_order o JOIN order_detail d ON o.id = d.order_id"
            . " WHERE YEAR(FROM_UNIXTIME(order_date)) = $this->year"
            . " GROUP BY product_id";
        return $sql;
    }
}
