<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$tx_glmorphquiz_domain_model_word = array(
    'ctrl' => array(
        'title'	=> 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'sortby' => 'sorting',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'name,value,next_word,',
        'iconfile' => 'EXT:glmorphquiz/Resources/Public/Icons/tx_glmorphquiz_domain_model_word.gif',
    ),
	'types' => array(
		'1' => array( 'showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, --palette--;;1, name, value, mask, next_word, 
									--div--;LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.tabpoints, points, minus_points,
		 							--div--;LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.tabadvanced, fontsize, heigth_letter, width_letter, width_letter_offset, animation_speed,
									--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime' ),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
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
					array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0)
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
				'foreign_table' => 'tx_glmorphquiz_domain_model_word',
				'foreign_table_where' => 'AND tx_glmorphquiz_domain_model_word.pid=###CURRENT_PID### AND tx_glmorphquiz_domain_model_word.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.value',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'required, trim, upper',
			),
		),
		'mask' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.mask',
			'config' => array(
				'type' => 'input',	
				'size' => '255',	
				'eval' => 'int',
			)
		),
		'next_word' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.next_word',
			'config' => array(
			'type' => 'select',
			'renderType' => 'selectSingle',
			'foreign_table' => 'tx_glmorphquiz_domain_model_word',
			'foreign_table_where' => 'AND tx_glmorphquiz_domain_model_word.uid<>###THIS_UID### ORDER BY name ASC',
			'size' => 1,
			'items' => array(
					array(
							'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.empty',
							0
					)
			),
			'maxitems' => 1,
			'default'  => 0
			)
		),
		'fontsize' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.fontsize',
			'config' => array(
					'type' => 'input',
					'size' => 4,
					'eval' => 'int',
					'default' => 0
			),
		),
		'heigth_letter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.heigth_letter',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
				'default' => 0
			),
		),
		'width_letter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.width_letter',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
				'default' => 0
			),
		),
		'width_letter_offset' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.width_letter_offset',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
				'default' => 0
			),
		),
		'firstcol_width' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.firstcol_width',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
				'default' => 0
			),
		),
		'arrow_width' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.arrow_width',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
				'default' => 0
			),
		),
		'animation_speed' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.animation_speed',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
				'default' => 0
			),
		),
		'points' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.points',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
				'default' => 0
			),
		),
		'minus_points' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:glmorphquiz/Resources/Private/Language/locallang_db.xlf:tx_glmorphquiz_domain_model_word.minus_points',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
				'default' => 0
			),
		),
	),
);

return $tx_glmorphquiz_domain_model_word;

?>