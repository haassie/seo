<?php
declare(strict_types=1);

namespace TYPO3\CMS\Seo\Domain\Model\Dto;

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

use TYPO3\CMS\Core\Utility\DebugUtility;

class MetaDataProperty
{

    /** @var MetaDataElement[] */
    protected $items = [];

    /** @var string */
    protected $name;

    /**
     * MetaDataProperty constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * @return MetaDataElement[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function add(MetaDataElement $element, bool $replace = false)
    {
        // todo: remove replace here
        if ($replace) {
            $this->items = [$element];
        } else {
            $this->items[] = $element;
        }
    }

}
