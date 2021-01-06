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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Script file of Admiror Gallery component
 */
class plgcontentadmirorcolumnizerInstallerScript
{
    /**
     * Install the component
     *
     * @param $parent
     *
     * @return void
     */
    function install($parent)
    {

    }

    /**
     * Uninstall the component
     *
     * @param $parent
     *
     * @return void
     */
    function uninstall($parent)
    {

    }

    /**
     * Update the component
     *
     * @param $parent
     *
     * @return void
     */
    function update($parent)
    {
        //On update we just call install, no special case for updating.
        $this->install($parent);
    }

    /**
     * Run before an install/update/uninstall method
     *
     * @param $type
     * @param $parent
     *
     * @return void
     */
    function preflight($type, $parent)
    {

    }

    /**
     * Run after an install/update/uninstall method
     *
     * @param $type
     * @param $parent
     *
     * @return void
     */
    function postflight($type, $parent)
    {
        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
        if (!JFile::Move($parent->getParent()->getPath('extension_root') . DIRECTORY_SEPARATOR . "_admirorcolumnizer.xml", $parent->getParent()->getPath('extension_root') . DIRECTORY_SEPARATOR . "admirorcolumnizer.xml")) {
            JFactory::$application->enqueueMessage('Manifest file could not be renamed. Please go to plugins/content/admirorcolumnizer and rename _admirorcolumnizer.xml to admirorcolumnizer.xml');
        }
    }

}