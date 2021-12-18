<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Loss.glmorphquiz',
	'Pi1',
	array(
	    \Loss\Glmorphquiz\Controller\MorphingQuizController::class => 'list,response',
		
	),
	// non-cacheable actions
	array(
	    \Loss\Glmorphquiz\Controller\MorphingQuizController::class => 'list,response',	
	)
);

// register new content element wizard
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:glmorphquiz/Configuration/TSconfig/ContentElementWizard.txt">
');

if (class_exists('TYPO3\\CMS\\Core\\Imaging\\IconRegistry')) {
    // Initiate
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'glmorphquiz-ext-icon',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' => 'EXT:glmorphquiz/Resources/Public/Icons/ext_icon.svg',
        ]
        );
}