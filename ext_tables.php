<?php
if (!defined('TYPO3')) {
    die('Do not access the file ext_tables.php directly.');
}

// Set new TCA option :php:`$GLOBALS['TCA'][$table]['ctrl']['security']['ignorePageTypeRestriction']` instead of ExtensionManagementUtility::allowTableOnStandardPages
// // for the model word
// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glmorphquiz_domain_model_word');

// // // for the model finishing text
// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glmorphquiz_domain_model_finishingtext');


// Context Sensitive Help is aimed to get removed in TYPO3 v13, no migration is available.

// // load CSH for flexform
// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
//     'tt_content.pi_flexform.glmorphquiz_pi1.list', 
//     'EXT:glmorphquiz/Resources/Private/Language/locallang_csh_flexForm.xlf'
// );

// for the model word
// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
//     'tx_glmorphquiz_domain_model_word', 
//     'EXT:glmorphquiz/Resources/Private/Language/locallang_csh_tx_glmorphquiz_domain_model_word.xlf'
// );

// // for the model finishing text
// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
//     'tx_glmorphquiz_domain_model_finishingtext', 
//     'EXT:glmorphquiz/Resources/Private/Language/locallang_csh_tx_glmorphquiz_domain_model_finishingtext.xlf'
// );
