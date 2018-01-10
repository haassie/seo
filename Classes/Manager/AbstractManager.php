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

use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

abstract class AbstractManager
{

    /** @var array */
    protected $tags = [];

    /** @var array */
    protected $handledKeys = [];

    public function getAll(): array
    {
        return $this->tags;
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function getTag(string $key)
    {
        // TODO: Implement getTag() method.
    }


    public function isValidKey(string $key): bool
    {
        return in_array($key, $this->handledKeys, true);
    }

    public function getAllValidKeys(): array
    {
        return $this->handledKeys;
    }

    protected function getTagBuilder(string $name = 'meta'): TagBuilder
    {
        return new TagBuilder($name);
    }

}
