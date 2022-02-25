<?php
namespace Loss\Glmorphquiz\Controller;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use Loss\Glmorphquiz\Domain\Model\Letter;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Page\PageRenderer;

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
 *
 *
 * @package glpairs
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MorphingQuizController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
									 
	//*****************************************************************************
	// The constants of this class
	//*****************************************************************************
	/**
	 * The vendor of this extension
	 * @var \string
	 */
	const c_strVendor = 'loss';
	
	/**
	 * The name of this extension
	 * @var \string
	 */
	const c_strExtensionName = 'glmorphquiz';
	
	/**
	 * The Plugin Name
	 * @var \string
	 */
	const c_strPluginName = 'pi1';
	
	/**
	 * The session name of the morphing quiz game. 
	 * @var string
	 */
	const c_strMorphQuizSessionName = 'glmorphquiz_session';

	//*****************************************************************************
	// The static members of this class
	//*****************************************************************************
	

	//*****************************************************************************
	// The member attributes of this class
	//*****************************************************************************
	
	
	/**
	 * m_objWordRepository
	 *
	 * @var \Loss\Glmorphquiz\Domain\Repository\WordRepository
	 */
	protected $m_objWordRepository;
	
	/**
	 * $m_objFinishingtextRepository
	 *
	 * @var \Loss\Glmorphquiz\Domain\Repository\FinishingtextRepository
	 */
	protected $m_objFinishingtextRepository;
	
	/**
	 * Inject a word repository to enable DI
	 *
	 * @param \Loss\Glmorphquiz\Domain\Repository\WordRepository $wordRepository
	 */
	public function injectPairsRepository(\Loss\Glmorphquiz\Domain\Repository\WordRepository $wordRepository)
	{
	    $this->m_objWordRepository = $wordRepository;
	}
	
	
	/**
	 * Inject a finishing text repository to enable DI
	 *
	 * @param \Loss\Glmorphquiz\Domain\Repository\FinishingtextRepository $finishingtextRepository
	 */
	public function injectFinishingtextRepository(\Loss\Glmorphquiz\Domain\Repository\FinishingtextRepository $finishingtextRepository)
	{
	    $this->m_objFinishingtextRepository = $finishingtextRepository;
	}
	
	/**
	 * All actions which we need to perform before avery other action
	 * @see \TYPO3\CMS\Extbase\Mvc\Controller\ActionController::initializeAction()
	 */
	protected function initializeAction() {
		// path to the css file
		$l_strPathCss = '';
		
		$l_strPathCss = '<link href="' . $this->getCssFile() .  '" rel="stylesheet" type="text/css" />';
		$pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
		$pageRenderer->addCssFile($this->getCssFile());
	}
	
	
	/**
	 * action list
	 * 
	 * @return void
	 */
	public function listAction() {
		// the morphing quiz game
		/* @var $l_objMorphingQuizData \Loss\Glmorphquiz\Domain\Model\MorphQuiz */
		$l_objMorphingQuizData = NULL;
		
		// the morphing quiz game from the database to compare
		/* @var $l_objMorphingQuizOrig \Loss\Glmorphquiz\Domain\Model\MorphQuiz */
		$l_objMorphingQuizOrig = NULL;
		
		// the error text
		$l_strErrorText = '';
		// the title
		$l_strTitleText = '';
		
		// try to get the current context from the session
		$l_objMorphingQuizData = $GLOBALS['TSFE']->fe_user->getKey('ses', self::c_strMorphQuizSessionName);
		$l_objMorphingQuizData = $this->fixSessionObject($l_objMorphingQuizData);
		
		// delete the game context from the session
		$GLOBALS['TSFE']->fe_user->setAndSaveSessionData(
				self::c_strMorphQuizSessionName,
				NULL );
		
		// if this is the first call of this action
		if ($l_objMorphingQuizData === NULL) {
			// build the object with the morphing quiz datas
			$l_objMorphingQuizData = $this->createMorpingQuizData(1);
		}
		
		// check for errors
		$l_strErrorText = $this->checkMorphQuiz($l_objMorphingQuizData);
		
		// if there is a error found
		if ($l_strErrorText != '') {
			// get the title
			$l_strTitleText = LocalizationUtility::translate('frontend_error_title',
															  MorphingQuizController::c_strExtensionName );
			
			// show the error message
			$this->addFlashMessage($l_strErrorText, $l_strTitleText, AbstractMessage::ERROR, TRUE);
			
		// if everything is OK
		} else {
			// assign the data to the view
			$this->view->assign('morphquiz', $l_objMorphingQuizData);
		}
	}
	
	/**
	 * action next
	 *
	 * @return void
	 */
	public function responseAction() {
		
		// the object storage with the morphing quiz game
		/* @var $l_objWordData \Loss\Glmorphquiz\Domain\Model\MorphQuiz */
		$l_objMorphingQuizData = NULL;
		// the message text
		$l_strMsgText = '';
		
		// parameters send back from the frontend
		$l_arrArgs = array();
		
		$l_arrArgs = $this->request->getArguments();
		
		// build the object with all morphing quiz data
		$l_objMorphingQuizData = $this->createMorpingQuizData($l_arrArgs['wordIndex'], $l_arrArgs['score']);
		
		
		// if button next is pressed
		if (isset($l_arrArgs['next'])) {
			
			// Check if the word is correct answered
			$l_objMorphingQuizData->checkLetters($l_arrArgs, $this, $this->settings['show_last']);
						    
		// if the button solve is pressed
		} else if (isset($l_arrArgs['solve'])){

			// This was not correct. Please try again!
			$l_strMsgText = LocalizationUtility::translate('frontend_solved_answer',
															MorphingQuizController::c_strExtensionName );

			// show the message
			$this->addFlashMessage($l_strMsgText, '', AbstractMessage::INFO, TRUE);
				
			// solve the word
			$l_objMorphingQuizData->solveWord($this->settings['show_last']);
		}
		
		// if this was the last word
		if ($l_objMorphingQuizData->getLastWord()) {
		    // set the finishingtext
			$l_objMorphingQuizData->setFinishingtext($this->getFinishingtext($l_objMorphingQuizData));
		}
		
		// store the current morphing quiz game context
		$GLOBALS['TSFE']->fe_user->setAndSaveSessionData(
				self::c_strMorphQuizSessionName,
				$l_objMorphingQuizData );
		
		// redirect to the list action
		$this->redirect('list');
	}

	/**
	 * Korrigiert Objekte aus der Session die beim deserialisieren ein __PHP_Incomplete_Class Objekt werden
	 * @param object $i_objObject
	 * @return object
	 */
	protected function fixSessionObject(&$i_objObject){
	    
	    if (is_object ($i_objObject) && get_class($i_objObject) == '__PHP_Incomplete_Class')
	        return ($i_objObject = unserialize(serialize($i_objObject)));
	        
	    return $i_objObject;
	}
	
	
	/**
	 * Returns an object storage with all data for the morphing quiz game.
	 * @param 	integer $i_intWordIndex 					Index of the word in input mode, starting with 0
	 * @return 	\Loss\Glmorphquiz\Domain\Model\MorphQuiz	Object with all data for the morphing quiz game
	 */
	protected function createMorpingQuizData($i_intWordIndex, $i_intScore = 0) {
		
		// the returning object storage with all data of the morphing quiz game
		/* @var $l_objRetMorphQuizData \Loss\Glmorphquiz\Domain\Model\MorphQuiz */
		$l_objRetMorphQuizData = $this->objectManager->get('Loss\Glmorphquiz\Domain\Model\MorphQuiz');
		
		// the object storage with all word objects
		/* @var $l_objWordData \TYPO3\CMS\Extbase\Persistence\ObjectStorage */
		$l_objWordData = NULL;
		
		// one single word object
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = NULL;
		
		// the number of the word
		$l_intWordCount = 1;
		
		// Flag if the word is visible
		$l_blnVisible = FALSE;
		
		// get all of the words of the morphing quiz
		$l_objWordData = $this->m_objWordRepository->getMorphQuizWords($this->settings['firstWord'], $this);
		
		// go through every word in the game
		foreach ($l_objWordData as $l_objWord) {
		
			// if this is the word in input mode and not the last word
			if ( ($l_intWordCount - 1) == $i_intWordIndex  && $l_objWordData->count() != $i_intWordIndex){
				// set this word in input mode
				$l_objWord->setInputmode(TRUE);
			}
			
			// if points are not set
			if ($l_objWord->getPoints() === 0) {
			    // set the points from the overall settings
				$l_objWord->setPoints($this->settings['points']);
			}
			
			// if minus points are not set
			if ($l_objWord->getMinus_points() === 0) {
				// set the value from the overall settings
				$l_objWord->setMinus_points($this->settings['minus_points']);
			}
				
			// if fontsize is not set
			if ($l_objWord->getFontsize() === 0) {
				// set the value from the overall settings
				$l_objWord->setFontsize($this->settings['fontsize']);
			}
				
			// if height of a letter is not set
			if ($l_objWord->getHeight_letter() === 0) {
				// set the value from the overall settings
				$l_objWord->setHeight_letter($this->settings['height_letter']);
			}
				
			// if width of the single letter is not set
			if ($l_objWord->getWidth_letter() === 0) {
				// set the value from the overall settings
				$l_objWord->setWidth_letter($this->settings['width_letter']);
			}
				
			// if letter width offset is not set
			if ($l_objWord->getWidth_letter_offset() === 0) {
				// set the value from the overall settings
				$l_objWord->setWidth_letter_offset($this->settings['width_letter_offset']);
			}
							
			// if the animation speed is not set in the word
			if ($l_objWord->getAnimation_speed() === 0) {
				// set the value from the overall settings
				$l_objWord->setAnimation_speed($this->settings['animation_speed']);
			}
			
			// if this is one of the already guessed words 
			// or this is the last word of the quiz AND show_last Flag is active
			if ($l_intWordCount <= $i_intWordIndex || 
				( $l_objWordData->count() == $l_intWordCount && $this->settings['show_last'])) {
			    // make the word visible
			    $l_blnVisible = TRUE;
			
			// if this is a word in the middle
			} else {
			    $l_blnVisible = FALSE;
			}
			
			// set the letters of the word
			$l_objWord->setLetters($this->getLettersOfWord($l_objWord, $l_blnVisible));
			
			// set the overall width of the collumns
			$this->setOverallColWidth($l_objRetMorphQuizData, $l_objWord->getLetters());
			
			// increase the word count
			$l_intWordCount++;
		}
		
		// set the margin-right property for all letters
		$this->setMargin4Letters($l_objWordData, $l_objRetMorphQuizData);
		
		// set all words of the morphing quiz game
		$l_objRetMorphQuizData->setWords($l_objWordData);
		
		// set the first collumn width
		$l_objRetMorphQuizData->setFirstcolWidth($this->settings['firstcol_width']);
			
		// if alternate arrow image is set
		if ($this->settings['arrowFile'] != '') {
			$l_objRetMorphQuizData->setArrowFile('fileadmin/' . $this->settings['arrowFile']);
			 
		// if alternate arrow image is not set
		} else {
// 			// set the default file
// 			$l_objRetMorphQuizData->setArrowFile(
// 			    PathUtility::getAbsoluteWebPath(GeneralUtility::getFileAbsFileName(
// 			        'EXT:' . MorphingQuizController::c_strExtensionName . '/Resources/Public/images/Arrow.gif' ))
// 			);
            // leave it empty
		    $l_objRetMorphQuizData->setArrowFile('');
		}
			
		// set the width of the arrow image
		$l_objRetMorphQuizData->setArrowWidth($this->settings['arrow_width']);
		
		// set the index of the current word in edit mode
		$l_objRetMorphQuizData->setWordIndex($i_intWordIndex);
		
		// set the score of the game
		$l_objRetMorphQuizData->setScrore($i_intScore);
		
		// return the data of the morphing quiz game
		return $l_objRetMorphQuizData;
	}
	
	
	// get the path to the css file
	protected function getCssFile() {
		// if alternate css file is set
		if ($this->settings['cssFile'] != '') {
			return 'fileadmin/' . $this->settings['cssFile'];
		
		// if alternate css file is not set
		} else {
			// return the default file
		    return PathUtility::getAbsoluteWebPath(GeneralUtility::getFileAbsFileName(
		        'EXT:' . MorphingQuizController::c_strExtensionName . '/Resources/Public/css/MorphQuiz.css' ));
		}
	}
	
	/**
	 * Returns a Objectstorage with all letters of the word
	 * @param \Loss\Glmorphquiz\Domain\Model\Word $i_objWord
	 * @param boolean Flag if the word is visible
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	protected function getLettersOfWord(\Loss\Glmorphquiz\Domain\Model\Word $i_objWord, $i_blnVisible = FALSE) {
		// the object storage with all the letters
		/* @var $l_objLetters \TYPO3\CMS\Extbase\Persistence\ObjectStorage */
		$l_objLetters = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\ObjectStorage');
		
		// a letter object
		/* @var $l_objLetter \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter = NULL;
		
		
		// Flag if the end of the word is reached
		$l_blnIsEnd = FALSE;
		// index in the edit mask
		$l_intIndexMask = 0;
		// index in the word
		$l_intIndexWord = 0;
		// current length of the letter
		$l_intCurrentLength = 0;
		// the current letter
		$l_strCurrentLetter = '';
		
		// as long the end is not reached
		while (!$l_blnIsEnd) {
			
			// if lenght of edit mask is lower then the current index
			if ($this->getLenghtOfMask($i_objWord->getMask()) <= $l_intIndexMask) {
				// take the default length
				$l_intCurrentLength = 1;
			
			// if there is an edit mask into the current index 
			} else {
				// read the length of the letter from the mask
				$l_intCurrentLength = substr($i_objWord->getMask(), $l_intIndexMask, 1);
			}
			
			// read the current letter
			$l_strCurrentLetter = substr($i_objWord->getValue(), $l_intIndexWord, $l_intCurrentLength);
			
			// create the letter object
			$l_objLetter = $this->objectManager->get('Loss\Glmorphquiz\Domain\Model\Letter');
			
			// set the properties
			$l_objLetter->setWord($i_objWord);
			$l_objLetter->setCorrectValue($l_strCurrentLetter);
			$l_objLetter->setLength($l_intCurrentLength);
			$l_objLetter->setName(Letter::C_STR_LETTER_NAME_PREFIX . $l_intIndexMask);
			$l_objLetter->setNumber($l_intIndexMask);
				
			// if word is visible
			if ($i_blnVisible) {
				// set the also the real value
				$l_objLetter->setValue($l_strCurrentLetter);
			}
			
			// if word is in input mode and this is the first letter
			if ($i_objWord->getInputmode() && $l_intIndexWord == 0) {
			    // set the autofocus flag for this letter
			    $l_objLetter->setAutofocus(TRUE);
			}
			
			// put this letter in the object storage
			$l_objLetters->attach($l_objLetter);
			
			// go to the next index
			$l_intIndexMask++;
			$l_intIndexWord += $l_intCurrentLength;
			
			// wenn end of the word is reached
			if (strlen($i_objWord->getValue()) <= $l_intIndexWord) {
				// set the flag for the last letter
				$l_objLetter->setLast(TRUE);
			    $l_blnIsEnd = TRUE;
			}
		}
		
		// return the letters
		return $l_objLetters;
	}
	
	
	/**
	 * returns the length of the edit mask
	 * @param string $i_strMask
	 * @return integer
	 */
	protected function getLenghtOfMask($i_strMask) {
		
		// if edit mask is empty
		if ($i_strMask == '0') {
		    return 0;
		
		// if there exists an edit mask
		} else {
			return strlen($i_strMask);
		}
	}
	

	/**
	 * Check if a special value already exists in the additional header data
	 * @param 	array 	$i_arrAdditionalHeaderData	The array with all additional header datas
	 * @param 	string 	$i_strValue					The value vor which we should search
	 * @return	boolean								True if we have found the value
	 */
	protected function existAdditionalHeaderData($i_arrAdditionalHeaderData, $i_strValue) {
		// one line in the header data
		$l_strHeaderLine = '';
		// the returning value
		$l_blnReturn = FALSE;
	
		// go through every line of the additional header data
		foreach ($i_arrAdditionalHeaderData as $l_strHeaderLine) {
			if (strpos($l_strHeaderLine, $i_strValue) == TRUE) {
				$l_blnReturn = TRUE;
				break 1;
			}
		}
	
		// return the result
		return $l_blnReturn;
	}
	
	/**
	 * Check the morphing game for errors
	 * @param \Loss\Glmorphquiz\Domain\Model\MorphQuiz $i_objMorphGame
	 * @return string 	Error message, empty if there is nor error
	 */
	protected function checkMorphQuiz(\Loss\Glmorphquiz\Domain\Model\MorphQuiz $i_objMorphGame) {

		// one word of the quiz
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = NULL;
		// the word bevore
		/* @var $l_objWordBevore \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWordBevore = NULL;
		
		// a letter object
		/* @var $l_objLetter \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter = NULL;
		
		
		// the letter count of the last word
		$l_intLetterCount = 0;
		// letter count of the current word
		$l_intCurrentLetterCount = 0;
		// count of different letters
		$l_intDifferenceCount = 0;
		// the error text
		$l_strErrorText = '';
		
		// go throug every word of the morphing quiz game
		foreach ($i_objMorphGame->getWords() as $l_objWord) {
		    $l_intCurrentLetterCount = 0;
		    
		    // go through every letter of the word
		    foreach ($l_objWord->getLetters() as $l_objLetter) {
		        // count the letters
		        $l_intCurrentLetterCount++;
		    }
		    
		    // if the word has no letters at all
		    if ($l_intCurrentLetterCount === 0) {
		    	
		    	// The word with the name '%s' and the uid '%s' has no word defined.
				$l_strErrorText = LocalizationUtility::translate('frontend_zero_length_word', 
																  self::c_strExtensionName,
																  array($l_objWord->getName(),
																   	    $l_objWord->getUid())
						   										 );
				// return the error message
				return $l_strErrorText;
		    }
		    
		    // if this is the first word
		    if ($l_intLetterCount === 0) {
		        $l_intLetterCount = $l_intCurrentLetterCount;
		    
		    // for all other words, we need the same lenght
		    // so if there is an other length
		    } else if ($l_intLetterCount <> $l_intCurrentLetterCount) {
		    	
		    	// The word with the name "%s" and the UID "%s" has another length (%s) then the word before with the 
		    	// name "%s" and the UID "%s" with length %s. It must have all words the same length.
		    	$l_strErrorText = LocalizationUtility::translate('frontend_other_length_word',
												    			  self::c_strExtensionName,
																  array($l_objWord->getName(),
																  	    $l_objWord->getUid(),
																  		$l_intCurrentLetterCount,
																  		$l_objWordBevore->getName(),
																  		$l_objWordBevore->getUid(),
																  		$l_intLetterCount
																  )
						   										 );
		    	// return the error message
		    	return $l_strErrorText;
		    }
		    
		    // if this is not the turn with the first word
		    if ($l_objWordBevore !== NULL) {
		    	
		    	// get the count of the different letters
		    	$l_intDifferenceCount = $i_objMorphGame->check4letterChangings($l_objWordBevore, $l_objWord);
		    	
		    	// if there is not a difference of exactly one letter between the words
		        if ($l_intDifferenceCount <> 1) {
		            // Between the word with the name "%s" and the UID "%s" and the word with the 
		            // name "%s" and the UID "%s" is not exactly one letter difference. There are 
		            // %s letters different between "%s" and "%s". 
		            // Please correct this issue.
			    	$l_strErrorText = LocalizationUtility::translate('frontend_letter_changings',
													    			  self::c_strExtensionName,
																	  array($l_objWord->getName(),
																	  	    $l_objWord->getUid(),
																	  		$l_objWordBevore->getName(),
																	  		$l_objWordBevore->getUid(),
																	  		$l_intDifferenceCount,
																	  		$l_objWord->getValue(),
																	  		$l_objWordBevore->getValue()
																	  )
							   										 );
			    	// return the error message
			    	return $l_strErrorText;
		        }
		    }
		    
		    $l_objWordBevore = $l_objWord;
		}
	}
	
	/**
	 * Set the overall width of the collumns
	 * @param \Loss\Glmorphquiz\Domain\Model\MorphQuiz $i_objMorphQuiz
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $i_objLetters
	 */
	protected function setOverallColWidth(\Loss\Glmorphquiz\Domain\Model\MorphQuiz $i_objMorphQuiz, 
										  \TYPO3\CMS\Extbase\Persistence\ObjectStorage $i_objLetters) {
	
		
		// a letter object
		/* @var $l_objLetter \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter = NULL;
		// index of the collumn
		$l_intColIndex = 0;
		// temporary collumn width array
		$l_arrColWidth = array();

		
		foreach ($i_objLetters as $l_objLetter) {
			
			// if this is the first time for this collumn
			if (!isset($i_objMorphQuiz->getColWidth()[$l_intColIndex])) {
				// initialize the entry for this collumn
				$l_arrColWidth = $i_objMorphQuiz->getColWidth();
				$l_arrColWidth[] = 0;
				$i_objMorphQuiz->setColWidth($l_arrColWidth);
			}
			
			// if the current length is bigger then the length in the morphing game
			if ($l_objLetter->getWidthBox() > $i_objMorphQuiz->getColWidth()[$l_intColIndex]) {
			    // then set this width for the overall width
				$l_arrColWidth = $i_objMorphQuiz->getColWidth();
				$l_arrColWidth[$l_intColIndex] = $l_objLetter->getWidthBox();
				$i_objMorphQuiz->setColWidth($l_arrColWidth);
			}
			
			$l_intColIndex++;
		}
	}
	
	/**
	 * Sets the margin-right propterty to come to the overall collumn width for all letters
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $i_objWords
	 * @param \Loss\Glmorphquiz\Domain\Model\MorphQuiz $i_objMorphQuiz
	 */
	protected function setMargin4Letters(	\TYPO3\CMS\Extbase\Persistence\ObjectStorage $i_objWords, 
											 	\Loss\Glmorphquiz\Domain\Model\MorphQuiz $i_objMorphQuiz) {
		// one single word object
		/* @var $l_objWord \Loss\Glmorphquiz\Domain\Model\Word */
		$l_objWord = NULL;
		// a letter object
		/* @var $l_objLetter \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter = NULL;
		// index of the collumn
		$l_intColIndex = 0;
		
		// go through every word
		foreach ($i_objWords as $l_objWord) {

			// initialize collumn index
			$l_intColIndex = 0;
		    // go through every letter
		    foreach ($l_objWord->getLetters() as $l_objLetter) {
		    	
		    	// set the margin-right property
		    	// overal collumn width - width of the box of the current letter 
		    	$l_objLetter->setMarginRight(
		    			$i_objMorphQuiz->getColWidth()[$l_intColIndex] - $l_objLetter->getWidthBox());
		    	
		    	$l_intColIndex++;
		    }
		}
	}

	/**
	 * Returns the finishingtext
	 *
	 * @param \Loss\Glmorphquiz\Domain\Model\MorphQuiz $i_objMorphingQuizData The context of the game.
	 * @return string The finishingtext
	 */
	public function getFinishingtext(\Loss\Glmorphquiz\Domain\Model\MorphQuiz $i_objMorphingQuizData){
	
		// the returning ObjectStorage
		/* @var $l_objObjectStorage  \TYPO3\CMS\Extbase\Persistence\ObjectStorage */
		$l_objObjectStorage = NULL;
	
		$l_objObjectStorage = $this->m_objFinishingtextRepository->getFinishingtexts($this->settings['has_finishtext']);
	
		// The current finishingtext object
		/* @var $l_objFinishingText \Loss\Glmorphquiz\Domain\Model\Finishingtext */
		$l_objFinishingText = null;
	
		// The returning finishingtext object
		/* @var $l_objFinishingText \Loss\Glmorphquiz\Domain\Model\Finishingtext */
		$l_objRetFinishingText = null;
	
		// go through every finaltext
		foreach ($l_objObjectStorage as $l_objFinishingText) {
			// if the minimum points are reached
			if ($l_objFinishingText->getMinpoints() <= $i_objMorphingQuizData->getScore()) {
				// if this is the first finishing text
				if ($l_objRetFinishingText === NULL) {
					$l_objRetFinishingText = $l_objFinishingText;
	
					// if the current finishing text has a lower min. point score
				} elseif ( $l_objRetFinishingText->getMinpoints() < $l_objFinishingText->getMinpoints() ) {
					$l_objRetFinishingText = $l_objFinishingText;
				}
			}
		}
	
		// if we have found no finishing text
		if ($l_objRetFinishingText === NULL) {
				
			// return the default text
			return LocalizationUtility::translate( 'frontend_default_finishingtext',
					MorphingQuizController::c_strExtensionName );
	
			// if we have found a finishingtext
		} else {
			// return this text
			return $l_objRetFinishingText->getText();
		}
	}
}

?>