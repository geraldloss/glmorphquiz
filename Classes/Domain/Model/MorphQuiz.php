<?php
declare(strict_types=1);
namespace Loss\Glmorphquiz\Domain\Model;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use Loss\Glmorphquiz\Controller\MorphingQuizController;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;


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
 * All Data of a morphing quiz game
 */
class MorphQuiz {
	
	
	/**
	 * All words of the morphing quiz game
	 *
	 * @var ObjectStorage<\Loss\Glmorphquiz\Domain\Model\Word>
	 */
	protected ObjectStorage $m_objWords;
	
	/**
	 * Array with the overall width of every collumn
	 * index: collumn index beginning with 0
	 * width: Width of the collumn in px
	 *
	 * @var array<int>
	 */
	protected array $m_arrColWidth = [];
	
	/**
	 * The width of the first collumn with the arrow.
	 *
	 * @var int
	 */
	protected int $m_intFirstcolWidth = 0;

	/**
	 * The width of the arrow image.
	 *
	 * @var int
	 */
	protected int $m_intArrowWidth = 0;

	
	/**
	 * The location of the arrow file.
	 *
	 * @var string
	 */
	protected string $m_strArrowFile = "";

	/**
	 * The index of the current word in edit mode.
	 *
	 * @var int
	 */
	protected int $m_intWordIndex = 0;
	
	
	/**
	 * The current score of the game.
	 * @var int
	 */
	protected int $m_intScore = 0;
	
	/**
	 * TRUE if the last word is solved.
	 * @var bool
	 */
	protected bool $m_blnLastWord = false;
	
	/**
	 * The finishingtext
	 * @var string
	 */
	protected string $m_strFinishingtext = "";
	
	// ******************************************************************************

	
	/**
	* Sets the firstcol_width
	*
	* @param int $i_intFirstcolWidth
	* @return void
	*/
	public function setFirstcolWidth(int $i_intFirstcolWidth): void {
		$this->m_intFirstcolWidth = $i_intFirstcolWidth;
	}
	
	/**
	* Returns the m_intFirstcolWidth
	*
	* @return int
	*/
	public function getFirstcolWidth(): int {
		return $this->m_intFirstcolWidth;
	}
	
	/**
	* Sets the m_intArrowWidth
	*
	* @param int $i_intArrowWidth
	* @return void
	*/
	public function setArrowWidth(int $i_intArrowWidth): void {
		$this->m_intArrowWidth = $i_intArrowWidth;
	}
	
	/**
	* Returns the m_intArrowWidth
	*
	* @return int
	*/
	public function getArrowWidth(): int {
		return $this->m_intArrowWidth;
	}
	
	/**
	* Sets the m_strArrowFile
	*
	* @param string $i_strArrowFile
	* @return void
	*/
	public function setArrowFile(string $i_strArrowFile): void {
		$this->m_strArrowFile = $i_strArrowFile;
	}
	
	/**
	* Returns the m_strArrowFile
	*
	* @return string
	*/
	public function getArrowFile(): string {
		return $this->m_strArrowFile;
	}
	
	/**
	* Sets the m_objWords
	*
	* @param ObjectStorage<\Loss\Glmorphquiz\Domain\Model\Word> $i_objWords
	* @return void
	*/
	public function setWords(ObjectStorage $i_objWords): void {
		$this->m_objWords = $i_objWords;
	}
	
	/**
	* Returns the m_objWords
	*
	* @return ObjectStorage<\Loss\Glmorphquiz\Domain\Model\Word>
	*/
	public function getWords(): ObjectStorage {
		return $this->m_objWords;
	}
	
	/**
	* Returns the total space which is left between the arrow and the borders.
	*
	* @return int
	*/
	public function getFirstColSpace(): int {
		return $this->getFirstcolWidth() - $this->getArrowWidth();
	}
	
	/**
	* Sets the m_arrColWidth
	*
	* @param array<int> $i_arrColWidth
	* @return void
	*/
	public function setColWidth(array $i_arrColWidth): void {
		$this->m_arrColWidth = $i_arrColWidth;
	}
	
	/**
	* Returns the m_arrColWidth
	*
	* @return array<int>
	*/
	public function getColWidth(): array {
		return $this->m_arrColWidth;
	}
	
	/**
	* Sets the m_intWordIndex
	*
	* @param int $i_intWordIndex
	* @return void
	*/
	public function setWordIndex(int $i_intWordIndex): void {
		$this->m_intWordIndex = $i_intWordIndex;
	}
	
	/**
	* Returns the m_intWordIndex
	*
	* @return int
	*/
	public function getWordIndex(): int {
		return $this->m_intWordIndex;
	}
	
	/**
	* Sets the m_blnLastWord
	*
	* @param bool $i_blnLastWord
	* @return void
	*/
	public function setLastWord(bool $i_blnLastWord): void {
		$this->m_blnLastWord = $i_blnLastWord;
	}
	
	/**
	* Returns the m_blnLastWord
	*
	* @return bool
	*/
	public function getLastWord(): bool {
		return $this->m_blnLastWord;
	}
	
	/**
	* Sets the m_strFinishingtext
	*
	* @param string $i_strFinishingtext
	* @return void
	*/
	public function setFinishingtext(string $i_strFinishingtext): void {
		$this->m_strFinishingtext = $i_strFinishingtext;
	}
	
	/**
	* Returns the m_strFinishingtext
	*
	* @return string
	*/
	public function getFinishingtext(): string {
		return $this->m_strFinishingtext;
	}
	
	/**
	 * Check if the guessed letters are correct.
	 * @param array<string, string> $i_arrArguments Array with the guessed letters
	 * @param MorphingQuizController $i_objMorphQuizController
	 * @param bool $i_blnShowLast True if the last word is shown by default.
	 */
	public function checkLetters(array $i_arrArguments, MorphingQuizController $i_objMorphQuizController, bool $i_blnShowLast): void {
		// the current word in edit mode
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = NULL;
		// the word before
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWordBefore = NULL;
		
		// the current letter
		/* @var $l_objLetter \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter = NULL;
		
		// the letter index
		$l_intLetterIndex = 0;
		// count of all incorrect letters
		$l_intIncorrectCount = 0;
		// number of different letters to the word before
		$l_intDifferentLetters = 0;
		// the message text
		$l_strMsgText = '';
		
		// get the word in edit mode
		$l_objWord = $this->getWordByIndex($this->getWordIndex());
		
		foreach ($l_objWord->getLetters() as $l_objLetter) {
		    
			// get the guessed value of the letter
			$l_objLetter->setValue(strtoupper($i_arrArguments[Letter::C_STR_LETTER_NAME_PREFIX . $l_intLetterIndex]));
			
			// if the answer is wrong
			if ($l_objLetter->getValue() <> $l_objLetter->getCorrectValue()) {
				// increase the incorrect count
				$l_intIncorrectCount++;
			}
			
			$l_intLetterIndex++;
		}
		
		// if there are incorrect answers
		if ($l_intIncorrectCount > 0) {
	    	// This was not correct. Please try again!
			$l_strMsgText = LocalizationUtility::translate('frontend_wrong_answer', 
															  MorphingQuizController::c_strExtensionName
					   										 );
			// show the message
			$i_objMorphQuizController->addFlashMessage($l_strMsgText, '', ContextualFeedbackSeverity::INFO, TRUE);
			
			// change the score
			$this->setScrore($this->getScore() - $l_objWord->getMinus_points());
		}

		// get the word before the word in edit mode
		$l_objWordBefore = $this->getWordByIndex($this->getWordIndex() - 1);
		// count the number of different letter to the word before
		$l_intDifferentLetters = $this->check4letterChangings($l_objWordBefore, $l_objWord, FALSE);
		
		// if there are not exactly 1 letter difference
		if ($l_intDifferentLetters <> 1) {
	    	// Please remember. You are only allowed to change one single letter from 
	    	// word to word. But you have changed %s letters.
			$l_strMsgText = LocalizationUtility::translate('frontend_tomany_wrong_answers', 
															  MorphingQuizController::c_strExtensionName,
					   										  array($l_intDifferentLetters) );
			// show the message
			$i_objMorphQuizController->addFlashMessage($l_strMsgText, '', ContextualFeedbackSeverity::INFO, TRUE);
		}
		
		// if all ansers are correct
		if ($l_intIncorrectCount === 0) {
	    	// The answer was correct.
			$l_strMsgText = LocalizationUtility::translate('frontend_correct_answer', 
															MorphingQuizController::c_strExtensionName
					   										 );
			// show the message
			$i_objMorphQuizController->addFlashMessage($l_strMsgText, '', ContextualFeedbackSeverity::INFO, TRUE);
			
			// change the score
			$this->setScrore($this->getScore() + $l_objWord->getPoints());
			
			// solve the current word
			$this->solveWord($i_blnShowLast);
		}
	}
	
	/**
	 * Solve the current word.
	 * @param bool $i_blnShowLast True if the last word is shown by default.
	 */
	public function solveWord(bool $i_blnShowLast): void {
		
		// the count of the words
		$l_intWordCount = 0;
		
		// unset the input mode for the current word in input mode
		$this->setInputMode4Word(false);
		// go to the next word
		$this->setWordIndex($this->getWordIndex() + 1);
		
		// if last word is shown by default
		if ($i_blnShowLast) {
			// the last word count is one less
			$l_intWordCount = $this->getWords()->count() - 1;
		
		// if the last word is not shown and must be guessed
		} else {
			$l_intWordCount = $this->getWords()->count();
		}
		
		// if this was the last word
		if ($this->getWordIndex() == $l_intWordCount) {
			$this->setLastWord(true);
				
			// if this is still not the last word
		} else {
			// activate the input mode for this word
			$this->setInputMode4Word(true);
		}
	}
	
	/**
	 * Set or unset the input mode for all letters of the current word.
	 * @param bool $i_blnInputMode
	 */
	protected function setInputMode4Word(bool $i_blnInputMode): void {
		// the current word in edit mode
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = null;
		
		// the current letter
		/* @var $l_objLetter \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter = null;
		
		// the count of the letters
		$l_intLetterCount = 0;

		// get the current word
		$l_objWord = $this->getWordByIndex($this->getWordIndex());
		
		// set the input mode
		$l_objWord->setInputmode($i_blnInputMode);
		
		foreach ($l_objWord->getLetters() as $l_objLetter) {
			
			// if this is the first letter
			if ($l_intLetterCount === 0) {
				// activate or deactive the autofocus option
			    $l_objLetter->setAutofocus($i_blnInputMode);
			} 
			
			// if this word should be in input mode
			if ($i_blnInputMode) {
			    // empty the current value
			    $l_objLetter->setValue('');
			
			// if the word is not any more in input mode
			} else {
				// make the correct value visible
				$l_objLetter->setValue($l_objLetter->getCorrectValue());
			}
			
			// increase the letter count
			$l_intLetterCount += 1;
		}
	}
	
	/**
	 * Returns a word of the object storage by an index
	 * @param int $i_intIndex
	 * @return \Loss\Glmorphquiz\Domain\Model\Word|null
	 */
	protected function getWordByIndex(int $i_intIndex): ?\Loss\Glmorphquiz\Domain\Model\Word {
	
		// the returning word
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = NULL;
		// the current index
		$l_intCurrentIndex = 0;
	
		
		foreach ($this->getWords() as $l_objWord) {
				
			// if this is the demanded index
			if ($l_intCurrentIndex == $i_intIndex) {
				// return the letter
				return $l_objWord;
			}
				
			$l_intCurrentIndex++;
		}
	
		return NULL;
	}
	
	/**
	* Sets the m_intScore
	*
	* @param int $i_intScore
	* @return void
	*/
	public function setScrore(int $i_intScore): void {
		$this->m_intScore = $i_intScore;
	}
	
	/**
	* Returns the m_intScore
	*
	* @return int
	*/
	public function getScore(): int {
		return $this->m_intScore;
	}
	
	/**
	 * Check if between the both letter bunches has only changed one word.
	 * @param \Loss\Glmorphquiz\Domain\Model\Word $i_objWord1
	 * @param \Loss\Glmorphquiz\Domain\Model\Word $i_objWord2
	 * @param bool $i_blnCorrectValue If True (default) than check the correct values otherwise check the value property
	 * @return int Number of different letters
	 */
	public function check4letterChangings(\Loss\Glmorphquiz\Domain\Model\Word $i_objWord1, \Loss\Glmorphquiz\Domain\Model\Word $i_objWord2, bool $i_blnCorrectValue = true): int {
	
		// the letter of the first word
		/* @var $l_objLetter1 \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter1 = NULL;
		// the letter of the second word
		/* @var $l_objLetter2 \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter2 = NULL;
		// the current index
		$l_intCurrentIndex = 0;
		// count of changings
		$l_intChangeCount = 0;
	
		// start loop
		while (TRUE) {
	
			// get the letter of the first word
			$l_objLetter1 = $i_objWord1->getLetterByIndex($l_intCurrentIndex);
			// get the letter of the second word
			$l_objLetter2 = $i_objWord2->getLetterByIndex($l_intCurrentIndex);
	
			// if there is no letter any more
			if ($l_objLetter1 === NULL || $l_objLetter2 === NULL) {
				// leave loop
				break;
			}
			
			// if we have to check the correct values
			if ($i_blnCorrectValue) {
				// if the both letters are different
				if ($l_objLetter1->getCorrectValue() <> $l_objLetter2->getCorrectValue()) {
					// add 1 to the change count
					$l_intChangeCount++;
				}

			// if we have to check the value property
			} else {
				// if the both letters are different
				if ($l_objLetter1->getValue() <> $l_objLetter2->getValue()) {
					// add 1 to the change count
					$l_intChangeCount++;
				}
			}
			
				
			// goto next index
			$l_intCurrentIndex++;
		}
		// return the change count
		return $l_intChangeCount;
	}
	
	/**
	 * Compares two MorphQuiz if they are the same.
	 * @param MorphQuiz $i_objMorphQuiz The MorphQuiz which should be compared with this MorphQuiz
	 * @return bool Returns True if both are the same.
	 */
	public function compare(MorphQuiz $i_objMorphQuiz): bool {

		// the own current word
		/* @var $l_objWordOwn \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWordOwn = NULL;
		// the other current word
		/* @var $l_objWordOther \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWordOther = NULL;
		// the current index
		$l_intCurrentIndex = 0;
		// the returning boolean
		$l_blnReturn = TRUE;
		
		// go through every own words
		foreach ($this->getWords() as $l_objWordOwn) {
			$l_intCurrentIndex++;
			$l_objWordOther = $i_objMorphQuiz->getWordByIndex($l_intCurrentIndex);
			
			// If both words are not the same
			if ($l_objWordOwn->getUid() != $l_objWordOther->getUid()) {
				// return False immediately
			    $l_blnReturn = FALSE;
			    break;
			}
		}
		
		// return result
		return $l_blnReturn;
	}
}

?>