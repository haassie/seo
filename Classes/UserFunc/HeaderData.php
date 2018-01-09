<?php

namespace Haassie\CoreSeo\UserFunc;

use GeorgRinger\News\Utility\Page;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Generate all the header data
 */
class HeaderData
{
    const TEMPLATE_HREFLANG = '<link rel="alternate" href="%s" hreflang="%s" />';
    const TEMPLATE_CANONICAL = '<link rel="canonical" href="%s" />';

    public function user_generate()
    {
        $html = '';
        $languages = $this->getAllLanguages();

//        $canonical = $this->generateCanonical();
//        $html = $this->wrapHtmlInComment($canonical, 'canonical');

        $hrefLang = $this->generateHrefLang($languages);
        $html .= $this->wrapHtmlInComment($hrefLang, 'hreflang');

        return $html;
    }

    protected function generateHrefLang(array $languages): string
    {
        $items = [];
        foreach ($languages as $language) {
            $items[] = sprintf(
                self::TEMPLATE_HREFLANG,
                htmlspecialchars($this->generateLink($language['uid'])),
                htmlspecialchars($this->generateLocale($language))
            );
        }

        if (count($items) > 1) {
            return implode(LF, $items);
        }

        return '';
    }

    protected function generateCanonical()
    {
        $tsfe = $this->getTsfe();
        if ($tsfe->sys_language_uid !== $tsfe->sys_language_content) {
            $canonicalLanguageId = $tsfe->sys_language_content;
        } else {
            $canonicalLanguageId = $tsfe->sys_language_uid;
        }

        $link = sprintf(
            self::TEMPLATE_CANONICAL,
            htmlspecialchars($this->generateLink($canonicalLanguageId))
        );

        return $link;
    }

    protected function generateLocale(array $language): string
    {
        if ($language['is_international']) {
            return $language['language_isocode'];
        } else {
            return $language['language_isocode'] . '-' . $language['flag'];
        }
    }

    protected function generateLink(int $language): string
    {
        $configuration = [
            'parameter' => $this->getTsfe()->id,
            'addQueryString' => 'GET'
        ];
        if ($language > 0) {
            $configuration['additionalParams'] = '&L=' . $language;
        }
        return $this->cObj->typoLink_URL($configuration);
    }

    /**
     * Get all languages + care about language behaviour
     *
     * @return array
     */
    protected function getAllLanguages(): array
    {
        $l18nConfigurationOfCurrentPage = (int)$this->getTsfe()->page['l18n_cfg'];

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_language');

        $res = $queryBuilder
            ->select('uid', 'flag', 'language_isocode')
            ->from('sys_language')
            ->orderBy('sorting');

        $translations = $this->getAllTranslationsOfCurrentPage();
        $idList = [];
        if (GeneralUtility::hideIfNotTranslated($l18nConfigurationOfCurrentPage)) {
            foreach ($translations as $translation) {
                $idList[] = $translation['sys_language_uid'];
            }

            if (empty($idList)) {
                $idList[] = -1;
            }

            $res->where(
                $queryBuilder->expr()->in('uid', $idList)
            );

        }

        $rows = $res->execute()->fetchAll();


        if (!GeneralUtility::hideIfDefaultLanguage($l18nConfigurationOfCurrentPage)) {
            $default = [
                'uid' => 0,
                'flag' => 'de',
                'language_isocode' => 'de'
            ];
            array_unshift($rows, $default);
        }

        return $rows;
    }

    /**
     * Get language uid of all translations
     *
     * @return array
     */
    protected function getAllTranslationsOfCurrentPage()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');

        return $queryBuilder
            ->select('sys_language_uid')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter((int)$this->getTsfe()->id, \PDO::PARAM_INT)),
                $queryBuilder->expr()->gt('sys_language_uid', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
            )
            ->execute()->fetchAll();
    }

    protected function wrapHtmlInComment(string $html, string $comment)
    {
        return LF . LF . '<!-- ' . $comment . ' -->' . LF
            . $html
            . LF . '<!-- /end ' . $comment . ' -->' . LF;
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTsfe(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }

}
