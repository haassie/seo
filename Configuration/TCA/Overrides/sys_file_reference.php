<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'sys_file_reference',
    'imageoverlayPaletteSocial',
    'alternative,--linebreak--,crop'
);
