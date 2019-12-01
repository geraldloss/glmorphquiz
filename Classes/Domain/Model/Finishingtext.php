<?php
namespace Loss\Glmorphquiz\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 
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
 * @package glmorphquiz
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Finishingtext extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * minimum points
	 *
	 * @var integer
	 * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
	 */
	protected $minpoints;

	/**
	 * Text to be displayed if the minimum points are reached
	 *
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $text;

	/**
	 * Returns the minpoints
	 *
	 * @return integer $minpoints
	 */
	public function getMinpoints() {
		return $this->minpoints;
	}

	/**
	 * Sets the minpoints
	 *
	 * @param integer $minpoints
	 * @return void
	 */
	public function setMinpoints($minpoints) {
		$this->minpoints = $minpoints;
	}

	/**
	 * Returns the text
	 *
	 * @return string $text
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Sets the text
	 *
	 * @param string $text
	 * @return void
	 */
	public function setText($text) {
		$this->text = $text;
	}

}
?>