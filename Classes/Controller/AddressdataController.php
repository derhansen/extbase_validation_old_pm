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
 * Singe form
 *
 * @package validation_examples
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_ValidationExamples_Controller_AddressdataController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * Addressdata Repository
	 *
	 * @var Tx_ValidationExamples_Domain_Repository_AddressdataRepository
	 */
	protected $addressdataRepository;

	/**
	 * Dependency injection for addressdata repository
	 *
	 * @param Tx_ValidationExamples_Domain_Repository_AddressdataRepository $addressdataRepository
	 * @return void
	 */
	public function injectAddressdataRepository(Tx_ValidationExamples_Domain_Repository_AddressdataRepository $addressdataRepository) {
		$this->addressdataRepository = $addressdataRepository;
	}

	/**
	 * action new
	 *
	 * @param Tx_ValidationExamples_Domain_Model_Addressdata $newAddressdata
	 * @dontvalidate $newAddressdata
	 * @return void
	 */
	public function newAction(Tx_ValidationExamples_Domain_Model_Addressdata $newAddressdata = NULL) {
		$this->view->assign('newAddressdata', $newAddressdata);
	}

	/**
	 * Create action
	 *
	 * @param Tx_ValidationExamples_Domain_Model_Addressdata $newAddressdata
	 * @validate $newAddressdata Tx_ValidationExamples_Validation_Validator_AddressdataValidator
	 * @return void
	 */
	public function createAction(Tx_ValidationExamples_Domain_Model_Addressdata $newAddressdata) {
		$this->addressdataRepository->add($newAddressdata);
		$this->view->assign('message', 'Addressdata has been created');
	}
}
?>