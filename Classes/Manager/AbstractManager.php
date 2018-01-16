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

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Seo\Domain\Model\Dto\MetaDataProperty;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

abstract class AbstractManager
{

    /** @var MetaDataProperty[] */
    protected $container = [];

    /** @var array */
    protected $handledNames = [];

    public function getAll(): array
    {
        return $this->container;
    }

    public function has(string $key): bool
    {
        foreach ($this->container as $property) {
            if ($property->getName() === $key) {
                return true;
            }
        }
        return false;
    }

    public function getTag(string $key): array
    {
        foreach ($this->container as $property) {
            if ($property->getName() === $key) {
                return $property->getItems();
            }
        }

        throw new \RuntimeException(sprintf('Nothing found for tag "%s"', $key), 1516042009);
    }


    public function isValidName(string $key): bool
    {
        return in_array($key, $this->handledNames, true);
    }

    public function getAllNames(): array
    {
        return $this->handledNames;
    }

    protected function getTagBuilder(string $name = 'meta'): TagBuilder
    {
        return new TagBuilder($name);
    }

    public function addProperty(MetaDataProperty $property)
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addMetaTag($property);
    }

}
