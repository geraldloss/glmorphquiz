<?php
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'glmorphquiz',
    'Pi1',
    'Morphing Quiz'
    );

// insert flexform for plugin pi1
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['glmorphquiz_pi1'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'glmorphquiz_pi1', 
    'FILE:EXT:glmorphquiz/Configuration/FlexForms/MorphQuiz.xml'
);

