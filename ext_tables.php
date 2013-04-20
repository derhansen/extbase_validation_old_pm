<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Single Form'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi2',
	'Multiple steps form'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Validation Examples');

t3lib_extMgm::addLLrefForTCAdescr('tx_validationexamples_domain_model_addressdata', 'EXT:validation_examples/Resources/Private/Language/locallang_csh_tx_validationexamples_domain_model_addressdata.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_validationexamples_domain_model_addressdata');
$TCA['tx_validationexamples_domain_model_addressdata'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:validation_examples/Resources/Private/Language/locallang_db.xml:tx_validationexamples_domain_model_addressdata',
		'label' => 'firstname',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'firstname,lastname,street,streetnr,zip,city,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Addressdata.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_validationexamples_domain_model_addressdata.gif'
	),
);

?>