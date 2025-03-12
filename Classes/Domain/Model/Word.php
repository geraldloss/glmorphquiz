<?php
declare(strict_types=1);
namespace Loss\Glmorphquiz\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
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
 * A single word of the morphing quiz game
 */
class Word extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The name of the word for internal use
	 *
	 * @var ObjectStorage<\Loss\Glmorphquiz\Domain\Model\Letter>
	 * @Validate("NotEmpty")
	 */
	protected ObjectStorage $m_objLetters;
	
	/**
	 * The name of the word for internal use
	 *
	 * @var string
	 * @Validate("NotEmpty")
	 */
	protected string $name = '';

	/**
	 * The word itself
	 *
	 * @var string
	 * @Validate("NotEmpty")
	 */
	protected string $value = '';

	/**
	 * The next word after this
	 *
	 * @var int
	 * @Validate("Integer")
	 */
	protected int $nextWord = 0;
	
	/**
	 * The mask of the word
	 *
	 * @var string
	 * @Validate("String")
	 */
	protected string $mask = '';
	
	/**
	 * Font size
	 *
	 * @var int
	 * @Validate("Integer")
	 */
	protected int $fontsize = 0;
	
	/**
	 * Height of a letter 
	 *
	 * @var int
	 * @Validate("Integer")
	 */
	protected int $height_letter = 0;
	
	/**
	 * Width of a letter 
	 *
	 * @var int
	 * @Validate("Integer")
	 */
	protected int $width_letter = 0;
	
	/**
	 * Offset of the width of a letter 
	 *
	 * @var int
	 * @Validate("Integer")
	 */
	protected int $width_letter_offset = 0;
	
	/**
	 * Points for correct answer 
	 *
	 * @var int
	 * @Validate("Integer")
	 */
	protected int $points = 0;
	
	/**
	 * Input mode of the word.
	 *
	 * @var bool
	 */
	protected bool $m_bln_inputmode = false;
	
	/**
	 * Animation speed 
	 *
	 * @var int
	 * @Validate("Integer")
	 */
	protected int $animation_speed = 0;
	
	/**
	 * Points for wrong answer 
	 *
	 * @var int
	 */
	protected int $minus_points = 0;
	
//	**************************************************************************************************
	
	/**
	* Returns the m_objLetters
	*
	* @return ObjectStorage<\Loss\Glmorphquiz\Domain\Model\Letter>
	*/
	public function getLetters(): ObjectStorage {
		return $this->m_objLetters;
	}
	
	/**
	* Sets the m_objLetters
	*
	* @param ObjectStorage<\Loss\Glmorphquiz\Domain\Model\Letter> $i_objLetters
	* @return void
	*/
	public function setLetters(ObjectStorage $i_objLetters): void {
		$this->m_objLetters = $i_objLetters;
	}
	
	/**
	 * Returns the name
	 *
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName(string $name): void {
		$this->name = $name;
	}

	/**
	 * Returns the value
	 *
	 * @return string
	 */
	public function getValue(): string {
		return $this->value;
	}

	/**
	 * Sets the value
	 *
	 * @param string $value
	 * @return void
	 */
	public function setValue(string $value): void {
		$this->value = $value;
	}

	/**
	 * Returns the nextWord
	 *
	 * @return int
	 */
	public function getNextWord(): int {
		return $this->nextWord;
	}

	/**
	 * Sets the nextWord
	 *
	 * @param int $nextWord
	 * @return void
	 */
	public function setNextWord(int $nextWord): void {
		$this->nextWord = $nextWord;
	}
	
	/**
	* Sets the mask
	*
	* @param string $mask
	* @return void
	*/
	public function setMask(string $mask): void {
		$this->mask = $mask;
	}
	
	/**
	* Returns the mask
	*
	* @return string
	*/
	public function getMask(): string {
		return $this->mask;
	}
	
	/**
	* Sets the fontsize
	*
	* @param int $fontsize
	* @return void
	*/
	public function setFontsize(int $fontsize): void {
		$this->fontsize = $fontsize;
	}
	
	/**
	* Returns the fontsize
	*
	* @return int
	*/
	public function getFontsize(): int {
		return $this->fontsize;
	}
	
	/**
	* Sets the height_letter
	*
	* @param int $height_letter
	* @return void
	*/
	public function setHeight_letter(int $height_letter): void {
		$this->height_letter = $height_letter;
	}
	
	/**
	* Returns the height_letter
	*
	* @return int
	*/
	public function getHeight_letter(): int {
		return $this->height_letter;
	}
	
	/**
	* Sets the width_letter
	*
	* @param int $width_letter
	* @return void
	*/
	public function setWidth_letter(int $width_letter): void {
		$this->width_letter = $width_letter;
	}
	
	/**
	* Returns the width_letter
	*
	* @return int
	*/
	public function getWidth_letter(): int {
		return $this->width_letter;
	}
	
	/**
	* Sets the width_letter_offset
	*
	* @param int $width_letter_offset
	* @return void
	*/
	public function setWidth_letter_offset(int $width_letter_offset): void {
		$this->width_letter_offset = $width_letter_offset;
	}
	
	/**
	* Returns the width_letter_offset
	*
	* @return int
	*/
	public function getWidth_letter_offset(): int {
		return $this->width_letter_offset;
	}
	
	/**
	* Sets the points
	*
	* @param int $points
	* @return void
	*/
	public function setPoints(int $points): void {
		$this->points = $points;
	}
	
	/**
	* Returns the points
	*
	* @return int
	*/
	public function getPoints(): int {
		return $this->points;
	}
	
	/**
	* Sets the minus_points
	*
	* @param int $minus_points
	* @return void
	*/
	public function setMinus_points(int $minus_points): void {
		$this->minus_points = $minus_points;
	}
	
	/**
	* Returns the minus_points
	*
	* @return int
	*/
	public function getMinus_points(): int {
		return $this->minus_points;
	}
	
	/**
	* Sets the m_bln_inputmode
	*
	* @param bool $i_bln_inputmode
	* @return void
	*/
	public function setInputmode(bool $i_bln_inputmode): void {
		$this->m_bln_inputmode = $i_bln_inputmode;
	}
	
	/**
	* Returns the m_bln_inputmode
	*
	* @return bool
	*/
	public function getInputmode(): bool {
		return $this->m_bln_inputmode;
	}

	/**
	* Sets the animation_speed
	*
	* @param int $animation_speed
	* @return void
	*/
	public function setAnimation_speed(int $animation_speed): void {
		$this->animation_speed = $animation_speed;
	}
	
	/**
	* Returns the animation_speed
	*
	* @return int
	*/
	public function getAnimation_speed(): int {
		return $this->animation_speed;
	}

	/**
	 * Returns a letter of the word by an index
	 * @param int $i_intIndex
	 * @return \Loss\Glmorphquiz\Domain\Model\Letter|null
	 */
	public function getLetterByIndex(int $i_intIndex): ?\Loss\Glmorphquiz\Domain\Model\Letter {
	
		// the returning letter
		/* @var $l_objLetter \Loss\Glmorphquiz\Domain\Model\Letter */
		$l_objLetter = null;
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
	
		return null;
	}
}

?>