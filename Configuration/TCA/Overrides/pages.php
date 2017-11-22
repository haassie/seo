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
            'type' => 'input',
            'eval' => 'trim',
            'max' => 255,
            'size' => 50
        ],
    ],
    'canonical_url' => [
        'exclude' => 1,
        'label' => $ll.'pages.canonical_url',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputLink',
            'size' => 50,
            'max' => 1024,
            'eval' => 'trim',
            'fieldControl' => [
                'linkPopup' => [
                    'options' => [
                        'title' => $ll.'formlabel.canonical_url',
                        'blindLinkOptions' => 'file,mail,spec,folder',
                        'blindLinkFields' => 'class,params,target,title'
                    ],
                ],
            ],
            'softref' => 'typolink'
        ]
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages',
    $temporaryColumns
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'metadata',
    '
    --linebreak--, seo_title,
    --linebreak--, canonical_url,
    '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;' . $ll . 'pages.tabs.seo,--palette--;' . $ll . 'pages.palettes.metadata;metadata',
    '',
    'after:subtitle'
);
