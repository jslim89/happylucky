<?php
/**
 * To enable back the auto-pluralize table name
 * Go to application/third_party/adodb5/adodb-active-record.inc.php
 * static $_changeNames = false; // dynamically pluralize table names
 * set to true
 */

// Use default values of table definition when creating new active record
$ADODB_ACTIVE_DEFVALS = true;

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
    public function __construct($table = false, $pk = false, $db = false) {
        parent::__construct($table, $pk, $db);
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
        $ci =& get_instance();
        $columns = $ci->adodb->MetaColumns($this->_table, $noncasesensitive);
        $result = array();
        foreach($columns as $col) {
            $result[] = $col->name;
        }
        return $result;
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
}
