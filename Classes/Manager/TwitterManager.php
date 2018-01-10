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

class TwitterManager extends AbstractManager implements ManagerInterface, SingletonInterface
{
    protected $handledKeys = ['twitter:card', 'twitter:title', 'twitter:description', 'twitter:site', 'twitter:url', 'twitter:creator', 'twitter:image'];

    public function addTag(string $key, string $content, array $additionalInformation = [], bool $replace = false)
    {
        if (!$this->isValidKey($key)) {
            throw new \UnexpectedValueException(sprintf('Key "%s" is not allowed by %s.', $key, __CLASS__), 1515499561);
        }
        $tagBuilder = $this->getTagBuilder();
        $tagBuilder->addAttribute('name', $key);
        $tagBuilder->addAttribute('content', $content);

        $this->tags[] = $tagBuilder->render();
    }

}
