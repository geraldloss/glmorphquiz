<?php
declare(strict_types=1);
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
	protected ?\Loss\Glmorphquiz\Domain\Model\Word $m_objWord = null;
	
	/**
	 * Value of the letter
	 *
	 * @var string
	 */
	protected string $m_strValue = '';
	
	/**
	 * The correct Value of the letter
	 *
	 * @var string
	 */
	protected string $m_strCorrectValue = '';

	/**
	 * Length of the letter
	 *
	 * @var int
	 */
	protected int $m_intLength = 0;
	
	/**
	 * Letter gets the autofocus
	 *
	 * @var bool
	 */
	protected bool $m_blnAutofocus = false;
	
	
	/**
	 * Name of the letter
	 *
	 * @var string
	 */
	protected string $m_strName = '';
	
	
	/**
	 * The margin on the right side, if the overall width of a collumn 
	 * is wider than the current width.
	 *
	 * @var int
	 */
	protected int $m_intMarginRight = 0;
	
	/**
	 * True if this is the last letter of the word
	 * 
	 * @var bool
	 */
	protected bool $m_blnLast = false;
	
	/**
	 * Number of this letter.
	 * 
	 * @var int
	 */
	protected int $m_intNumber = 0;
	
// ****************************************************************

	/**
	* Sets the m_strValue
	*
	* @param string $i_strValue
	* @return void
	*/
	public function setValue(string $i_strValue): void {
		$this->m_strValue = $i_strValue;
	}
	
	/**
	* Returns the m_strValue
	*
	* @return string
	*/
	public function getValue(): string {
		return $this->m_strValue;
	}
	
	/**
	* Sets the m_intLength
	*
	* @param int $i_intLength
	* @return void
	*/
	public function setLength(int $i_intLength): void {
		$this->m_intLength = $i_intLength;
	}
	
	/**
	* Returns the m_intLength
	*
	* @return int
	*/
	public function getLength(): int {
		return $this->m_intLength;
	}
	
	/**
	* Sets the m_blnAutofocus
	*
	* @param bool $i_blnAutofocus
	* @return void
	*/
	public function setAutofocus(bool $i_blnAutofocus): void {
		$this->m_blnAutofocus = $i_blnAutofocus;
	}
	
	/**
	* Returns the m_blnAutofocus
	*
	* @return bool
	*/
	public function getAutofocus(): bool {
		return $this->m_blnAutofocus;
	}
	
	/**
	* Sets the m_strCorrectValue
	*
	* @param string $i_strCorrectValue
	* @return void
	*/
	public function setCorrectValue(string $i_strCorrectValue): void {
		$this->m_strCorrectValue = $i_strCorrectValue;
	}
	
	/**
	* Returns the m_strCorrectValue
	*
	* @return string
	*/
	public function getCorrectValue(): string {
		return $this->m_strCorrectValue;
	}
	
	/**
	* Sets the m_strName
	*
	* @param string $i_strName
	* @return void
	*/
	public function setName(string $i_strName): void {
		$this->m_strName = $i_strName;
	}
	
	/**
	* Returns the m_strName
	*
	* @return string
	*/
	public function getName(): string {
		return $this->m_strName;
	}
	
	/**
	* Sets the m_objWord
	*
	* @param \Loss\Glmorphquiz\Domain\Model\Word $i_objWord
	* @return void
	*/
	public function setWord(\Loss\Glmorphquiz\Domain\Model\Word $i_objWord): void {
		$this->m_objWord = $i_objWord;
	}
	
	/**
	* Returns the m_objWord
	*
	* @return \Loss\Glmorphquiz\Domain\Model\Word|null
	*/
	public function getWord(): ?\Loss\Glmorphquiz\Domain\Model\Word {
		return $this->m_objWord;
	}
	
	/**
	 * Get the width of the Input box of the letter
	 *
	 * @return int
	 */
	public function getWidthBox(): int {
		// Offset + (count of letters * width of letters)
		return $this->m_objWord->getWidth_letter_offset() + 
			   ($this->m_intLength * $this->getWord()->getWidth_letter());
	}
	
	
	/**
	* Sets the m_intMarginRight
	*
	* @param int $i_intMarginRight
	* @return void
	*/
	public function setMarginRight(int $i_intMarginRight): void {
		$this->m_intMarginRight = $i_intMarginRight;
	}
	
	/**
	* Returns the i_intMarginRight
	*
	* @return int
	*/
	public function getMarginRight(): int {
		return $this->m_intMarginRight;
	}
	
	/**
	* Sets the m_blnLast
	*
	* @param bool $i_blnLast
	* @return void
	*/
	public function setLast(bool $i_blnLast): void {
		$this->m_blnLast = $i_blnLast;
	}
	
	/**
	* Returns the m_blnLast
	*
	* @return bool
	*/
	public function getLast(): bool {
		return $this->m_blnLast;
	}
	
	/**
	 * Returns the javascript call for the key down event
	 * @return string
	 */
	public function getOnKeyDown(): string {
		
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
	public function getOnKeyUp(): string {
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
	 *
	 * @return string
	 */
	public function getOnKeyPress(): string {
		return "onkeypress=\"glmorphKeyPress(event)\"";
	}
	
	/**
	 * returns the name of the next letter.
	 * @return string
	 */
	public function getNextName(): string {
		// the number at the end
		$lv_intNumber = 0;
		
		$lv_intNumber = $this->getNumber() + 1;
		return Letter::C_STR_LETTER_NAME_PREFIX . $lv_intNumber;
	}
	
	/**
	 * returns the name of the letter bevore.
	 * @return string
	 */
	public function getBevoreName(): string {
		// the number at the end
		$lv_intNumber = 0;
		
		$lv_intNumber = $this->getNumber() - 1;
		return Letter::C_STR_LETTER_NAME_PREFIX . $lv_intNumber;
	}
	
	/**
	* Sets the m_intNumber
	*
	* @param int $i_intNumber
	* @return void
	*/
	public function setNumber(int $i_intNumber): void {
		$this->m_intNumber = $i_intNumber;
	}
	
	/**
	* Returns the m_intNumber
	*
	* @return int
	*/
	public function getNumber(): int {
		return $this->m_intNumber;
	}
	
}

?>