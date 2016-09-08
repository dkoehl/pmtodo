<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Pmtodo.' . $_EXTKEY,
	'Pmtodo',
	array(
		'Project' => 'list, show, new, create, edit, update, delete',
		'Task' => 'new, create, uploadFiles, edit, update,resolved, delete, list, show',
		'Todo' => 'list,resolved, uploadFiles, show, new, create, edit, update, delete',
		
	),
	// non-cacheable actions
	array(
		'Project' => 'list, show, new, create, edit, update, delete',
		'Task' => 'new, create, uploadFiles, edit, update,resolved, delete, list, show',
		'Todo' => 'list,resolved, uploadFiles, show, new, create, edit, update, delete',
		
	)
);