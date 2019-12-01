<?php
namespace Loss\Glmorphquiz\Domain\Repository;
use Loss\Glmorphquiz\Controller\MorphingQuizController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;

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
	 * @param integer $p_iStartWordUid The uid of the first word in the quiz
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage		Objectstorage with all words of the morphing quiz
	 */
	public function getMorphQuizWords($i_intStartWordUid, 
									  \Loss\Glmorphquiz\Controller\MorphingQuizController $i_objController) {
		
		// the returning object storage with all word objects
		/* @var $l_objRetWordData \TYPO3\CMS\Extbase\Persistence\ObjectStorage */
		$l_objRetWordData = NULL;
		
		// one single word object
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = NULL;
		// the word bevore
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWordBevore = NULL;
		
		// the error text
		$l_strErrorText = '';
		// the title
		$l_strTitleText = '';
		
		// create object storage
		$l_objRetWordData = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\ObjectStorage');
		
		// get the first word
		$l_objWord = $this->getSingleWord($i_intStartWordUid);
		// if nothing found
		if ($l_objWord === NULL) {
			// return with an empty object
		    return $l_objRetWordData;
		}
		// put it in the object storage
		$l_objRetWordData->attach($l_objWord);
		
		// as long as further words exists
		while ($l_objWord->getNextWord() <> 0) {
		    
			// get the next word
			$l_objWord = $this->getSingleWord($l_objWord->getNextWord());
			// if nothing found
			if ($l_objWord === NULL) {
				// exit loop
				break;
			}
			
			// if the word already exit
			if ($this->existsWordInStorage($l_objRetWordData, $l_objWord)) {
				// prevent invinite loop
// 			    throw new Exception('Exception because of invinite loop. There are double references to the word with the UID: ' .
// 			    					$l_objWord->getUid() . ' and the name: ' . $l_objWord->getName());
			    
				// Exception because of invinite loop. There are double references to the word 
				// with the UID: "%s" and the name: "%s" from word with name: "%s" and UID: "%s" 
				// and another word(s).
				$l_strErrorText = LocalizationUtility::translate('frontend_infinite_loop',
																  MorphingQuizController::c_strExtensionName,
																  array( $l_objWord->getUid(),
																	     $l_objWord->getName(),
																  		 $l_objWordBevore->getUid(),
																  		 $l_objWordBevore->getName()
																   )
									);
				
				$l_strTitleText = LocalizationUtility::translate('frontend_error_title',
																  MorphingQuizController::c_strExtensionName );
				
				// set error message text
				$i_objController->addFlashMessage($l_strErrorText, $l_strTitleText, AbstractMessage::ERROR, TRUE);
				
				// return empty object
				return $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\ObjectStorage');;
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
	 * @param integer $p_iWordUid 	The UID of the word
	 * @return \Loss\Glmorphquiz\Domain\Model\Word 	The word object
	 */	
	protected function getSingleWord($i_intWordUid) {
		// The query object
		/* @var $l_objQuery  \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$l_objQuery = null;
		
		// Object with the result of the query 
		/* @var $l_objQueryResult  \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
		$l_objQueryResult = NULL;
		
		$l_objQuery = $this->createQuery();
		// dont take the data only from one single sys-folder
		// we like to get the pairs data from alle pages where pairs extists
		$l_objQuery->getQuerySettings()->setRespectStoragePage(FALSE);
		
		// get only one entry, the entry with the pid of the requested pairs game
		$l_objQuery->matching($l_objQuery->equals('uid', $i_intWordUid));
		$l_objQueryResult = $l_objQuery->execute();
		return  $l_objQueryResult->getFirst();
	}
	
	/**
	 * Check if word object already exists in object storage
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $i_objObjectStorage
	 * @param \Loss\Glmorphquiz\Domain\Model\Word $i_objWord
	 * @return boolean 	True if already exists
	 */
	protected function existsWordInStorage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $i_objObjectStorage, 
										   \Loss\Glmorphquiz\Domain\Model\Word $i_objWord) {
		// one single word object
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = NULL;
		
		// the returning boolean
		$l_blnReturn = FALSE;
		
		foreach ($i_objObjectStorage as $l_objWord) {
			// if the word already exists
		    if ($l_objWord->getUid() == $i_objWord->getUid()) {
		        $l_blnReturn = TRUE;
		        break;
		    }
		}
		
		// return the result
		return $l_blnReturn;
	}
}

?>