<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_Model extends CI_Model {

    var $widget_dir;
    var $widget_ext;

    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        $this->widget_dir = APPPATH . "views/admin/dashboard/widget/";
        $this->widget_ext = ".widget.php";
        parent::__construct();
    }

    /**
     * Get the widget file name 
     * 
     * @return array
     */
    public function get_widgets() {
        $widgets = array();
        foreach(glob($this->widget_dir.'*'.$this->widget_ext) as $widget) {
            $widgets[] = $this->_get_widget_filename($widget);
        }
        return $widgets;
    }

    /**
     * Break the URL into smaller pieces by "/" and return only the last part
     * of the URL as the file name
     * 
     * @param mixed $widget 
     * @return string
     */
    private function _get_widget_filename($widget) {
        $widget_url = explode('/', $widget);
        return $widget_url[count($widget_url) - 1];
    }
}
