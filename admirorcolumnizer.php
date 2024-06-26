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
defined('_JEXEC') or die;

use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Plugin\CMSPlugin;

class plgContentAdmirorcolumnizer extends JPlugin
{

    //Constructor
    function __construct(&$subject)
    {
        parent::__construct($subject);
        $this->params = new JRegistry($this->params);
        // load current language
        $this->loadLanguage();
    }

    //Joomla 1.5
    public function onPrepareContent($row, &$params, $limitstart = 0)
    {
        if (preg_match("#{AC[^}]*}(.*?){/AC}#s", strtoupper($row->text))) {
            $row->text = $this->textToColumns($row->text);
        }
    }

    //Joomla 1.6 and > function 
    public function onContentPrepare($context, &$row, &$params, $page = 0)
    {
        if (is_object($row)) {
            $this->onPrepareContent($row, $params, $page);
        } else {
            if (preg_match("#{AC[^}]*}(.*?){/AC}#s", strtoupper($row))) {
                $row = $this->textToColumns($row);
            }
        }
        return true;
    }

    //This does all the work :)
    private function textToColumns($text)
    {
        if (preg_match_all("#{AC[^}]*}(.*?){/AC}|{ac[^}]*}(.*?){/ac}#s", $text, $matches) > 0) {
            require_once(dirname(__FILE__) . '/admirorcolumnizer/scripts/acHelper.php');
            $AC = new acHelper($this->params);
            $doc = JFactory::getDocument();
            $html = "";
            foreach ($matches[0] as $matchKey => $matchValue) {
                $html = $AC->acCreateColumns(preg_replace("/{.+?}/", "", $matchValue), $matchValue, $matchKey . "_" . rand(0, 1000000), $doc->direction);
                $text = str_replace($matchValue, $html, $text);
            }
            if ($AC->params['hyphenator']) {
                if (Joomla\CMS\Version::MAJOR_VERSION == "1.5") {
                    $doc->addScript(JURI::root() . 'plugins/content/admirorcolumnizer/scripts/Hyphenator.js');
                } else {
                    $doc->addScript(JURI::root() . 'plugins/content/admirorcolumnizer/admirorcolumnizer/scripts/Hyphenator.js');
                }
                $text .= '
                            <!-- AdmirorColumnizer 3 -->
                            <script type="text/javascript">
                                    Hyphenator.run();
                            </script>
                            ';
            }
        }
        return $text;
    }

}

