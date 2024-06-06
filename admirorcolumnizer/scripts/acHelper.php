<?php

/* ------------------------------------------------------------------------
  # plg_Admirorcolumnizer - Admiror Columnizer Plugin
  # ------------------------------------------------------------------------
  # author    Vasiljevski & Kekeljevic
  # copyright Copyright (C) 2011 admiror-design-studio.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.admiror-design-studio.com/joomla-extensions
  # Technical Support:  Forum - http://www.vasiljevski.com/forum/index.php
  # Version: 5.0.0
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
        $tag = rtrim($tag, '}');
        $re = sprintf('/%s=([\'"])?((?(1).*?|[^\s>]+))(?(1)\1)/is', preg_quote($attrib, '/'));
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
        // Get and set parameters with default values
        $this->params['textAlign'] = $this->acGetAttribute("textAlign", $matchValue, $this->params['textAlign']);
        $this->params['vertAlign'] = $this->acGetAttribute("vertAlign", $matchValue, $this->params['vertAlign']);
        $this->params['spacing'] = $this->acGetAttribute("spacing", $matchValue, $this->params['spacing']);
        $this->params['hyphenator'] = $this->acGetAttribute("hyphenator", $matchValue, $this->params['hyphenator']);
        $this->params['brake_code'] = $this->acGetAttribute("brake_code", $matchValue, $this->params['brake_code']);

        // Split string at separators
        $columnsArray = explode($this->params['brake_code'], $source_html);
        $numColumns = count($columnsArray);
        $columnWidth = floor(100 / $numColumns) . '%';
        $spacingDiv = '<td style="border-style: none;"><div style="display:block; width:' . htmlspecialchars($this->params['spacing'], ENT_QUOTES, 'UTF-8') . 'px">&nbsp;</div></td>';

        $html = '<table width="100%" class="AC_table"><tbody><tr style="border-style: none;">';
        foreach ($columnsArray as $key => $value) {
            // Add content
            $html .= '<td width="' . htmlspecialchars($columnWidth, ENT_QUOTES, 'UTF-8') . '" style="border-style: none; text-align:' . htmlspecialchars($this->params['textAlign'], ENT_QUOTES, 'UTF-8') . '; vertical-align:' . htmlspecialchars($this->params['vertAlign'], ENT_QUOTES, 'UTF-8') . '" class="hyphenate">' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</td>';

            // Add spacing if not the last column
            if ($key < $numColumns - 1) {
                $html .= $spacingDiv;
            }
        }
        $html .= '</tr></tbody></table>' . "\n";
        $html .= '<br style="clear:both;" />';

        return $html;
    }
}
