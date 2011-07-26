<?php

########################################################################
# Extension Manager/Repository config file for ext: "picasa"
#
# Auto generated 16-02-2010 17:04
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Picasa',
	'description' => 'Display one or more Picasa albums on your website.',
	'category' => 'plugin',
	'author' => 'Romain Ruetschi',
	'author_company' => 'kryzalid',
	'author_email' => 'romain@kryzalid.com',
	'shy' => '',
	'dependencies' => 'api_macmade',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '',
	'createDirs' => 'typo3temp/tx_picasa/',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
		    'api_macmade' => '0.4.7-',
			'php' => '5.2.0-',
			'typo3' => '4.3.0-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => ''
);

?>