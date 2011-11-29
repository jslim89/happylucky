<?php

// Use default values of table definition when creating new active record
$ADODB_ACTIVE_DEFVALS = true;

// Disabled auto-pluralize table name
ADOdb_Active_Record::$_changeNames = false;

/**
 * MY_Active_Record 
 * 
 * @uses ADODB_Active_Record
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class MY_Active_Record extends ADOdb_Active_Record {

    /**
     * __construct 
     * 
     * @param mixed $table 
     * @param mixed $pk 
     * @param mixed $db 
     * @return void
     */
    public function __construct($id = false) {
        parent::__construct();
        if($id) $this->load_by_id($id);
    }

    /**
     * Whether a record successfully loaded 
     * 
     * @return boolean
     */
    public function is_exist()
    {
        return is_array($this->_original);
    }

    /**
     * Populate all the value from other object into current object 
     * 
     * @param mixed $obj 
     * @return void
     */
    public function re_assign($obj) {
        foreach($this->columns_name() as $col) {
            $this->$col = $obj->$col;
        }
    }

    /**
     * columns_name 
     * 
     * @param mixed $noncasesensitive 
     * @return array
     */
    public function columns_name($noncasesensitive = true) {
        $columns = $this->get_ci()->adodb->MetaColumns($this->_table, $noncasesensitive);
        $result = array();
        foreach($columns as $col) {
            $result[] = $col->name;
        }
        return $result;
    }

    /**
     * For pagination used 
     * 
     * @param int $page_limit default is 10
     * @param int $offset default is 1
     * @return array
     */
    public function get_paged($page_limit = 10, $offset = 1) {
        $result_set = $this->search("", array(), $page_limit, $offset);
        return $result_set;
    }

    /**
     * get_pagination 
     * 
     * @return mixed
     */
    public function get_pagination($total_rows, $page_limit) {
        $this->get_ci()->load->library('pagination');
        $conf = array(
            'total_rows' => $total_rows,
            'base_url' => $this->_get_curr_url,
            'per_page' => $page_limit,
        );
        $pagination = new CI_Pagination();
        $pagination->initialize($conf);
        return $pagination;
    }

    protected function _get_curr_url() {
        return base_url().$this->get_ci()->router->directory.
            $this->get_ci()->router->class.'/'.$this->get_ci()->router->method;
    }

    /**
     * Searching based on criteria passing in.
     *
     * @param string $criteria_string i.e. "name = ? AND age > ?"
     * This is to allow user key in certain criteria such as <, >
     * @param array $criteria i.e. array('Foo', 20)
     * @param mixed $page_limit
     * @param mixed $offset
     */
    public function search($criteria_string = "", 
                            $criteria = array(), 
                            $page_limit = false,
                            $offset = false) {
        // Dummy criteria
        if(!empty($criteria_string)) $criteria_string .= " 1=1 ";

        // temporary store in an array
        $temp_set = $this->find($criteria_string, $criteria);

        if($page_limit && $offset) {
            $result_set = array();
            $limit = (sizeof($temp_set) < $page_limit) ? sizeof($temp_set) : $page_limit;
            for($i = 0; $i < $limit; $i++) {
                $index = $offset + $i;
                if(element($index, $temp_set, false)) $result_set[] = $temp_set[$limit];
            }
        }
        else {
            $result_set = $temp_set;
        }
        return $result_set;
    }

    /**
     * _find_by 
     * 
     * @param string $column_name 
     * @param array $value 
     * @return array
     */
    private function _find_by($column_name, $value = array())
    {
		if (isset($value[0]))
		{
            return $this->find($column_name."=?", $value);
		}
		throw new Exception("No value is passed in.");
    }

    /**
     * _load_by 
     * 
     * @param string $column_name 
     * @param array $value 
     * @return void
     */
    private function _load_by($column_name, $value = array())
    {
		if (isset($value[0]))
		{
            return $this->load($column_name."=?", $value);
		}
		throw new Exception("No value is passed in.");
    }

    /**
     * You can call dynamic methods which ever available here.
     * i.e. $obj->find_by_column_1('value'); 
     * 
     * @param mixed $method 
     * @param mixed $arguments 
     * @return function
     */
	public function __call($method, $arguments)
	{

		// List of watched method names
		// NOTE: order matters: make sure more specific items are listed before
		// less specific items
		$watched_methods = array(
            'load_by_',
			'find_by_',
		);

		foreach ($watched_methods as $watched_method)
		{
			// See if called method is a watched method
			if (strpos($method, $watched_method) !== FALSE)
			{
				$pieces = explode($watched_method, $method);
                if ( empty($pieces[0]) ) // the watched method is prefix
                    return $this->{'_'.trim($watched_method, '_')}(str_replace($watched_method, '', $method), $arguments);
			}
		}
		// show an error, for debugging's sake.
		throw new Exception("Unable to call the method \"$method\" on the class " . get_class($this));
	}

    private function get_ci() {
        $ci =& get_instance();
        return $ci;
    }
}
