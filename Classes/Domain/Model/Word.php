<?php
namespace Loss\Glmorphquiz\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;

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
 * A single word of the morphing quiz game
 */
class Word extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The name of the word for internal use
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage	 
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $m_objLetters = NULL;
	
	/**
	 * The name of the word for internal use
	 *
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $name = '';

	/**
	 * the word itself
	 *
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $value = '';

	/**
	 * The previous word bevore this
	 *
	 * @var integer
	 * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
	 */
	protected $nextWord = 0;
	
	
	/**
	 * The previous word bevore this
	 *
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("String")
	 */
	protected $mask = 0;
	
	/**
	 * Fontsize
	 *
	 * @var integer
	 * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
	 */
	protected $fontsize = 0;
	
	/**
	 * Height of a letter 
	 *
	 * @var integer
	 * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
	 */
	protected $height_letter = 0;
	
	
	/**
	 * Width of a letter 
	 *
	 * @var integer
	 * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
	 */
	protected $width_letter = 0;
	
	
	/**
	 * Offset of the width of a letter 
	 *
	 * @var integer
	 * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
	 */
	protected $width_letter_offset = 0;
	
	/**
	 * Points for correct answer 
	 *
	 * @var integer
	 * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
	 */
	protected $points = 0;
	
	/**
	 * Input mode of the word.
	 *
	 * @var boolean
	 */
	protected $m_bln_inputmode = FALSE;
	

	/**
	 * Animation speed 
	 *
	 * @var integer
	 * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
	 */
	protected $animation_speed = 0;
	
	
//	**************************************************************************************************
	
	/**
	* Returns the m_objLetters
	*
	* @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $m_objLetters
	*/
	public function getLetters(){
		return $this->m_objLetters;
	}
	
	/**
	* Sets the m_objLetters
	*
	* @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $m_objLetters
	* @return void
	*/
	public function setLetters(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $i_objLetters){
		$this->m_objLetters = $i_objLetters;
	}
	
	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the value
	 *
	 * @return string $value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Sets the value
	 *
	 * @param string $value
	 * @return void
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * Returns the nextWord
	 *
	 * @return integer $nextWord
	 */
	public function getNextWord() {
		return $this->nextWord;
	}

	/**
	 * Sets the nextWord
	 *
	 * @param integer $nextWord
	 * @return void
	 */
	public function setNextWord($nextWord) {
		$this->nextWord = $nextWord;
	}
	
	
	/**
	* Sets the mask
	*
	* @param string $mask
	* @return void
	*/
	public function setMask($mask){
		$this->mask = $mask;
	}
	
	/**
	* Returns the mask
	*
	* @return string $mask
	*/
	public function getMask(){
		return $this->mask;
	}
	
	/**
	* Sets the fontsize
	*
	* @param integer $fontsize
	* @return void
	*/
	public function setFontsize($fontsize){
		$this->fontsize = $fontsize;
	}
	
	/**
	* Returns the fontsize
	*
	* @return integer $fontsize
	*/
	public function getFontsize(){
		return $this->fontsize;
	}
	
	/**
	* Sets the heigth_letter
	*
	* @param integer $heigth_letter
	* @return void
	*/
	public function setHeight_letter($height_letter){
		$this->height_letter = $height_letter;
	}
	
	/**
	* Returns the heigth_letter
	*
	* @return integer $heigth_letter
	*/
	public function getHeight_letter(){
		return $this->height_letter;
	}
	
	/**
	 * Points for wrong answer 
	 *
	 * @var integer
	 */
	protected $minus_points = 0;
	
	/**
	* Sets the width_letter
	*
	* @param integer $width_letter
	* @return void
	*/
	public function setWidth_letter($width_letter){
		$this->width_letter = $width_letter;
	}
	
	/**
	* Returns the width_letter
	*
	* @return integer $width_letter
	*/
	public function getWidth_letter(){
		return $this->width_letter;
	}
	
	/**
	* Sets the width_letter_offset
	*
	* @param integer $width_letter_offset
	* @return void
	*/
	public function setWidth_letter_offset($width_letter_offset){
		$this->width_letter_offset = $width_letter_offset;
	}
	
	/**
	* Returns the width_letter_offset
	*
	* @return integer $width_letter_offset
	*/
	public function getWidth_letter_offset(){
		return $this->width_letter_offset;
	}
	
	/**
	* Sets the points
	*
	* @param integer $points
	* @return void
	*/
	public function setPoints($points){
		$this->points = $points;
	}
	
	/**
	* Returns the points
	*
	* @return integer $points
	*/
	public function getPoints(){
		return $this->points;
	}
	
	/**
	* Sets the minus_points
	*
	* @param integer $minus_points
	* @return void
	*/
	public function setMinus_points($minus_points){
		$this->minus_points = $minus_points;
	}
	
	/**
	* Returns the minus_points
	*
	* @return integer $minus_points
	*/
	public function getMinus_points(){
		return $this->minus_points;
	}
	
	/**
	* Sets the m_bln_inputmode
	*
	* @param boolean $m_bln_inputmode
	* @return void
	*/
	public function setInputmode($i_bln_inputmode){
		$this->m_bln_inputmode = $i_bln_inputmode;
	}
	
	/**
	* Returns the m_bln_inputmode
	*
	* @return boolean $m_bln_inputmode
	*/
	public function getInputmode(){
		return $this->m_bln_inputmode;
	}

	/**
	* Sets the animation_speed
	*
	* @param integer $animation_speed
	* @return void
	*/
	public function setAnimation_speed($animation_speed){
		$this->animation_speed = $animation_speed;
	}
	
	/**
	* Returns the animation_speed
	*
	* @return integer $animation_speed
	*/
	public function getAnimation_speed(){
		return $this->animation_speed;
	}

	/**
	 * Returns a letter of the word by an index
	 * @param integer $i_intIndex
	 * @return \Loss\Glmorphquiz\Domain\Model\Letter
	 */
	public function getLetterByIndex($i_intIndex) {
	
		// the returnung letter
		/* @var $l_objLetter1 \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter = NULL;
		// the current index
		$l_intCurrentIndex = 0;
	
		foreach ($this->getLetters() as $l_objLetter) {
				
			// if this is the demanded index
			if ($l_intCurrentIndex == $i_intIndex) {
				// return the letter
				return $l_objLetter;
			}
				
			$l_intCurrentIndex++;
		}
	
		return NULL;
	}
}

?>