<?php
require_once "report_model.php";

class Sales_Report_Model extends Report_Model {

    public $title;

    protected $header_set;
    protected $auto_fit_width;

    public function __construct() {
        parent::__construct();
        $this->_ci->load->model('product_model');
        $this->auto_fit_width = true;
    }

    public function to_excel() {
        $this->_ci->load->library('xlsreport');
        $this->_ci->xlsreport->init($this);
        $this->_ci->xlsreport->build_header($this->header_set);

        $row = $this->_ci->xlsreport->get_starting_row();
        foreach($this->get_column_set() as $rs) {
            $col = 0;
            foreach($rs as $k => $v) {
                if($k === 'products') {
                    $value = array();
                    foreach($v as $products) {
                        $value[] = $products['product_code'].' - '.$products['product_name']
                                .' x'.$products['qty_sold'];
                    }
                    $values = implode("\n", $value);
                    $position = $this->_ci->xlsreport->find_position($col, $row);
                    $this->_ci->xlsreport->set_text_by_col_row($col, $row, $values);
                    $this->_ci->xlsreport->set_wrap($position);
                    $col++;
                    continue;
                }
                if($k != 'month' && $k != 'products') $v = to_currency($v);
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

    /**
     * is_current_year 
     * 
     * @return bool
     */
    protected function _is_current_year() {
        return (int)$this->year == (int)date('Y');
    }

    protected function _is_current_month($month) {
        return (int)$month == (int)date('m');
    }

    protected function _is_current_day($day) {
        return (int)$day == (int)date('j');
    }

    /**
     * Return the total amount of the orders
     * 
     * @param mixed $month 
     * @param mixed $day 
     * @return array
     */
    protected function _get_total($month, $day = false) {
        $sql = $this->_build_sql($this->year, $month, $day);
        $result_set = $this->adodb->GetRow($sql);
        return array(
            'revenue' => $result_set['revenue'],
            'cost'    => $result_set['cost'],
            'profit'  => $result_set['profit'],
        );
    }

    /**
     * SQL to calculate a particular time period (customer order) 
     * 
     * @param mixed $year 
     * @param mixed $month 
     * @param mixed $day 
     * @return string
     */
    protected function _build_sql($year, $month = false, $day = false) {
        $sql = "SELECT SUM(grand_total) as revenue"
            . ", SUM(total_product_cost) as cost"
            . ", SUM(grand_total - total_product_cost - shipping_cost) as profit"
            . " FROM customer_order"
            . " WHERE YEAR(FROM_UNIXTIME(order_date)) = $year";
        if($month) {
            $sql .= " AND MONTH(FROM_UNIXTIME(order_date)) = $month";
        }
        if($day) {
            $sql .= " AND DAY(FROM_UNIXTIME(order_date)) = $day";
        }
        return $sql;
    }

    /**
     * Return the number of days in a month for a particular year 
     * 
     * @param mixed $year 
     * @return array
     */
    protected function _get_months_range() {
        $day_31 = array(0, 2, 4, 6, 7, 9, 11);
        $day_30 = array(3, 5, 8, 10);
        $month_set = array();
        for($i = 0; $i < 12; $i++) {
            switch($i) {
                case 0: case 2: case 4: case 6: case 7: case 9: case 11:
                    $month_set[$i] = 31;
                    break;
                case 3: case 5: case 8: case 10:
                    $month_set[$i] = 30;
                    break;
                case 1:
                    $month_set[$i] = ($this->year % 4 == 0) ? 29 : 28;
                    break;
            }
        }
        return $month_set;
    }
}
