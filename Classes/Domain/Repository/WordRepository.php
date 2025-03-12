<?php
declare(strict_types=1);
namespace Loss\Glmorphquiz\Domain\Repository;
use Loss\Glmorphquiz\Controller\MorphingQuizController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
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
 * The repository for Words
 */
class WordRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
	/**
	 * Retrieve the words of the morphing quiz
	 *  
	 * @param int $i_intStartWordUid The uid of the first word in the quiz
	 * @param MorphingQuizController $i_objController
	 * @return ObjectStorage<\Loss\Glmorphquiz\Domain\Model\Word>
	 */
	public function getMorphQuizWords(int $i_intStartWordUid, MorphingQuizController $i_objController): ObjectStorage {
		
		// the returning object storage with all word objects
		/* @var $l_objRetWordData \TYPO3\CMS\Extbase\Persistence\ObjectStorage */
		$l_objRetWordData = GeneralUtility::makeInstance(ObjectStorage::class);
		
		// one single word object
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = null;
		// the word bevore
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWordBevore = null;
		
		// the error text
		$l_strErrorText = '';
		// the title
		$l_strTitleText = '';
		
		// get the first word
		$l_objWord = $this->getSingleWord($i_intStartWordUid);
		// if nothing found
		if ($l_objWord === null) {
			// return with an empty object
		    return $l_objRetWordData;
		}
		// put it in the object storage
		$l_objRetWordData->attach($l_objWord);
		
		// as long as further words exist
		while ($l_objWord->getNextWord() !== 0) {
		    
			// get the next word
			$l_objWord = $this->getSingleWord($l_objWord->getNextWord());
			// if nothing found
			if ($l_objWord === null) {
				// exit loop
				break;
			}
			
			// if the word already exists
			if ($this->existsWordInStorage($l_objRetWordData, $l_objWord)) {
				// prevent infinite loop
				$l_strErrorText = LocalizationUtility::translate('frontend_infinite_loop',
																  MorphingQuizController::c_strExtensionName,
																  [$l_objWord->getUid(), $l_objWord->getName(), $l_objWordBevore->getUid(), $l_objWordBevore->getName()]);
				
				$l_strTitleText = LocalizationUtility::translate('frontend_error_title', MorphingQuizController::c_strExtensionName);
				
				// set error message text
				$i_objController->addFlashMessage($l_strErrorText, $l_strTitleText, ContextualFeedbackSeverity::ERROR, true);
				
				// return empty object
				return GeneralUtility::makeInstance(ObjectStorage::class);
			}
			
			// put it in the object storage
			$l_objRetWordData->attach($l_objWord);
			$l_objWordBevore = $l_objWord;
		}

		// return the object storage
		return $l_objRetWordData;
	}
	
	/**
	 * Get one word with its UID
	 * @param int $i_intWordUid The UID of the word
	 * @return \Loss\Glmorphquiz\Domain\Model\Word|null
	 */	
	protected function getSingleWord(int $i_intWordUid): ?\Loss\Glmorphquiz\Domain\Model\Word {
		// The query object
		/* @var $l_objQuery  \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$l_objQuery = null;
		
		// Object with the result of the query 
		/* @var $l_objQueryResult  \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
		$l_objQueryResult = NULL;
		
		$l_objQuery = $this->createQuery();
		
		// don't take the data only from one single sys-folder
		// we like to get the pairs data from all pages where pairs exist
		$l_objQuery->getQuerySettings()->setRespectStoragePage(false);
		
		// get only one entry, the entry with the pid of the requested pairs game
		$l_objQuery->matching($l_objQuery->equals('uid', $i_intWordUid));
		$l_objQueryResult = $l_objQuery->execute();
		return $l_objQueryResult->getFirst();
	}
	
	/**
	 * Check if word object already exists in object storage
	 * 
	 * @param ObjectStorage<\Loss\Glmorphquiz\Domain\Model\Word> $i_objObjectStorage
	 * @param \Loss\Glmorphquiz\Domain\Model\Word $i_objWord
	 * @return bool True if already exists
	 */
	protected function existsWordInStorage(ObjectStorage $i_objObjectStorage, \Loss\Glmorphquiz\Domain\Model\Word $i_objWord): bool {
		// one single word object
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = null;
		
		// the returning boolean
		$l_blnReturn = false;
		
		foreach ($i_objObjectStorage as $l_objWord) {
			// if the word already exists
		    if ($l_objWord->getUid() === $i_objWord->getUid()) {
		        $l_blnReturn = true;
		        break;
		    }
		}
		
		// return the result
		return $l_blnReturn;
	}
}

?>