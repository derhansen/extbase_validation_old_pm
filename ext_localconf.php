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
		'MultipleSteps' => 'step1, step2, step3, step1redirect, step2redirect, step3redirect, create',
	),
	// non-cacheable actions
	array(
		'MultipleSteps' => 'step1, step2, step3, step1redirect, step2redirect, step3redirect, create',
	)
);

?>