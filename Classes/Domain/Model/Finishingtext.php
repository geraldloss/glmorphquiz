<?php
declare(strict_types=1);
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
	 * @var int
	 * @Validate("Integer")
	 */
	protected int $minpoints;

	/**
	 * Text to be displayed if the minimum points are reached
	 *
	 * @var string
	 * @Validate("NotEmpty")
	 */
	protected string $text;

	/**
	 * Returns the minpoints
	 *
	 * @return int
	 */
	public function getMinpoints(): int {
		return $this->minpoints;
	}

	/**
	 * Sets the minpoints
	 *
	 * @param int $minpoints
	 * @return void
	 */
	public function setMinpoints(int $minpoints): void {
		$this->minpoints = $minpoints;
	}

	/**
	 * Returns the text
	 *
	 * @return string
	 */
	public function getText(): string {
		return $this->text;
	}

	/**
	 * Sets the text
	 *
	 * @param string $text
	 * @return void
	 */
	public function setText(string $text): void {
		$this->text = $text;
	}

}
?>