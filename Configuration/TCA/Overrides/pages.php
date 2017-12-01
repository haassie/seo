<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$ll = 'LLL:EXT:core_seo/Resources/Private/Language/locallang_db.xlf:';
$temporaryColumns = [
    'seo_title' => [
        'exclude' => true,
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
        'exclude' => true,
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
    ],
    'og_title' => [
        'exclude' => true,
        'label' => $ll.'pages.og_title',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
            'max' => 255,
            'size' => 50
        ],
    ],
    'og_description' => [
        'exclude' => true,
        'label' => $ll.'pages.og_description',
        'config' => [
            'type' => 'text',
            'cols' => 40,
            'rows' => 3
        ]
    ],
    'og_image' => [
        'exclude' => true,
        'label' => $ll.'pages.og_image',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'og_image',
            [
                // Use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                    ],
                ],
            ],
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        )
    ],
    'og_type' => [
        'exclude' => true,
        'label' => $ll.'pages.og_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [$ll.'pages.og_type.website', 'website'],
                [$ll.'pages.og_type.article', 'article'],
                [$ll.'pages.og_type.profile', 'profile'],
            ]
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
    'og',
    '
    --linebreak--, og_title,
    --linebreak--, og_description,
    --linebreak--, og_image,
    --linebreak--, og_type,
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
    '
    --div--;' . $ll . 'pages.tabs.seo,
        --palette--;' . $ll . 'pages.palettes.metadata;metadata,
        --palette--;' . $ll . 'pages.palettes.robot_instructions;robot_instructions,
    --div--;' . $ll . 'pages.tabs.social,
        --palette--;' . $ll . 'pages.palettes.og;og,
    ',
    '',
    'after:subtitle'
);
