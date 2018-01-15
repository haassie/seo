<?php
declare(strict_types=1);

namespace TYPO3\CMS\Seo\Hooks;

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

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Seo\Domain\Model\Dto\MetaDataProperty;
use TYPO3\CMS\Seo\Manager\AbstractManager;
use TYPO3\CMS\Seo\Manager\ManagerRegistry;
use TYPO3\CMS\Seo\Renderer\TagRenderer;


class PageRendererHook
{

    /**
     * Hook for PageRenderer
     *
     * @param array $params
     */
    public function getRenderedTags(array &$params)
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $renderer = GeneralUtility::makeInstance(TagRenderer::class);

        $getNewTags = [];
        foreach ($params['metaTags'] as $key => $tag) {
            if (is_object($tag) && get_class($tag) === MetaDataProperty::class) {
                $getNewTags[] = $tag;
                unset($params['metaTags'][$key]);
            }
        }
        $content = $renderer->render($getNewTags);
        $params['metaTags'][] = $content;
        return;
//        $managerRegistry = ManagerRegistry::getInstance();
//        $managers = $managerRegistry->getAllManagers();
//        foreach ($managers as $manager) {
//            /** @var AbstractManager $manager */
//            $tags = $manager->getAll();
//
//            $renderer = GeneralUtility::makeInstance(TagRenderer::class);
//            $content = $renderer->render($tags);
//            $params['metaTags'][] = $content;
//        }
    }
}
