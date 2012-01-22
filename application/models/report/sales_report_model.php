<?php
require_once "report_model.php";

class Sales_Report_Model extends Report_Model {

    public function __construct() {
        parent::__construct();
        $this->_ci->load->model('product_model');
    }

    /**
     * initialization 
     * 
     * @param mixed $year default value is current year
     * @return void
     */
    public function init($year = false) {
        $this->year = empty($year) ? (int)date('Y') : $year;
    }

    /**
     * is_current_year 
     * 
     * @return bool
     */
    private function _is_current_year() {
        return (int)$this->year == (int)date('Y');
    }

    private function _is_current_month($month) {
        return (int)$month == (int)date('m');
    }

    /**
     * Return a overall result set which are going to display 
     * 
     * @return array
     */
    public function get_column_set() {
        $this->_ci->load->model('customer_order_model');
        $month_set = $this->_get_months_range();
        $column_set = array();
        foreach($month_set as $month_idx => $no_of_days) {
            // Only return the data until last month if it is current year
            if($this->_is_current_year() && $this->_is_current_month($month_idx+1))
                break;
            // ISO 8601 format YYYY-MM-DD
            $start_date = strtotime("$this->year-$month_idx-01");
            $end_date   = strtotime("$this->year-$month_idx-$no_of_days");

            $column_set[$month_idx] = $this->_get_total($start_date, $end_date);
            $column_set[$month_idx]['month'] = $this->months[$month_idx];
            $column_set[$month_idx]['products'] = $this->_get_product_count($start_date, $end_date);
        }
        return $column_set;
    }

    /**
     * Return the total amount of the orders
     * 
     * @param mixed $start_date 
     * @param mixed $end_date 
     * @return array
     */
    private function _get_total($start_date, $end_date) {
        $sql = "SELECT SUM(subtotal) AS s_total"
            . ", SUM(shipping_cost) AS shipping"
            . ", SUM(grand_total) AS g_total"
            . " FROM customer_order"
            . " WHERE order_date BETWEEN $start_date AND $end_date";
        $result_set = $this->adodb->GetRow($sql);
        return array(
            'subtotal'    => $result_set['s_total'],
            'shipping'    => $result_set['shipping'],
            'grand_total' => $result_set['g_total'],
        );
    }

    /**
     * Return a set of product in array form 
     * 
     * @param mixed $start_date 
     * @param mixed $end_date 
     * @return array
     */
    private function _get_product_count($start_date, $end_date) {
        $sql = "SELECT product_id, SUM(quantity) as qty_sold"
            . " FROM customer_order o JOIN order_detail d ON o.id = d.order_id"
            . " WHERE order_date BETWEEN $start_date AND $end_date"
            . " GROUP BY product_id";

        $products = $this->adodb->Execute($sql);
        $product_set = array();
        foreach($products as $p) {
            $product = new Product_Model($p['product_id']);
            $product_set[$p['product_id']]['product_code'] = $product->product_code;
            $product_set[$p['product_id']]['product_name'] = $product->product_name;
            $product_set[$p['product_id']]['qty_sold']     = $p['qty_sold'];
        }
        return $product_set;
    }

    /**
     * Return the number of days in a month for a particular year 
     * 
     * @param mixed $year 
     * @return array
     */
    private function _get_months_range() {
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
