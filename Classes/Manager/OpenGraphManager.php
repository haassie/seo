<?php
declare(strict_types=1);

namespace TYPO3\CMS\Seo\Manager;

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

use TYPO3\CMS\Core\SingletonInterface;

class OpenGraphManager extends AbstractManager implements ManagerInterface, SingletonInterface
{
    protected $handledKeys = ['og:title', 'og:type', 'og:url', 'og:image', 'og:description', 'og:site_name'];

    public function addTag(string $key, string $content, array $additionalInformation = [], bool $replace = false)
    {
        if (!$this->isValidKey($key)) {
            throw new \UnexpectedValueException(sprintf('Key "%s" is not allowed by %s.', $key, __CLASS__), 1515499561);
        }
        $tagBuilder = $this->getTagBuilder();
        $tagBuilder->addAttribute('property', $key);
        $tagBuilder->addAttribute('content', $content);

        $tag = $tagBuilder->render();
        if ($key === 'og:image') {
            $tag .= $this->renderAdditionalTags($key, $additionalInformation);
        }

        $this->tags[] = $tag;
    }

    protected function renderAdditionalTags(string $key, array $additionalInformation = [])
    {
        $tags = [];

        if (isset($additionalInformation['width'], $additionalInformation['height']) && $additionalInformation['width'] > 0 && $additionalInformation['height'] > 0) {
            foreach (['width', 'height'] as $propertyName) {
                $tagBuilder = $this->getTagBuilder();
                $tagBuilder->addAttribute('property', $key . ':' . $propertyName);
                $tagBuilder->addAttribute('content', $additionalInformation[$propertyName]);

                $tags[] = $tagBuilder->render();
            }
        }

        $this->tags[] = implode(LF, $tags);
    }


}
