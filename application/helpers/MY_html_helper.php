<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Script
*
* Generates a script inclusion of a JavaScript file
* Based on the CodeIgniters original Link Tag.
*
* Author(s): Isern Palaus <ipalaus@ipalaus.es>, Viktor Rutberg <wishie@gmail.com>
*
* @access    public
* @param    mixed    javascript sources or an array
* @param    string    language
* @param    string    type
* @param    boolean    should index_page be added to the javascript path
* @return    string
*/    

if ( ! function_exists('script_tag'))
{
    function script_tag($src = '', $language = 'javascript', $type = 'text/javascript', $index_page = FALSE)
    {
        $CI =& get_instance();

        $script = '<script ';
        
        if(is_array($src))
        {
            foreach($src as $v)
            {
                if ($k == 'src' AND strpos($v, '://') === FALSE)
                {
                    if ($index_page === TRUE)
                    {
                        $script .= ' src="'.$CI->config->site_url($v).'"';
                    }
                    else
                    {
                        $script .= ' src="'.$CI->config->slash_item('base_url').$v.'"';
                    }
                }
                else
                {
                    $script .= "$k=\"$v\"";
                }
            }
            
            $script .= ">\n";
        }
        else
        {
            if ( strpos($src, '://') !== FALSE)
            {
                $script .= ' src="'.$src.'" ';
            }
            elseif ($index_page === TRUE)
            {
                $script .= ' src="'.$CI->config->site_url($src).'" ';
            }
            else
            {
                $script .= ' src="'.$CI->config->slash_item('base_url').$src.'" ';
            }
                
            $script .= 'language="'.$language.'" type="'.$type.'"';
            
            $script .= '>'."\n";
        }

        
        $script .= '</script>';
        
        return $script;
    }
}

/**
 * We are implementing the system via 960 css framework,
 * thus this function is help to clear the grid.
 * 
 * @access public
 * @return string
 */
if ( ! function_exists('clear_div')) {
    function clear_div() {
        return "<div class='clear'>&nbsp;</div>\n";
    }
}

/**
 * Comment on html
 * 
 * @param mixed $comment 
 * @access public
 * @return string
 */
if ( ! function_exists('comment')) {
    function comment($comment) {
        return "<!-- ".$comment." -->";
    }
}

/**
 * icon_delete 
 * 
 * @access public
 * @return string
 */
if ( ! function_exists('icon_delete')) {
    function icon_delete() {
        $icon = array(
            'src' => base_url()."images/icons/delete.png",
            'alt' => lang('delete'),
            'title' => lang('delete'),
        );
        return img($icon);
    }
}

/**
 * Label the text (formatting the lable) 
 * 
 * @param string $text 
 * @param array $attr 
 * @access public
 * @return string
 */
if ( ! function_exists('label')) {
    function label($text, $attr = array()) {
        $attributes[] = 'class="label '.element('class', $attr, '').'"';
        if(array_key_exists('class', $attr)) unset($attr['class']);
        foreach($attr as $key => $val) {
            $attributes[] = $key.'="'.$val.'"';
        }
        $label = '<span '.implode(' ', $attributes).'>'
               . $text
               . '</span>';
        return $label;
    }
}

/**
 * Share the page to social network
 * Reference: http://www.addthis.com/ 
 * 
 * @access public
 * @return string
 */
if ( ! function_exists('sharable')) {
    function sharable() {
        $text = "<!-- AddThis Button BEGIN -->"
            . "\n<div class='addthis_toolbox addthis_default_style '>"
            . "\n<a class='addthis_button_preferred_1'></a>"
            . "\n<a class='addthis_button_preferred_2'></a>"
            . "\n<a class='addthis_button_preferred_3'></a>"
            . "\n<a class='addthis_button_preferred_4'></a>"
            . "\n<a class='addthis_button_compact'></a>"
            . "\n<a class='addthis_counter addthis_bubble_style'></a>"
            . "\n</div>"
            . "\n<script type='text/javascript' src='http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f0d3ef949edb751'></script>"
            . "\n<!-- AddThis Button END -->";
        return $text;
    }
}

/**
 * button_link 
 * 
 * @param mixed $link 
 * @param mixed $text 
 * @param array $attr 
 * @access public
 * @return string
 */
if ( ! function_exists('button_link')) {
    function button_link($link, $text, $attr = array()) {
        $attributes[] = 'class="button '.element('class', $attr, '').'"';
        if(array_key_exists('class', $attr)) unset($attr['class']);
        foreach($attr as $key => $val) {
            $attributes[] = $key.'="'.$val.'"';
        }
        $button = anchor(
            $link,
            '<span>'.$text.'</span>',
            implode(' ', $attributes)
        );
        return $button;
    }
}

