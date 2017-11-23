<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Core SEO',
    'description' => 'Core SEO functions for TYPO3',
    'category' => 'fe',
    'author' => 'Richard Haeser',
    'author_email' => 'richardhaeser@gmail.com',
    'state' => 'alpha',
    'clearCacheOnLoad' => 1,
    'version' => '0.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.1-9.0.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
