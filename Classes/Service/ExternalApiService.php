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
 * This class simulates an external API call to validate addressdata
 *
 * @package validation_examples
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_ValidationExamples_Service_ExternalApiService implements t3lib_Singleton {

	/**
	 * Simulates validation if addressdata. If validation erros found, an array of fields and
	 * error messages are returned.
	 *
	 * @param Tx_ValidationExamples_Domain_Model_Addressdata $addressdata
	 * @return array
	 */
	public function validateAddressData(Tx_ValidationExamples_Domain_Model_Addressdata $addressdata) {
		$errors = array();
		if ($addressdata->getZip() == 20095 && $addressdata->getCity() != 'Hamburg') {
			$errors['zip'] = 'ZIP Code and city do not match';
			$errors['city'] = 'ZIP Code and city do not match';
		}
		return $errors;
	}

}
?>