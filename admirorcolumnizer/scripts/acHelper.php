<?php

/* ------------------------------------------------------------------------
  # plg_Admirorcolumnizer - Admiror Columnizer Plugin
  # ------------------------------------------------------------------------
  # author    Vasiljevski & Kekeljevic
  # copyright Copyright (C) 2011 admiror-design-studio.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.admiror-design-studio.com/joomla-extensions
  # Technical Support:  Forum - http://www.vasiljevski.com/forum/index.php
  ------------------------------------------------------------------------- */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class acHelper
 */
class acHelper
{

    public $params = array();

    function __construct($globalParams)
    {
        // Default parameters
        $this->params['textAlign'] = $globalParams->get('ac_textAlign', 'left');
        $this->params['vertAlign'] = $globalParams->get('ac_vertAlign', 'top');
        $this->params['spacing'] = $globalParams->get('ac_spacing', 10);
        $this->params['hyphenator'] = $globalParams->get('ac_hyphenator', 1);
        $this->params['brake_code'] = $globalParams->get('ac_brake_code', "ACBR");
    }

    /**
     * Gets the attributes value by name, else returns false
     *
     * @param $attrib
     * @param $tag
     * @param $default
     *
     * @return string
     */
    private function acGetAttribute($attrib, $tag, $default)
    {
        //get attribute from html tag
        $tag = str_replace("}", "", $tag);
        $re = '/' . preg_quote($attrib) . '=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/is';
        if (preg_match($re, $tag, $match)) {
            return urldecode($match[2]);
        }
        return $default;
    }

    /**
     * Created columns HTML code
     *
     * @param $source_html
     * @param $matchValue
     * @param $id
     * @param $langDirection
     *
     * @return string
     */
    public function acCreateColumns($source_html, $matchValue, $id, $langDirection)
    {

        $this->params['textAlign'] = $this->acGetAttribute("textAlign", $matchValue, $this->params['textAlign']);
        $this->params['vertAlign'] = $this->acGetAttribute("vertAlign", $matchValue, $this->params['vertAlign']);
        $this->params['spacing'] = $this->acGetAttribute("spacing", $matchValue, $this->params['spacing']);
        $this->params['hyphenator'] = $this->acGetAttribute("hyphenator", $matchValue, $this->params['hyphenator']);
        $this->params['brake_code'] = $this->acGetAttribute("brake_code", $matchValue, $this->params['brake_code']);
        $html = "";

        // Split string at separators
        $columnsArray = explode($this->params['brake_code'], $source_html);
        $html .= '<table width="100%" class="AC_table"><tbody><tr style="border-style: none;">';
        foreach ($columnsArray as $key => $value) {
            // Add content		
            $html .= '<td width="' . floor(100 / count($columnsArray)) . '%" style="border-style: none; text-align:' . $this->params['textAlign'] . '; vertical-align:' . $this->params['vertAlign'] . '" class="hyphenate">' . $value . '</td>';

            if (count($columnsArray) - 1 != $key) {// Check is last
                $html .= '<td style="border-style: none;"><div style="display:block; width:' . $this->params['spacing'] . 'px">&nbsp;</div></td>';
            }
        }
        $html .= '</tr></tbody></table>' . "\n";
        $html .= '<br style="clear:both;" />';

        return $html;
    }

}

