<?php

// Checks the TYPO3 context
if( !defined( 'TYPO3_MODE' ) ) {
    
    // TYPO3 context cannot be guessed
    die( 'Access denied.' );
}

// FE plugins
t3lib_extMgm::addPItoST43(
    $_EXTKEY,
    'pi1/class.tx_picasa_pi1.php',
    '_pi1',
    'list_type',
    FALSE
);
