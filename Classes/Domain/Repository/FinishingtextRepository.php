<?php
declare(strict_types=1);
namespace Loss\Glmorphquiz\Domain\Repository;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Gerald Loß <gerald.loss@gmx.de>
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
 * The repository for Finishingtexts
 */
class FinishingtextRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
	/**
	 * Get all the finishing text for the given uids
	 * @param string $i_strUids The uids comma separated
	 * @return ObjectStorage<\Loss\Glmorphquiz\Domain\Model\Finishingtext>
	 */
	public function getFinishingtexts(string $i_strUids): ObjectStorage {
		// the returning ObjectStorage
		$l_objObjectStorage = GeneralUtility::makeInstance(ObjectStorage::class);
		
		// Object with the result of the query 
		/* @var $l_objResult  \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
		$l_objResult = null;
		
		// The query object
		/* @var $l_objQuery  \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$l_objQuery = null;
		
		// The finishingtext object
		/* @var $l_objFinishingText \Loss\Glmorphquiz\Domain\Model\Finishingtext */
		$l_objFinishingText = null;
		
		$l_objQuery = $this->createQuery();
		
		// don't take the data only from one single sys-folder
		// we like to get the pairs data from all pages where pairs exist
		$l_objQuery->getQuerySettings()->setRespectStoragePage(false);
		
		// get language dependend aspect
		/* @var LanguageAspect $languageAspect */
		$languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
		$l_objQuery->getQuerySettings()->setLanguageUid($languageAspect->getId());
		
		// get all finishingtexts with the uids 
		$l_objQuery->matching($l_objQuery->in('uid', explode(',', $i_strUids)));
		$l_objResult = $l_objQuery->execute();
		
		// set all finishingtexts into the objectstorage
		foreach ($l_objResult as $l_objFinishingText) {
		    $l_objObjectStorage->attach($l_objFinishingText);
		}
		
		// return the objectstorage
		return $l_objObjectStorage;
	}
	
}

?>