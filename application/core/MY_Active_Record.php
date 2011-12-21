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
    public function __construct($id = false, $table = false, $pkeyarr = false, $db = false) {
        parent::__construct($table, $pkeyarr, $db);
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
        $columns = $this->columns($noncasesensitive);
        $result = array();
        foreach($columns as $col) {
            $result[] = $col->name;
        }
        return $result;
    }

    /**
     * The columns with metadata 
     * 
     * @param mixed $noncasesensitive 
     * @return array
     */
    public function columns($noncasesensitive = true) {
        return $this->get_ci()->adodb->MetaColumns($this->_table, $noncasesensitive);
    }

    /**
     * search_related 
     * 
     * @param mixed $q 
     * @return array
     */
    public function search_related($q, $page_limit = 10, $offset = 0) {
        list($criteria_str, $criteria_val) = $this->_get_criteria_set_by_q($q);
        $result_set = $this->search($criteria_str, $criteria_val, $page_limit, $offset, true);
        return $result_set;
    }

    /**
     * Obtain an input from user,
     * i.e. $q = 'foo bar';
     *      $criteria_string = attr_1 LIKE ? OR attr_1 LIKE ? OR
     *                              attr_2 LIKE ? OR attr_2 LIKE ? OR
     *                              attr_n LIKE ? OR attr_n LIKE ? OR
     *      $criteria_value = array(
     *                          'foo', 'bar',
     *                          'foo', 'bar',
     *                          'foo', 'bar'
     *                        );
     * 
     * @param mixed $q refer to the query given by user
     * @return array
     */
    private function _get_criteria_set_by_q($q) {
        // i.e. $q = 'foo bar'; $separated_q = array('foo', 'bar');
        $separated_q = explode(' ', $q);
        $criteria_set = array();
        $criteria_value = array();
        foreach($this->columns() as $col_name => $col) {
            if($col->type == 'varchar' || $col->type == 'char' || $col->type == 'text') {
                foreach($separated_q as $temp_q) {
                    $criteria_set[] = "LOWER(".strtolower($col_name).")"." LIKE ?";
                    $criteria_value[] = "%".$temp_q."%";
                }
            }
        }
        $criteria_string = implode(' OR ', $criteria_set);
        return array($criteria_string, $criteria_value);
    }

    /**
     * For pagination used 
     * 
     * @param int $page_limit default is 10
     * @param int $offset default is 0
     * @return array
     */
    public function get_paged($page_limit = 10, $offset = 0) {
        $result_set = $this->search("", array(), $page_limit, $offset, true);
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
            'base_url' => $this->_get_curr_url(),
            'per_page' => $page_limit,
            'use_page_numbers' => FALSE,
            'uri_segment' => 4,
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
     * @param int $page_limit
     * @param int $offset start from 0
     * @param int $total_rows Whether return the total rows
     */
    public function search($criteria_string = "", 
                            $criteria = array(), 
                            $page_limit = false,
                            $offset = false,
                            $total_rows = false) {
        // Dummy criteria
        if(empty($criteria_string)) $criteria_string .= " 1=1 ";

        // temporary store in an array
        $temp_set = $this->find($criteria_string, $criteria);

        if($page_limit !== FALSE && $offset !== FALSE) {
            $result_set = array();
            $limit = (sizeof($temp_set) < $page_limit) ? sizeof($temp_set) : $page_limit;
            $result_set = array_slice($temp_set, $offset, $limit);
        }
        else {
            $result_set = $temp_set;
        }
        return $total_rows 
            ? array('result_set' => $result_set, 'total_row' => sizeof($temp_set)) 
            : $result_set;
    }

    public function delete() {
        $this->get_ci()->adodb->StartTrans();
        $sql = "DELETE FROM ".$this->_table
             . " WHERE id=?";
        $this->get_ci()->adodb->Execute($sql, array($this->id));
        $committed = $this->get_ci()->adodb->CompleteTrans();
        return $committed;
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
