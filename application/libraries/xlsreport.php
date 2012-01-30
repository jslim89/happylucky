<?php 

/** PHPExcel */
include 'phpexcel_1.7.6/Classes/PHPExcel.php';

/** PHPExcel_IOFactory */
include 'phpexcel_1.7.6/Classes/PHPExcel/IOFactory.php';
/**
 * This is based on PHPExcel library to simplify the basic function used.
 * This is not a report template, so the template you have to create yourself.
 * 
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license 
 */
class XLSReport {
    private $_title;
    private $_creator;
    private $_file_name;
    private $_columns_count;
    private $_auto_fit_width;

    /**
     * __construct 
     * 
     * @param mixed $title 
     * @return void
     */
    public function __construct() {
        $this->xls = new PHPExcel();
    }

    public function init($report_model) {
        $this->report          = $report_model;
        $this->_creator        = 'Happy Lucky';
        $this->_title          = $report_model->title;
        $this->_auto_fit_width = true;
        $this->_columns_count  = sizeof($report_model->get_header_set());
    }

    /**
     * Send the file to the user to download 
     * 
     * @return void
     */
    public function send_file($force_download = false) {
        $path_filename = BASEPATH . '../data/reports/' . $this->_filename();
        
        $this->_build();
        $writer = PHPExcel_IOFactory::createWriter($this->xls, "Excel5");
        $ret    = $writer->save($path_filename);
        @ob_end_clean(); 
        if ( $force_download )
            $this->_force_download($path_filename);
    }

    /**
     * _force_download 
     * 
     * @param mixed $path 
     * @return void
     */
    private function _force_download( $path ) {
        $ci =& get_instance();
        $ci->load->helper('download');
        $data = file_get_contents($path);
        @ob_end_clean(); 
        force_download($this->_filename(), $data);
    }
	
    /**
     * merge_cell 
     * 
     * @param mixed $from_pos 
     * @param mixed $to_pos 
     * @return void
     */
	public function merge_cell( $from_pos, $to_pos ) {
        $position_range = $from_pos . ":" . $to_pos;
		$sheet = $this->xls->getActiveSheet();
		$sheet->mergeCells($position_range);
		$sheet->getStyle($position_range)->getAlignment()->setWrapText(true);
	}

    /**
     * Filename to be saved and export for download 
     * 
     * @return string
     */
    private function _filename() {
        if($this->_file_name) {
                $filename = str_replace(' ', '_', $this->_file_name);
            if($this->_get_file_name_extension($filename) != 'xls')
                $filename .= ".xls";
        }
        else {
            $tmp = strtolower($this->_title) . "_printed_on_(" . date("j-M-Y") . ")";
            $filename = str_replace(' ', '_', $tmp) . ".xls";
        }
        return $filename;
    }

    /**
     * Create the excel file 
     * 
     * @return void
     */
    private function _build() {
        $this->xls->setActiveSheetIndex(0);
        $this->_set_metadata();
        $this->_build_title();
    }

    /**
     * Build the Title of the excel worksheet
     * 
     * @return void
     */
    private function _build_title() {
		$sheet = $this->xls->getActiveSheet();
        
		$sheet->setCellValue('A1', $this->_title);

        // auto fit the column width
        if($this->_auto_fit_width) // from column 1 to last column
            $this->_set_auto_fit_width(1, $this->_columns_count);

		// merge cells
        $end_position = $this->find_position($this->_columns_count-1, 1);
		$this->merge_cell('A1', $end_position);
        $this->set_bold('A1');
        $this->set_horizontal_alignment('A1', PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->set_bg_color('A1', '#FFFF00');
    }

    /**
     * The header is in second row, and the row index is start from 1
     * Thus fix the row value 2
     * 
     * @param mixed $header_set 
     * @return void
     */
    public function build_header($header_set) {
		$sheet = $this->xls->getActiveSheet();
        $col = 0;
        foreach($header_set as $header) {
            $position = $this->find_position($col, 2);
            $this->set_horizontal_alignment($position, PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->set_bold($position);
            $this->set_text($position, $header);
            $col++;
        }
    }

    /**
     * get the starting row for data set, since first row is for title,
     * second row is for header, third row onward is for data 
     * 
     * @return int
     */
    public function get_starting_row() {
        return 3;
    }

    /**
     * set_wrap 
     * 
     * @param mixed $position 
     * @return void
     */
    public function set_wrap($position) {
        $this->xls->getActiveSheet()
            ->getStyle($position)->getAlignment()->setWrapText(true);
    }

    // /**
     // * Generate the list from the report model.
     // * 
     // * @return void
     // */
    // private function _build_list() {
		// $rs = $this->report_model['row'];
		// $sheet = $this->xls->getActiveSheet();
        // $r = 2; // row count
        // foreach ( $rs as $key => $row )
        // {
			// $c = 0; // column count
            // foreach ( $row as $value )
            // {
                // $sheet->setCellValueByColumnAndRow($c, $r, $value);
				// $sheet->getStyle($position)->getAlignment()->setWrapText(true);
				// $c++;
            // }
            // $r++;
        // }
        // 
    // }
	
    /**
     * Set the excel file document's properties 
     * 
     * @return void
     */
    private function _set_metadata() {
        $this->xls->getProperties()->setCreator($this->_creator);
        // $this->xls->getproperties()->setlastmodifiedby($last_modified_by);
        $this->xls->getProperties()->setTitle($this->_title);
        $this->xls->getProperties()->setSubject($this->_title);
        $this->xls->getProperties()->setKeywords("Report");
        $this->xls->getProperties()->setCategory("Standard Report");
    }

    /**
     * set_font_size 
     * 
     * @param mixed $position 
     * @param mixed $size 
     * @return void
     */
    public function set_font_size($position, $size) {
		$sheet = $this->xls->getActiveSheet();
		$sheet->getStyle($position)->getFont()->setSize($size);
    }
	
    /**
     * set_bold 
     * 
     * @param mixed $position 
     * @return void
     */
	public function set_bold($position) {
        $style_array = array('font' => array('bold' => true));
		$this->xls->getActiveSheet()
			->getStyle($position)->applyFromArray($style_array);
	}
	
    /**
     * set_italic 
     * 
     * @param mixed $position 
     * @return void
     */
	public function set_italic($position) {
		$style_array = array('font' => array('italic' => true));
		$this->xls->getActiveSheet()
			->getStyle($position)->applyFromArray($style_array);
	}
	
	/*
	Just for Reference
	const BORDER_NONE = 'none';
	const BORDER_DASHDOT = 'dashDot';
	const BORDER_DASHDOTDOT = 'dashDotDot';
	const BORDER_DASHED = 'dashed';
	const BORDER_DOTTED = 'dotted';
	const BORDER_DOUBLE = 'double';
	const BORDER_HAIR = 'hair';
	const BORDER_MEDIUM = 'medium';
	const BORDER_MEDIUMDASHDOT = 'mediumDashDot';
	const BORDER_MEDIUMDASHDOTDOT = 'mediumDashDotDot';
	const BORDER_MEDIUMDASHED = 'mediumDashed';
	const BORDER_SLANTDASHDOT = 'slantDashDot';
	const BORDER_THICK = 'thick';
	const BORDER_THIN = 'thin';
	*/
	public function set_border($position, $border_type) {
		$style_array = array('borders' => array('allborders' => array
					    ('style' => $border_type)));
		$this->xls->getActiveSheet()
			->getStyle($position)->applyFromArray($style_array);
	}

    /**
     * Passed in column can either integer or character
     * i.e. set_auto_fit_width(1, 5) same as set_auto_fit_width('A', 'E') 
     * 
     * @param mixed $from_col 
     * @param mixed $to_col 
     * @return void
     */
	private function _set_auto_fit_width($from_col, $to_col) {
	    if(is_int($from_col))
	        $from_col = $this->_find_column_position($from_col);
	    if(is_int($to_col))
	        $to_col = $this->_find_column_position($to_col);
	    foreach ( range($from_col, $to_col) as $col )
        {
            $this->xls->getActiveSheet()
		        ->getColumnDimension($col)->setAutoSize(true);	
        }
    }

    /**
     * set_text 
     * 
     * @param mixed $position 
     * @param mixed $text 
     * @return void
     */
    public function set_text($position, $text) {
        $this->xls->getActiveSheet()
            ->getCell($position)
            ->setValueExplicit($text, PHPExcel_Cell_DataType::TYPE_STRING);
    }

    public function set_text_by_col_row($column, $row, $value) {
        $this->xls->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $value);
    }
	
    /**
     * set_bg_color 
     * 
     * @param mixed $position 
     * @param mixed $color 
     * @return void
     */
	public function set_bg_color($position,$color) {
		$sheet = $this->xls->getActiveSheet();
		$sheet->getStyle($position)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$sheet->getStyle($position)->getFill()->getStartColor()->setRGB($color);
	}
	
    /**
     * set_font_color 
     * 
     * @param mixed $position 
     * @param mixed $color 
     * @return void
     */
	public function set_font_color($position, $color) {
		$sheet = $this->xls->getActiveSheet();
		$sheet->getStyle($position)->getFont()->getColor()
            ->setARGB($color);
	}

    /**
     * Set the alignment horizontally
     * Options:
     * PHPExcel_Style_Alignment::HORIZONTAL_CENTER
     * PHPExcel_Style_Alignment::HORIZONTAL_LEFT
     * PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
     * 
     * @param mixed $alignment 
     * @return void
     */
    public function set_horizontal_alignment($position, $alignment) {
		$sheet = $this->xls->getActiveSheet();
        $sheet->getStyle($position)->getAlignment()->setHorizontal($alignment);
    }

    /**
     * find_position 
     * 
     * Excel column start from one (1) from users' perpective,
     * so A - 1, Z - 26
     *
     * @param integer $column 
     * @param integer $row 
     * @return string
     */
    public function find_position($column, $row) {
        // _find_column_position() is start from 1, thus plus 1
        return $this->_find_column_position($column+1) . $row;
    }

    /**
     * _find_column_position 
     * 
     * @param mixed $num 
     * @return void
     */
    private function _find_column_position($num) {  
        $arr = $this->_to_base_26($num);
        $result = "";
        foreach ( $arr as $v )
        {
            $result .= chr(64 + $v);
        }
        return $result;
    }

    /**
     * to_base_26 
     * 
     * @param mixed $num 
     * @return void
     */
    private function _to_base_26($num) {
        $result_arr = array();
        while ( $num > 0 )
        {
            $result_arr[] = $num % 26;
            $num = floor($num / 26);
        }
        return array_reverse($result_arr);
    }

    /**
     * _get_file_name_extension 
     * 
     * @param mixed $filename 
     * @return void
     */
    private function _get_file_name_extension($filename) {
        $arr = explode('.', $filename);
        $arr_size = count($filename);

        return ($arr_size > 0) ? false : $arr[$arr_size-1];
    }
}
