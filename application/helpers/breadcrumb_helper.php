<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Breadcrumb helper
 *
 * Features:
 * - Easy integration. Just put <?php echo set_breadcrumb(); ?> in view files.
 * - Can use any delimiter.
 * - Easy to replace any unproper link name.
 * - Easy to hide any link by it's name or number segment.
 * - Return the breadcrumb in a list (<ul><li></li></ul>) or something else.
 * - Auto link beauty.
 * - Can unlink last segment of breadcrumb.
 * - Multilanguage support.
 * - Many more...
 *
 * Installation:
 * 1. Put breadcrumb_helper.php to application/helpers.
 * 2. Put breadcrumb.php to application/config.
 * 3. Load the helper either in your controller or in autoload config.
 *     In your controller   : $this->load->helper('breadcrumb') OR
 *     In autoload  : $autoload['helper'] = array('breadcrumb')
 * 4. Add these line to your view file: <?php echo set_breadcrumb(); ?>. I suggest that you put it on master template
 *     so that it can save time as you don't need to add text in every view page.
 * 5. Change the configuration as you need.
 *
 * @package		Breadcrumb
 * @subpackage	Helpers
 * @category	Helpers
 * @author          Ardinoto Wahono
 * @version         6.11.2 (CI 2.x & CI 1.x, published on June,10 2011, release 1)
 * @copyright        Copyright (c) 2009-2011 Ardinoto Wahono, WAH-IT Web Division
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Patch for PHP 5 - 5.2
 * @author	Kromack
 * @link	http://codeigniter.com/forums/viewreply/694827/
 */
if (!function_exists('array_replace'))
{
    function array_replace(array &$array, array &$array1)
    {
        foreach($array as $k=>$v)
        {
            if(array_key_exists($k, $array1))
            {
                $array[$k] = $array1[$k];
            }
        }
        return $array;
    }
}

if ( ! function_exists('set_breadcrumb'))
{
    function set_breadcrumb($delimiter_config = '', $exclude = '')
    {
        $CI =& get_instance();
        $CI->load->helper('url');
        $CI->lang->load('breadcrumb');
        $CI->config->load('breadcrumb');

        // Load configuration
        $ci_version = $CI->config->item('codeigniter_version');
        $attr_home = $CI->config->item('attr_home');
        $unlink_home = $CI->config->item('unlink_home');

        if (empty($exclude))
        {
            $exclude = $CI->config->item('exclude');
        }
        $exclude_segment = $CI->config->item('exclude_segment');
        $replacer_default = $CI->config->item('replacer');
        $partial_replace = $CI->config->item('partial_replace');

        $uri = rtrim($CI->uri->uri_string(),'/');
        $uri_array_original = explode("/", $uri);
		
        // cahva's fix (http://codeigniter.com/forums/viewreply/855097/)
        $uri_array_cnt = count($uri_array_original);
        if (config_item('hide_number_on_last_segment') && isset($uri_array_original[$uri_array_cnt-1]) && is_numeric($uri_array_original[$uri_array_cnt-1]))
        {
        	array_pop($uri_array_original);
        }
        // <-- End cahva's fix (http://codeigniter.com/forums/viewreply/855097/)
        
        // If last segment is a number ?
        $show_last_number = -1;
        $number_array = count($uri_array_original);
        if (! $CI->config->item('hide_number_on_last_segment'))
        {
        	$l_array = $number_array - 1; // last array number
        	if (preg_match("/^[0-9]/", $uri_array_original[$l_array]) AND ! preg_match("/[a-zA-Z]+/", $uri_array_original[$l_array]))
        	{
        		$show_last_number = $l_array;
        	}
        }

        // Find segments uri that only contain a number
        if ($CI->config->item('hide_number'))
        {
            foreach($uri_array_original as $key => $value)
            {
                // exclude number but keep number where positioned in the last segment
                if (preg_match("/^[0-9]/", $value) AND ! preg_match("/[a-zA-Z]+/", $value) AND $key != $show_last_number)
                {
                    $exclude_segment = array_merge($exclude_segment, array($key));
                }
            }
        }

        // Preparing the replacer, add exclude to replacer array
        foreach ($exclude as $value)
        {
            $prep_exclude[$value] = ''; //if exclude then it's value is set to null
        }

        $replacer = $replacer_default + $prep_exclude;

        // Find uri segment from $replacer and $exclude_segment
        $replacer_null = array();
        foreach ($replacer as $key => $value)
        {
            if (empty($value))
            {    
                //$replacer_null[] = array_search($key, $uri_array_original, TRUE);
                $replacer_null[] = array_search($key, $uri_array_original);
            }
        }
        $skip_key = array_merge($replacer_null, $exclude_segment);

        $uri_array = $uri_array_original;

        // Change link name as mentioned on $replacer
        foreach ($replacer as $key => $value)
        {
            if ($value && in_array($key, $uri_array_original, TRUE))
            {
                $key_uri = array_search($key, $uri_array_original, TRUE);
				
                // Add multilanguage
                if (! is_array($value) && $CI->config->item('multilang'))
                {
					if ($CI->lang->line($value)) {
                		$value = ucwords($CI->lang->line($value));
                	}
                }
                
                $replacement = array($key_uri => $value);

				$uri_array = array_replace($uri_array, $replacement);
            }
        }

        // Set wrapper
        $wrapper = explode("|", $CI->config->item('wrapper'));
        $wrapper_inline = explode("|", $CI->config->item('wrapper_inline'));
        if ( ! $CI->config->item('use_wrapper'))
        {
             $wrapper = array('', '');
             $wrapper_inline = array('', '');
        }

        // Begin writing breadcrumb string
        $init_link = $CI->config->item('set_home');
        if ($init_link != "") 
        {
        	if ($CI->config->item('multilang'))
        	{
        		$init_link = $CI->lang->line('set_home');
        	}
        	$str_first = $wrapper[0].$wrapper_inline[0].anchor('', $init_link, $attr_home).$wrapper_inline[1];
			if ($unlink_home) 
			{
				$str_first = $wrapper[0].$wrapper_inline[0].$init_link.$wrapper_inline[1];;
			}
        	
        } else {
        	$str_first = $wrapper[0];
        }
        
        $segment = '';
        
        $i = 0;
		
        foreach ($uri_array as $value)
        {
        	if ($i > 0 OR $ci_version == '2.x') 
        	{
                $segment .= $uri_array_original[$i].'/';

                // If replace value is an array
                if (! in_array($i, $skip_key, TRUE) && is_array($value)) // Skip link if replace value is null
                {
                    $number_added_value_array = count($value);

                    foreach ($value as $pair_values)
                    {
                        $pv_array = explode("|", $pair_values);
                        $val_url = $pv_array[0];
                        $number_pv_array = count($pv_array);
                        if ($number_pv_array == 1)
                        {
                            $val_name = $pv_array[0];
                        }
                        else
                        {
                            $val_name = $pv_array[1];
                        }
                        
                        // Look up for partial replace
                        if (! empty($partial_replace))
                        {
                        	foreach ($partial_replace as $pkey => $pvalue)
                        	{
                        		$preplace = ' '.$pvalue.'_';
                        		if (substr_count($val_name, $pkey) > 0)
                        		{
                        			$val_name = str_replace($pkey, $preplace, $val_name);
                        		}
                        	}
                        }
                        
                        // Add multilanguage
                        if ($CI->config->item('multilang'))
                        {
							if ($CI->lang->line($val_name)) {
                        		$val_name = ucwords($CI->lang->line($val_name));
                        	}
                        }
                        
                        // Url preparation
                        // If no url define (array key is empty)
                        if ($number_pv_array == 1 || $val_url == $uri_array_original[$i])
                        {
                            $new_segment_url = $segment;
                        }
                        else if ($val_url[0] == '/')
                        {
                            $new_segment_url = base_url().substr($val_url, 1);
                        }
                        else
                        {
                            $new_segment_url = $segment.$val_url;
                        }

						$str_link[] = $new_segment_url;
						$str_name[] = ucwords($val_name);
                    }
                }
                else if (! in_array($i, $skip_key, TRUE)) // If replace value is NOT an array
                {
                	// Look up for partial replace
                	if (! empty($partial_replace))
                	{
                		foreach ($partial_replace as $pkey => $pvalue)
                		{
                			$preplace = ' '.$pvalue.'_';
                			if (substr_count($value, $pkey) > 0)
                			{
                				$value = str_replace($pkey, $preplace, $value);
                			}
                		}
                	}
                	
                    // Auto link make over
                    if (strpos($value, "_") OR strpos($value, "-"))
                    {
                        $char_to_replace = $CI->config->item('strip_characters');
                        $value = ucwords(strtolower(str_replace($char_to_replace, " ", $value)));
                        if ($CI->config->item('strip_regexp'))
                        {
                            foreach($CI->config->item('strip_regexp') as $exp)
                            {
                                $value = preg_replace($exp, '', $value);
                            }
                        }
                    }

                    $str_link[] = $segment;
					$str_name[] = ucwords($value);
                }
            }
            $i++;
        }
        $str_last = $wrapper[1];
        
        $str = $str_first;
        
        if (isset($str_name)) {
        	$breadcrumb_number = count($str_name);

        	if ($breadcrumb_number > 0) {
        		
				$i = 0;
				
        		foreach ($str_name as $key => $val) {
        			// If home is hidden then don't show first delimiter
        			if ( $i == 0 && ($str == '' || $str == $wrapper[0]) ) {
        				$delimiter = '';
        			} elseif (empty($delimiter_config)) {
        				$delimiter = $CI->config->item('delimiter');
        			} else {
        				$delimiter = $delimiter_config;
        			}
        			
        			if ($val != '') {
        				if ($key == $breadcrumb_number-1 && $CI->config->item('unlink_last_segment'))
        				{
        					$str .= $delimiter.$wrapper_inline[0].ucwords($val).$wrapper_inline[1];
        				} else {
        					$str .= $delimiter.$wrapper_inline[0].anchor($str_link[$key], $val).$wrapper_inline[1];
        				}
        			}
        			
        			$i++;
        		}
        	}
        }

        $str .= $str_last;
        clear_breadcrumb();
        return $str;
    }  
}

if ( ! function_exists('clear_breadcrumb'))
{
    function clear_breadcrumb()
    {
    	unset($wrapper_inline);
    	unset($wrapper);
    }
}
/* End of file breadcrumb_helper.php */
/* Location: ./application/helpers/breadcrumb_helper.php */