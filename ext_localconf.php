<?php
if (!defined('TYPO3')) {
    die('Do not access the file ext_localconf.php directly.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Glmorphquiz',
	'Pi1',
	[
		\Loss\Glmorphquiz\Controller\MorphingQuizController::class => 'list,response',
		
	],
	// non-cacheable actions
	[
	    \Loss\Glmorphquiz\Controller\MorphingQuizController::class => 'list,response',	
	]
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