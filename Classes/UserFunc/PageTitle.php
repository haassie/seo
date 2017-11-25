<?php
namespace Haassie\CoreSeo\UserFunc;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class PageTitle
 * @package Haassie\CoreSeo\UserFunc
 */
class PageTitle
{

    /**
     * Get title of page
     *
     * This method is copied from \TYPO3\CMS\Frontend\Page\PageGenerator::generatePageTitle.
     *
     * @return string
     */
    public function getTitle()
    {
        /** @var TypoScriptFrontendController $tsfe */
        $tsfe = $GLOBALS['TSFE'];

        $pageTitleSeparator = '';

        // check for a custom pageTitleSeparator, and perform stdWrap on it
        if (isset($tsfe->config['config']['pageTitleSeparator']) && $tsfe->config['config']['pageTitleSeparator'] !== '') {
            $pageTitleSeparator = $tsfe->config['config']['pageTitleSeparator'];

            if (isset($tsfe->config['config']['pageTitleSeparator.']) && is_array($tsfe->config['config']['pageTitleSeparator.'])) {
                $pageTitleSeparator = $tsfe->cObj->stdWrap($pageTitleSeparator, $tsfe->config['config']['pageTitleSeparator.']);
            } else {
                $pageTitleSeparator .= ' ';
            }
        }

        // first check if altPageTitle is set, then check if seo_title is set and otherwise use the page title
        $titleTagContent = $tsfe->tmpl->printTitle(
            $tsfe->altPageTitle ?: $tsfe->page['seo_title'] ?: $tsfe->page['title'],
            $tsfe->config['config']['noPageTitle'],
            $tsfe->config['config']['pageTitleFirst'],
            $pageTitleSeparator
        );

        return $titleTagContent;
    }
}
