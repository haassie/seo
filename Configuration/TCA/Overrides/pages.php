<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$ll = 'LLL:EXT:core_seo/Resources/Private/Language/locallang_db.xlf:';
$temporaryColumns = [
    'seo_title' => [
        'exclude' => 1,
        'label' => $ll.'pages.seo_title',
        'config' => [
            'type' => 'input'
        ],
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages',
    $temporaryColumns
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;' . $ll . 'pages.tabs.seo, seo_title',
    '',
    'after:subtitle'
);
