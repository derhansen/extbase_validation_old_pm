<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'Addressdata' => 'new, create',
		
	),
	// non-cacheable actions
	array(
		'Addressdata' => 'new, create',
		
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi2',
	array(
		'Addressdata' => 'new, create',
		
	),
	// non-cacheable actions
	array(
		'Addressdata' => 'create',
		
	)
);

?>