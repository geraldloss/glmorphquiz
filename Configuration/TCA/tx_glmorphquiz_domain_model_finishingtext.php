<?php
if (!defined('TYPO3')) {
    die('Do not access the file tx_glmorphquiz_domain_model_finishingtext.php directly.');
}


$tx_glmorphquiz_domain_model_finishingtext = array(
    'ctrl' => array(
        'title'	=> 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_finishingtext',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'minpoints,text,',
        'iconfile' => 'EXT:glmorphquiz/Resources/Public/Icons/tx_glmorphquiz_domain_model_finishingtext.gif',
        'security' => [
            'ignoreRootLevel' => 1
        ],
    ),
	'types' => array(
	    '1' => array(  'showitem' => 'hidden,--palette--;;1, name, minpoints, text,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'
	   ),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
//      for Typo3 11.5 switch to this syntax. But in the moment it breakks with 10.4
// 		'sys_language_uid' => array(
// 			'exclude' => 1,
// 			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
// 		    'config' => array(
// 		        'type'       => 'language',
// 		    ),
// 		),
	    'sys_language_uid' => array(
	        'exclude' => 1,
	        'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
	        'config' => array(
	            'type' => 'select',
	            'foreign_table' => 'sys_language',
	            'foreign_table_where' => 'ORDER BY sys_language.title',
	            'renderType' => 'selectSingle',
	            'items' => array(
	                array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1),
	                array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0),
	            ),
	            'default' => 0
	        ),
	    ),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
			    'type' => 'select',
			    'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_glmorphquiz_domain_model_finishingtext',
				'foreign_table_where' => 'AND tx_glmorphquiz_domain_model_finishingtext.pid=###CURRENT_PID### AND tx_glmorphquiz_domain_model_finishingtext.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime,int',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			    'behaviour' => array(
			        'allowLanguageSynchronization' => TRUE
			    ),
			    'renderType' => 'inputDateTime',
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime,int',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			    'behaviour' => array(
			        'allowLanguageSynchronization' => TRUE
			    ),
			    'renderType' => 'inputDateTime',
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_finishingtext.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),	
		'minpoints' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_finishingtext.minpoints',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'text' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_finishingtext.text',
			'config' => array(
				'type' => 'text',
			    'enableRichtext' => true,
				'cols' => 40,
				'rows' => 15,
			),
		),
	),
);


return $tx_glmorphquiz_domain_model_finishingtext;
?>