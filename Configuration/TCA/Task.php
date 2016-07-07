<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_pmtodo_domain_model_task'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_pmtodo_domain_model_task']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, startdate, enddate, description, files, todos',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, startdate, enddate, description;;;richtext:rte_transform[mode=ts_links], files, todos, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_pmtodo_domain_model_task',
				'foreign_table_where' => 'AND tx_pmtodo_domain_model_task.pid=###CURRENT_PID### AND tx_pmtodo_domain_model_task.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pmtodo/Resources/Private/Language/locallang_db.xlf:tx_pmtodo_domain_model_task.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
        'username' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:pmtodo/Resources/Private/Language/locallang_db.xlf:tx_pmtodo_domain_model_task.username',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
		'startdate' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pmtodo/Resources/Private/Language/locallang_db.xlf:tx_pmtodo_domain_model_task.startdate',
			'config' => array(
				'dbType' => 'datetime',
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => '0000-00-00 00:00:00'
			),
		),
		'enddate' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pmtodo/Resources/Private/Language/locallang_db.xlf:tx_pmtodo_domain_model_task.enddate',
			'config' => array(
				'dbType' => 'datetime',
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => '0000-00-00 00:00:00'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pmtodo/Resources/Private/Language/locallang_db.xlf:tx_pmtodo_domain_model_task.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'script' => 'wizard_rte.php',
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
		),
        'files' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:pmtodo/Resources/Private/Language/locallang_db.xlf:tx_pmtodo_domain_model_task.files',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
		'todos' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pmtodo/Resources/Private/Language/locallang_db.xlf:tx_pmtodo_domain_model_task.todos',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_pmtodo_domain_model_todo',
				'foreign_field' => 'task',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		
		'project' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
        'status' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:pmtodo/Resources/Private/Language/locallang_db.xlf:tx_pmtodo_domain_model_task.status',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
	),
);
