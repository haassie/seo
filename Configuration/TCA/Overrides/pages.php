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
    'robot_index' => [
        'exclude' => true,
        'label' => $ll.'pages.robot_index',
        'config' => [
            'type' => 'check',
            'default' => 1
        ],
    ],
    'robot_follow' => [
        'exclude' => true,
        'label' => $ll.'pages.robot_follow',
        'config' => [
            'type' => 'check',
            'default' => 1
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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'robot_instructions',
    'robot_index,robot_follow,
    '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;' . $ll . 'pages.tabs.seo,--palette--;' . $ll . 'pages.palettes.metadata;metadata,
    --palette--;' . $ll . 'pages.palettes.robot_instructions;robot_instructions
    ',
    '',
    'after:subtitle'
);
