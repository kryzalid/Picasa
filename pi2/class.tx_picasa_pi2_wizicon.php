<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2010 Romain Ruetschi (romain@kryzalid.com)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is 
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Source file containing class tx_picasa_pi2_wizicon.
 * 
 * @package    MyNA
 * @subpackage tx_picasa_pi2_wizicon
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Jean-David Gadina <info@eosgarden.com>
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        tx_picasa_pi2_wizicon
 */
 
/**
 * Class tx_picasa_pi2_wizicon.
 * 
 * Taken from the "dropdown_sitemap" extension by Jean-David Gadina <info@eosgarden.com>.
 *
 * @package    MyNA
 * @subpackage tx_picasa_pi2_wizicon
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Jean-David Gadina <info@eosgarden.com>
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class tx_picasa_pi2_wizicon
{

    // Extension key
    protected static $_extKey = 'picasa';
    
    // Plugin name
    protected static $_piName = 'picasa';
    
    // Language object
    protected static $_lang   = NULL;
    
    // Language labels
    protected static $_labels = array();
    
    /**
     * Class constructor
     * 
     * @return  NULL
     */
    public function __construct()
    {
        // Checks for the language object
        if( !is_object( self::$_lang ) ) {
            
            // Gets the language object
            self::$_lang   = $GLOBALS[ 'LANG' ];
            
            // Gets the language labels
            self::$_labels = self::$_lang->includeLLFile(
                'EXT:' . self::$_extKey . '/locallang.xml',
                FALSE
            );
        }
    }
    
    /**
     * Gets a locallang label
     * 
     * @param   string  $label  The name of the label to get
     * @return  string  The locallang label
     */
    protected function _getLabel( $label )
    {
        return self::$_lang->getLLL( $label, self::$_labels );
    }
    
    /**
     * Process the wizard items array
     *
     * @param   array   $wizardItems    The wizard items
     * @return  array   The modified array with the wizard items
     */
    public function proc( array $wizardItems )
    {
        // Wizard item
        $wizardItems[ 'plugins_' . self::$_piName . '_pi2' ] = array(
            
            // Icon
            'icon'        => t3lib_extMgm::extRelPath( self::$_extKey ) . 'pi2/ce_wiz.gif',
            
            // Title
            'title'       => $this->_getLabel( 'pi2_title' ),
            
            // Description
            'description' => $this->_getLabel( 'pi2_plus_wiz_description' ),
            
            // Parameters
            'params'      => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=' . self::$_extKey . '_pi2'
        );
        
        // Returns the wizard items
        return $wizardItems;
    }
    
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/picasa/pi2/class.tx_picasa_pi2_wizicon.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/picasa/pi2/class.tx_picasa_pi2_wizicon.php']);
}
