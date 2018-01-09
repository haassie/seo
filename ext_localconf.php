<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:core_seo/Configuration/TSconfig/PageTSconfig.typoscript">'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
    '<INCLUDE_TYPOSCRIPT: source="DIR:EXT:core_seo/Configuration/TypoScript/Setup/" extensions="typoscript">'
);

$managerRegistry = \Haassie\CoreSeo\Manager\ManagerRegistry::getInstance();
$managerRegistry->add(\Haassie\CoreSeo\Manager\OpenGraphManager::class);

if (TYPO3_MODE === 'FE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][1515485154] =
        \Haassie\CoreSeo\Manager\ManagerRegistry::class . '->getRenderedTags';
}
