<?php

class Report_Model {

    /**
     * CodeIgniter variable
     */
    protected $_ci;
    protected $adodb;
    protected $months;

    public function __construct() {
        $this->_ci =& get_instance();
        $this->adodb = $this->_ci->adodb;
        $this->months = array(
            0  => lang('january'),
            1  => lang('february'),
            2  => lang('march'),
            3  => lang('april'),
            4  => lang('may'),
            5  => lang('june'),
            6  => lang('july'),
            7  => lang('august'),
            8  => lang('september'),
            9  => lang('october'),
            10 => lang('november'),
            11 => lang('december'),
        );
    }

    /**
     * Return a list of year that specify in a range which able to 
     * bind to dropdown list 
     * 
     * @param mixed $start_year 
     * @param mixed $end_year 
     * @return array
     */
    public static function get_year_dropdown_list($start_year, $end_year) {
        $list = array();
        for($i = $end_year; $i >= $start_year; $i--) {
            $list[$i] = $i;
        }
        return $list;
    }

    public static function get_month_dropdown_list() {
        $report = new Report_Model();
        return $report->months;
    }

    public static function get_short_month_dropdown_list() {
        return array(
            0  => lang('jan'),
            1  => lang('feb'),
            2  => lang('mar'),
            3  => lang('apr'),
            4  => lang('may'),
            5  => lang('jun'),
            6  => lang('jul'),
            7  => lang('aug'),
            8  => lang('sep'),
            9  => lang('oct'),
            10 => lang('nov'),
            11 => lang('dec'),
        );
    }
}
