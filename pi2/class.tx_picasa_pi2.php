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
 * Source file containing class tx_picasa_pi2.
 * 
 * @package    MyNA
 * @subpackage tx_picasa_pi2
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Jean-David Gadina <info@eosgarden.com>
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        tx_picasa_pi2
 */

// tslib_pibase
require_once( PATH_tslib . 'class.tslib_pibase.php' );

// Macmade developer API.
require_once( t3lib_extMgm::extPath( 'api_macmade' ) . 'class.tx_apimacmade.php' );

/**
 * Class tx_picasa_pi2.
 * 
 * Description for class tx_picasa_pi2.
 * Adapted from class tx_dropdownsitemap_pi2 from extension "dropdow_sitemap" by
 * Jean-David Gadina <info@eosgarden.com>.
 *
 * @package    MyNA
 * @subpackage tx_picasa_pi2
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Jean-David Gadina <info@eosgarden.com>
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class tx_picasa_pi2 extends tslib_pibase
{
    
    /**
     * Extension key.
     *
     * @var string
     */
    public $extKey             = 'picasa';
    
    /**
     * Same as class name.
     *
     * @var string
     */
    public $prefixId           = __CLASS__;
    
    /**
     * Relative path to this script-
     *
     * @var string
     */
    public $scriptRelPath      = 'pi2/class.tx_picasa_pi2.php';
    
    /**
     * Configuration
     *
     * @var array
     */
    protected $_conf           = array();
    
    /**
     * Flexform
     *
     * @var array
     */
    protected $_piFlexForm     = array();
    
    /**
     * Macmade developer API.
     *
     * @var tx_apimacmade
     */
    protected $_api            = NULL;
    
    /**
     * Minimum version of the Macmade API.
     *
     * @var string
     */
    public $apimacmade_version = 4.7;
    
    /**
     * Whether the plugin should check the cHash or not.
     *
     * @var boolean
     */
    public $pi_checkCHash     = FALSE;
    
    /**
     * View
     *
     * @var Tx_Fluid_View_StandaloneView
     */
    protected $_view = NULL;
    
    /**
     * Picasa Client
     *
     * @var Tx_Picasa_Client
     */
    protected $_client = NULL;
    
    /**
     * Templates path
     *
     * @var string
     */
    protected $_templatesPath = '';
    
    /**
     * Main function of the plugin.
     *
     * @param string $content Content.
     * @param array $conf The configuration array.
     * @return string The rendered content.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function main( $content, array $conf )
    {
        // Initialize the plugin.
        $this->_initialize( $content, $conf );
        
        $this->extPath = t3lib_extMgm::extRelPath( $this->extKey );
        $this->extPath = str_replace( '../', '/', $this->extPath );
        
        $this->_client = t3lib_div::makeInstance(
            'Tx_Picasa_Client',
            $this->_conf[ 'user' ],
            $this->_conf[ 'pass' ]
        );
        
        $this->_templatesPath = t3lib_extMgm::extPath( $this->extKey ) . 'res/templates/pi2/';
        
        $this->_view = t3lib_div::makeInstance( 'Tx_Fluid_View_StandaloneView' );
        $this->_view->assign( 'conf', $this->_conf );
        
        switch( TRUE )
        {
            case !empty( $_POST ):
                $this->handleUpload( $this->piVars[ 'album' ] );
            break;
            
            case !empty( $this->piVars[ 'album' ] ):
                $this->showUploadFormAction( $this->piVars[ 'album' ] );
            break;
            
            default:
                $this->showAlbumsListAction();
        }
        
        $content = $this->_view->render();
        
        return $this->_baseWrap( $content );
    }
    
    protected function showAlbumsListAction()
    {
        $albums = $this->_client->getAlbums();
        
        $this->_view->setTemplatePathAndFilename( $this->_templatesPath . 'albums.html' );
        $this->_view->assign( 'albums', $albums );
    }
    
    protected function showUploadFormAction( $albumName )
    {
        $jsPath = $this->extPath . 'res/js/';
        
        $headerData = '<link rel="stylesheet" href="' . $jsPath . 'plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" charset="utf-8" />' . "\n";
        
        if( $this->_conf[ 'jQuery' ] )
        {
            $headerData .= '<script src="' . $jsPath . 'jquery-1.6.1.min.js" type="text/javascript"></script>' . "\n";
        }
        
        $headerData .= '<script type="text/javascript" src="' . $jsPath . 'plupload/plupload.full.js"></script>' . "\n"
                    .  '<script type="text/javascript" src="' . $jsPath . 'plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>';
        
        $this->_view->setTemplatePathAndFilename( $this->_templatesPath . 'upload.html' );
        $this->_view->assign( 'album', $this->_client->getAlbumByName( $album ) );
        $this->_view->assign( 'jsPath', $jsPath );
        $this->_view->assign( 'uploadUrl', $this->extPath . 'scripts/upload.php' );
        $this->_view->assign( 'url', $this->pi_linkTP_keepPIvars_url( array(
            'album'  => $albumName,
            'upload' => '1'
        ) ) );
        
        $GLOBALS[ 'TSFE' ]->additionalHeaderData[ $this->extKey ] = $headerData;
    }
    
    protected function handleUpload( $albumName )
    {
        $count    = ( int )$_POST[ 'tx-picasa-pi2-uploader_count' ];
        $pictures = array();
        
        for( $i = 0; $i < $count; $i++ )
        {
            $prefix = 'tx-picasa-pi2-uploader_' . $i . '_';
            
            if( $_POST[ $prefix . 'status' ] === 'done' )
            {
                $pictures[] = $picture = 'typo3temp/tx_picasa/tmp/' . $_POST[ $prefix . 'tmpname' ];
                
                $this->_client->postPhotoToAlbum(
                    $_POST[ $prefix . 'name' ],
                    t3lib_div::getFileAbsFileName( $picture ),
                    $albumName
                );
            }
        }
        
        $this->showUploadedPictures( $albumName, $pictures );
    }
    
    protected function showUploadedPictures( $albumName, array $pictures )
    {
        $this->_view->setTemplatePathAndFilename( $this->_templatesPath . 'uploaded.html' );
        $this->_view->assign( 'album', $this->_client->getAlbumByName( $album ) );
        $this->_view->assign( 'pictures', $pictures );
    }
    
    /**
     * Initialize the plugin
     *
     * @param string &$content The plugin's content.
     * @param string &$conf The plugin's configuration.
     * @return void
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function _initialize( &$content, array &$conf )
    {
        // Instanciate the macmade API.
        $this->_api = new tx_apimacmade( $this );
        
        // Set this plugin as USER_INT.
        $this->pi_USER_INT_obj = TRUE;
        
        // Hold the configuration.
        $this->_conf =& $conf;
        
        // Check if the given type is valid.
        if( empty( $this->_conf ) )
        {
            // Print an error message.
            return $this->_api->fe_makeStyledContent(
                'strong',
                'error',
                $this->pi_getLL( 'static.noIncluded' )
            );
        }
        
        // Load localizations.
        $this->pi_loadLL();
        
        // Init the plugin flex form.
        $this->pi_initPIflexForm();
        
        // Get the flex form data.
        $this->_piFlexForm = $this->cObj->data[ 'pi_flexform' ];
        
        // Merge the configuration.
        $this->_setConfig();
        
        // Register a new autoload function.
        spl_autoload_register( array( $this, 'loadClass' ) );
    }
    
    /**
     * Set the configuration.
     *
     * Merge the TS configuration array and the flexform data.
     * 
     * @return void
     */
    protected function _setConfig()
    {
        // Mapping array.
        $flex2conf = array(
            'user'     => 'sDEF:user',
            'pass'     => 'sDEF:pass',
            'listPage' => 'sDEF:listPage'
        );
        
        // Merge them.
        $this->_conf = $this->_api->fe_mergeTSconfFlex(
            $flex2conf,
            $this->_conf,
            $this->_piFlexForm
        );
    }
    
    /**
     * Wrap the plugin's output.
     *
     * @param string $content The content to wrap.
     * @return string The wrapped content.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function _baseWrap( $content )
    {
        if( is_array( $content ) )
        {
            $content = implode( "\n", $content );
        }
        
        return $this->pi_wrapInBaseClass( $content );
    }
    
    /**
     * Automagically load a class from his name.
     *
     * @param string $className The name of the class to load.
     * @return boolean Wheter the load successed or not.
     */
    public function loadClass( $className )
    {
        // The directory where the classes as stored.
        static $classesDirectory = '';
        
        // If the supplied class name does not begin with "Tx_Picasa_".
        if( strpos( $className, 'Tx_Picasa_' ) !== 0 )
        {
            // Return false (loading failed).
            return false;
        }
        
        // If $classesDirectory has not already been initialized.
        if( !$classesDirectory )
        {
            // Initialize it to EXT:picasa/classes/.
            $classesDirectory = t3lib_extMgm::extPath( $this->extKey )
                              . 'Classes' . DIRECTORY_SEPARATOR;
        }
        
        $fileName = str_replace( '_', DIRECTORY_SEPARATOR, substr( $className, strlen( 'Tx_Picasa_' ) ) );
        
        // Build the file path.
        $filePath = $classesDirectory . $fileName . '.php';
        
        // If the file does not exist.
        if( !file_exists( $filePath ) ) {
            
            // Return false (loading failed).
            return false;
        }
        
        // Load it.
        require_once( $filePath );
        
        // Return true (loading successed).
        return true;
    }
    
}

// I apologize for all this crappy code…

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/picasa/pi2/class.tx_picasa_pi2.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/picasa/pi2/class.tx_picasa_pi2.php']);
}
