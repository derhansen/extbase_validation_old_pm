<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Torben Hansen <derhansen@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Addressdata validator
 *
 * @package validation_examples
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_ValidationExamples_Validation_Validator_AddressdataValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

	/**
	 * API Service
	 *
	 * @var Tx_ValidationExamples_Service_ExternalApiService
	 */
	protected $apiService;

	/**
	 * Injects the API Service
	 *
	 * @param Tx_ValidationExamples_Service_ExternalApiService $apiService
	 * @return void
	 */
	public function injectApiService(Tx_ValidationExamples_Service_ExternalApiService $apiService) {
		$this->apiService = $apiService;
	}

	/**
	 * Validates the given value
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isValid($value) {
		$apiValidationResult = $this->apiService->validateAddressData($value);
		$success = TRUE;
		if ($apiValidationResult['zip']) {
			$error = t3lib_div::makeInstance('Tx_Extbase_Validation_Error', $apiValidationResult['zip'], time());
			$this->errors['zip'] = t3lib_div::makeInstance('Tx_Extbase_Validation_PropertyError', 'zip');
			$this->errors['zip']->addErrors(array($error));
			$success = FALSE;
		}
		if ($apiValidationResult['city']) {
			$error = t3lib_div::makeInstance('Tx_Extbase_Validation_Error', $apiValidationResult['city'], time());
			$this->errors['city'] = t3lib_div::makeInstance('Tx_Extbase_Validation_PropertyError', 'city');
			$this->errors['city']->addErrors(array($error));
			$success = FALSE;
		}
		return $success;
	}
}
?>

