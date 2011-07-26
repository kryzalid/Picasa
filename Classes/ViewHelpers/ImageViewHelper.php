<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2011 Romain Ruetschi (romain@kryzalid.com)
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
 * Source file containing class Tx_Picasa_ViewHelpers_ImageViewHelper.
 * 
 * @package    picasa
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @see        Tx_Picasa_ViewHelpers_ImageViewHelper
 */

/**
 * Class Tx_Picasa_ViewHelpers_ImageViewHelper.
 * 
 * @todo       Description for class Tx_Picasa_ViewHelpers_ImageViewHelper.
 *
 * @package    picasa
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 */
class Tx_Picasa_ViewHelpers_ImageViewHelper extends Tx_Fluid_ViewHelpers_ImageViewHelper
{
    
    /**
     * Image cache path
     *
     * @var string
     */
    protected $cachePath = 'typo3temp/tx_picasa/';
    
    /**
     * Resizes a given image (if required) and renders the respective img tag
     * @see http://typo3.org/documentation/document-library/references/doc_core_tsref/4.2.0/view/1/5/#id4164427
     *
     * @param string $src
     * @param string $width width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param string $height height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param integer $minWidth minimum width of the image
     * @param integer $minHeight minimum height of the image
     * @param integer $maxWidth maximum width of the image
     * @param integer $maxHeight maximum height of the image
     *
     * @return string rendered tag.
     * @author Sebastian Böttger <sboettger@cross-content.com>
     * @author Bastian Waidelich <bastian@typo3.org>
     */
    public function render( $src, $width = NULL, $height = NULL, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL )
    {
        if( strpos( $src, 'http' ) !== 0 )
        {
            return parent::render( $src, $width, $height, $minWidth, $minHeight, $maxWidth, $maxHeight );
        }
        
        $hash            = md5( $src );
        $cachedImage     = $this->cachePath . $hash . '.' . pathinfo( $src, PATHINFO_EXTENSION );
        
        if( !file_exists( PATH_site . $cachedImage ) )
        {
            $this->fetchAndCacheImage( $src, PATH_site . $cachedImage );
        }
        
        return parent::render( $cachedImage, $width, $height, $minWidth, $minHeight, $maxWidth, $maxHeight );
    }
    
    protected function fetchAndCacheImage( $src, $path )
    {
        // t3lib_div::debug( 'Downloading: ' . $src . ', to: ' . $path );
        
        file_put_contents( $path, t3lib_div::getURL( $src ) );
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/picasa/Classes/ViewHelpers/ImageViewHelper.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/picasa/Classes/ViewHelpers/ImageViewHelper.php']);
}
