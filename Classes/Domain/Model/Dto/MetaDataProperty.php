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

class MetaDataProperty
{

    /** @var MetaDataElement[] */
    protected $items = [];

    /** @var string */
    protected $name = '';

    /** @var string */
    protected $tagName = '';

    /** @var bool */
    protected $usePropertyInsteadOfName = false;

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

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param MetaDataElement $element
     */
    public function addItem(MetaDataElement $element)
    {
        $this->items[] = $element;
    }

    /**
     * @param MetaDataElement $element
     */
    public function replaceItem(MetaDataElement $element)
    {
        $this->items = [$element];
    }

    /**
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }

    /**
     * @param string $tagName
     */
    public function setTagName(string $tagName)
    {
        $this->tagName = $tagName;
    }

    /**
     * @return bool
     */
    public function isUsePropertyInsteadOfName(): bool
    {
        return $this->usePropertyInsteadOfName;
    }

    /**
     * @param bool $usePropertyInsteadOfName
     */
    public function setUsePropertyInsteadOfName(bool $usePropertyInsteadOfName)
    {
        $this->usePropertyInsteadOfName = $usePropertyInsteadOfName;
    }




}
