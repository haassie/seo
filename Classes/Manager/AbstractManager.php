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

use TYPO3\CMS\Seo\Domain\Model\Dto\MetaDataContainer;
use TYPO3\CMS\Seo\Domain\Model\Dto\MetaDataElement;
use TYPO3\CMS\Seo\Domain\Model\Dto\MetaDataProperty;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

abstract class AbstractManager
{

    /** @var MetaDataProperty[] */
    protected $container;

    /** @var array */
    protected $handledNames = [];

    public function getAll(): array
    {
        return $this->container;
    }

    public function has(string $key): bool
    {
        // TODO: Implement getTag() method.
    }

    public function getTag(string $key)
    {
        // TODO: Implement getTag() method.
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

    public function addProperty(MetaDataProperty $property) {
        $this->container[] = $property;
    }

}
