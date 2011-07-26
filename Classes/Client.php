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
 * Source file containing class tx_picasa_Client.
 * 
 * @package    Picasa
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @see        tx_picasa_Client
 */

/**
 * Class tx_picasa_Client.
 * 
 * @todo       Description for class tx_picasa_Client.
 *
 * @package    Picasa
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 */
class tx_picasa_Client
{
    
    /**
     * GData
     *
     * @var Zend_Gdata_Photos
     */
    protected $gData = NULL;
    
    public function __construct( $user, $pass = '' )
    {
        set_include_path( t3lib_extMgm::extPath( 'picasa' ) . 'vendor:' . get_include_path() );
        
        require_once 'Zend/Loader.php';
        Zend_Loader::loadClass( 'Zend_Gdata_Photos' );
        Zend_Loader::loadClass( 'Zend_Gdata_ClientLogin' );
        Zend_Loader::loadClass( 'Zend_Gdata_AuthSub' );
        
        $client = NULL;
        
        if( $pass )
        {
            $serviceName = Zend_Gdata_Photos::AUTH_SERVICE_NAME;
            $user        = $user;
            $pass        = $pass;
            
            $client      = Zend_Gdata_ClientLogin::getHttpClient( $user, $pass, $serviceName );
        }
        
        $this->gData = new Zend_Gdata_Photos( $client, 'Kryzalid-TxPicasa-1.0' );
    }
    
    public function getAlbums()
    {
        return $this->gData->getUserFeed( 'default' );
    }
    
    public function getAlbumByName( $albumName )
    {
        $albums = $this->getAlbums();
        
        foreach( $albums as $album )
        {
            if( $album->getGphotoName()->getText() !== $albumName )
            {
                return $album;
            }
        }
        
        return NULL;
    }
    
    public function getAlbumPhotos( $albumName )
    {
        $album = $this->getAlbumByName( $albumName );
        
        $query = $this->gData->newAlbumQuery();
        $query->setUser( 'default' );
        $query->setAlbumId( $album->getGphotoId() );
        
        return $this->gData->getAlbumFeed( $query );
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/picasa/Classes/Client.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/picasa/Classes/Client.php']);
}
