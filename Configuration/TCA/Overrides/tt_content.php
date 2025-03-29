<?php
declare(strict_types=1);
defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// register frontend plugin morphquiz
ExtensionUtility::registerPlugin(
    'glmorphquiz',
    'morphquiz',
    'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang.xlf:plugin_name'
);

// insert flexform for plugin morphquiz
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['glmorphquiz_morphquiz'] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['glmorphquiz_morphquiz'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'glmorphquiz_morphquiz', 
    'FILE:EXT:glmorphquiz/Configuration/FlexForms/MorphQuiz.xml'
);

