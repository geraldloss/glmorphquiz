<?php
namespace Loss\Glmorphquiz\Domain\Model;


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
class Letter {

	const C_STR_LETTER_NAME_PREFIX = 'letter';
	
	/**
	 * The word of the letter
	 *
	 * @var \Loss\Glmorphquiz\Domain\Model\Word
	 */
	protected $m_objWord = NULL;
	
	/**
	 * Value of the letter
	 *
	 * @var string
	 */
	protected $m_strValue = '';
	
	/**
	 * The correct Value of the letter
	 *
	 * @var string
	 */
	protected $m_strCorrectValue = '';

	/**
	 * Length of the letter
	 *
	 * @var integer
	 */
	protected $m_intLength = 0;
	
	/**
	 * Letter gets the autofocus
	 *
	 * @var boolean
	 */
	protected $m_blnAutofocus = FALSE;
	
	
	/**
	 * Name of the letter
	 *
	 * @var string
	 */
	protected $m_strName = '';
	
	
	/**
	 * The margin on the right side, if the overall width of a collumn 
	 * is wider than the current width.
	 *
	 * @var integer
	 */
	protected $m_intMarginRight = 0;
	
	/**
	 * True if this is the last letter of the word
	 * 
	 * @var boolean
	 */
	protected $m_blnLast = FALSE;
	
	/**
	 * Number of this letter.
	 * 
	 * @var integer
	 */
	protected $m_intNumber = 0;
	
// ****************************************************************

	/**
	* Sets the m_strValue
	*
	* @param string $i_strValue
	* @return void
	*/
	public function setValue($i_strValue){
		$this->m_strValue = $i_strValue;
	}
	
	/**
	* Returns the m_strValue
	*
	* @return string $m_strValue
	*/
	public function getValue(){
		return $this->m_strValue;
	}
	
	/**
	* Sets the m_intLength
	*
	* @param integer $i_intLength
	* @return void
	*/
	public function setLength($i_intLength){
		$this->m_intLength = $i_intLength;
	}
	
	/**
	* Returns the m_intLength
	*
	* @return integer $m_intLength
	*/
	public function getLength(){
		return $this->m_intLength;
	}
	
	/**
	* Sets the m_blnAutofocus
	*
	* @param boolean $i_blnAutofocus
	* @return void
	*/
	public function setAutofocus($i_blnAutofocus){
		$this->m_blnAutofocus = $i_blnAutofocus;
	}
	
	/**
	* Returns the m_blnAutofocus
	*
	* @return boolean $m_blnAutofocus
	*/
	public function getAutofocus(){
		return $this->m_blnAutofocus;
	}
	
	/**
	* Sets the m_strCorrectValue
	*
	* @param string $i_strCorrectValue
	* @return void
	*/
	public function setCorrectValue($i_strCorrectValue){
		$this->m_strCorrectValue = $i_strCorrectValue;
	}
	
	/**
	* Returns the m_strCorrectValue
	*
	* @return string $m_strCorrectValue
	*/
	public function getCorrectValue(){
		return $this->m_strCorrectValue;
	}
	
	/**
	* Sets the m_strName
	*
	* @param string $i_strName
	* @return void
	*/
	public function setName($i_strName){
		$this->m_strName = $i_strName;
	}
	
	/**
	* Returns the m_strName
	*
	* @return string $m_strName
	*/
	public function getName(){
		return $this->m_strName;
	}
	
	/**
	* Sets the m_objWord
	*
	* @param \Loss\Glmorphquiz\Domain\Model\Word $i_objWord
	* @return void
	*/
	public function setWord($i_objWord){
		$this->m_objWord = $i_objWord;
	}
	
	/**
	* Returns the m_objWord
	*
	* @return \Loss\Glmorphquiz\Domain\Model\Word $m_objWord
	*/
	public function getWord(){
		return $this->m_objWord;
	}
	
	/**
	 * Get the width of the Input box of the letter
	 */
	public function getWidthBox() {
		// Offset + (count of letters * width of letters)
		return $this->m_objWord->getWidth_letter_offset() + 
			   ($this->m_intLength * $this->getWord()->getWidth_letter());
	}
	
	
	/**
	* Sets the m_intMarginRight
	*
	* @param integer $i_intMarginRight
	* @return void
	*/
	public function setMarginRight($i_intMarginRight){
		$this->m_intMarginRight = $i_intMarginRight;
	}
	
	/**
	* Returns the i_intMarginRight
	*
	* @return integer $i_intMarginRight
	*/
	public function getMarginRight(){
		return $this->m_intMarginRight;
	}
	
	/**
	* Sets the m_blnLast
	*
	* @param boolean $i_blnLast
	* @return void
	*/
	public function setLast($i_blnLast){
		$this->m_blnLast = $i_blnLast;
	}
	
	/**
	* Returns the m_blnLast
	*
	* @return boolean
	*/
	public function getLast(){
		return $this->m_blnLast;
	}
	
	/**
	 * Returns the javascript call for the key down event
	 * @return string
	 */
	public function getOnKeyDown() {
		
		// the returning string
		$lv_strReturn = '';
		
		// only if we are in input mode
		// and this is not the last letter
		if ($this->getWord()->getInputmode() ){
//			&& !$this->getLast()) {
		    
			$lv_strReturn = "onKeyDown=\"glmorphKeyDown(event, 'tx_glmorphquiz_pi1[" . $this->getName() . "]')\"";
		}
		return $lv_strReturn;
	}
	
	/**
	 * Returns the javascript call for the key up event
	 * @return string
	 */
	public function getOnKeyUp() {
		// the returning string
		$lv_strReturn = '';
		
		// only if we are in input mode
		// and this is not the last letter
		if ($this->getWord()->getInputmode() ){
//			&& !$this->getLast()) {
		    
			$lv_strReturn = "onKeyUp=\"glmorphKeyUp(event, 'tx_glmorphquiz_pi1[" . $this->getName() . "]'";
			$lv_strReturn = $lv_strReturn . ", 'tx_glmorphquiz_pi1[" . $this->getNextName() . "]'";
			$lv_strReturn = $lv_strReturn . ", 'tx_glmorphquiz_pi1[" . $this->getBevoreName() . "]')\"";
		}
		return $lv_strReturn;
	}
	
	/**
	 * Returns javascript call for onkeypress event
	 */
	public function getOnKeyPress() {
		return "onkeypress=\"glmorphKeyPress(event)\"";
	}
	
	/**
	 * returns the name of the next letter.
	 * @return string
	 */
	public function getNextName() {
		// the number at the end
		$lv_intNumber = 0;
		
		$lv_intNumber = $this->getNumber() + 1;
		return Letter::C_STR_LETTER_NAME_PREFIX . $lv_intNumber;
	}
	
	/**
	 * returns the name of the letter bevore.
	 * @return string
	 */
	public function getBevoreName() {
		// the number at the end
		$lv_intNumber = 0;
		
		$lv_intNumber = $this->getNumber() - 1;
		return Letter::C_STR_LETTER_NAME_PREFIX . $lv_intNumber;
	}
	
	/**
	* Sets the m_intNumber
	*
	* @param integer $i_intNumber
	* @return void
	*/
	public function setNumber($i_intNumber){
		$this->m_intNumber = $i_intNumber;
	}
	
	/**
	* Returns the m_intNumber
	*
	* @return integer
	*/
	public function getNumber(){
		return $this->m_intNumber;
	}
	
}

?>