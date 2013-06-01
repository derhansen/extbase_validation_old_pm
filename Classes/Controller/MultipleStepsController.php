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
 * Multiple steps form
 *
 * @package validation_examples
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_ValidationExamples_Controller_MultipleStepsController extends Tx_Extbase_MVC_Controller_ActionController {

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
	 * Step1
	 *
	 * @param Tx_ValidationExamples_Domain_Model_Step1Data $step1data
	 * @dontvalidate $step1data
	 */
	public function step1Action(Tx_ValidationExamples_Domain_Model_Step1Data $step1data = NULL) {
		/* Check if step1data is available in session */
		if ($GLOBALS['TSFE']->fe_user->getKey('ses', 'step1data') && $step1data == NULL) {
			$step1data = unserialize($GLOBALS['TSFE']->fe_user->getKey('ses', 'step1data'));
		}

		$this->view->assign('step1data', $step1data);
	}

	/**
	 * Step1 redirect action
	 *
	 * @param Tx_ValidationExamples_Domain_Model_Step1Data $step1data
	 */
	public function step1redirectAction(Tx_ValidationExamples_Domain_Model_Step1Data $step1data) {
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'step1data', serialize($step1data));
		$GLOBALS['TSFE']->fe_user->storeSessionData();

		$this->redirect('step2');
	}

	/**
	 * Step2
	 *
	 * @param Tx_ValidationExamples_Domain_Model_Step2Data $step2data
	 * @dontvalidate $step2data
	 */
	public function step2Action(Tx_ValidationExamples_Domain_Model_Step2Data $step2data = NULL) {
		/* Check if step2data is available in session */
		if ($GLOBALS['TSFE']->fe_user->getKey('ses', 'step2data') && $step2data == NULL) {
			$step2data = unserialize($GLOBALS['TSFE']->fe_user->getKey('ses', 'step2data'));
		}

		/* Set external validations errors if available */
		$this->setApiValidationErrors('step2');

		$this->view->assign('step2data', $step2data);
	}

	/**
	 * Step2 redirect action
	 *
	 * @param Tx_ValidationExamples_Domain_Model_Step2Data $step2data
	 */
	public function step2redirectAction(Tx_ValidationExamples_Domain_Model_Step2Data $step2data) {
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'step2data', serialize($step2data));
		$GLOBALS['TSFE']->fe_user->storeSessionData();

		$this->redirect('step3');
	}


	/**
	 * Step3
	 *
	 * @param Tx_ValidationExamples_Domain_Model_Step3Data $step3data
	 * @dontvalidate $step3data
	 */
	public function step3Action(Tx_ValidationExamples_Domain_Model_Step3Data $step3data = NULL) {
		/* Check if step3data is available in session */
		if ($GLOBALS['TSFE']->fe_user->getKey('ses', 'step3data') && $step3data == NULL) {
			$step3data = unserialize($GLOBALS['TSFE']->fe_user->getKey('ses', 'step3data'));
		}

		/* Set external validations errors if available */
		$this->setApiValidationErrors('step3');

		$this->view->assign('step3data', $step3data);
	}

	/**
	 * Step3 redirect action
	 *
	 * @param Tx_ValidationExamples_Domain_Model_Step3Data $step3data
	 */
	public function step3redirectAction(Tx_ValidationExamples_Domain_Model_Step3Data $step3data) {
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'step3data', serialize($step3data));
		$GLOBALS['TSFE']->fe_user->storeSessionData();

		$this->redirect('create');
	}

	/**
	 * Create Action
	 *
	 * @return void
	 */
	public function createAction() {
		$addressdata = $this->getAddressdataFromSession();

		/* get validation results from API */
		$apiresults = $this->apiService->validateMultipleSteps($addressdata);
		if (count($apiresults) > 0) {
			/* Save results to a session variable */
			$GLOBALS['TSFE']->fe_user->setKey('ses', 'apiresults', $apiresults);
			$GLOBALS['TSFE']->fe_user->storeSessionData();

			/* Redirect to step with validation errors */
			if (array_key_exists('step2', $apiresults)) {
				$this->redirect('step2');
			}
			if (array_key_exists('step3', $apiresults)) {
				$this->redirect('step3');
			}
		}

		$this->addressdataRepository->add($addressdata);
		$this->cleanUpSessionData();

		$this->view->assign('message', 'Addressdata has been created');
	}

	/**
	 * Collects the addressdata from the multiple steps form stored in session variables
	 * and returns an addressdata object.
	 *
	 * @return Tx_ValidationExamples_Domain_Model_Addressdata
	 */
	protected function getAddressdataFromSession() {
		/** @var Tx_ValidationExamples_Domain_Model_Step1Data $step1data */
		$step1data = unserialize($GLOBALS['TSFE']->fe_user->getKey('ses', 'step1data'));

		/** @var Tx_ValidationExamples_Domain_Model_Step2Data $step2data */
		$step2data = unserialize($GLOBALS['TSFE']->fe_user->getKey('ses', 'step2data'));

		/** @var Tx_ValidationExamples_Domain_Model_Step3Data $step3data */
		$step3data = unserialize($GLOBALS['TSFE']->fe_user->getKey('ses', 'step3data'));

		$addressData = new Tx_ValidationExamples_Domain_Model_Addressdata();
		$addressData->setFirstname($step1data->getFirstname());
		$addressData->setLastname($step1data->getLastname());
		$addressData->setStreet($step2data->getStreet());
		$addressData->setStreetnr($step2data->getStreetnr());
		$addressData->setZip($step3data->getZip());
		$addressData->setCity($step3data->getCity());

		return $addressData;
	}

	/**
	 * Removes all session variables from the multiple steps form
	 *
	 * @return void
	 */
	protected function cleanUpSessionData() {
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'step1data', '');
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'step2data', '');
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'step3data', '');
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'apiresults', '');
		$GLOBALS['TSFE']->fe_user->storeSessionData();
	}

	/**
	 * Sets validation errors for fields in the given step
	 *
	 * @param string $step The step
	 * @return void
	 */
	protected function setApiValidationErrors($step) {
		$apiresults = $GLOBALS['TSFE']->fe_user->getKey('ses', 'apiresults');
		if (array_key_exists($step, $apiresults)) {
			/* Set Form Errors manually */
			$origErrors = $this->controllerContext->getRequest()->getErrors();
			if ($origErrors) {
				$errors = $origErrors[$step . 'data'];
			} else {
				$errors = new Tx_Extbase_MVC_Controller_ArgumentError($step . 'data');
			}

			$propertyErrors = array();

			/* Add validation errors */
			foreach ($apiresults[$step] as $key => $value) {
				$propertyErrors[$key] = $this->objectManager->create('Tx_Extbase_Validation_PropertyError', $key);
				$message = $apiresults[$step][$key];
				$propertyError = $this->objectManager->create('Tx_Extbase_Validation_Error', $message, time());
				$propertyErrors[$key]->addErrors(array($propertyError));
			}
			$errors->addErrors($propertyErrors);

			$this->controllerContext->getRequest()->setErrors(array($errors));
		}
	}
}
?>