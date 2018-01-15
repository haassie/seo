<?php
declare(strict_types=1);

namespace TYPO3\CMS\Seo\Renderer;

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

use TYPO3\CMS\Seo\Domain\Model\Dto\MetaDataElement;
use TYPO3\CMS\Seo\Domain\Model\Dto\MetaDataProperty;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

class TagRenderer
{

    /**
     * @param MetaDataProperty[] $data
     * @return string
     */
    public function render(array $data): string
    {
        $out = [];

        foreach ($data as $property) {
            $propertyOrName = $property->isUsePropertyInsteadOfName() ? 'property' : 'name';

            foreach ($property->getItems() as $element) {
                $tag = $this->getTagBuilder($property->getTagName());
                $tag->addAttribute($propertyOrName, $property->getName());
                $tag->addAttribute('content', $element->getContent());

                $out[] = $tag->render();
                if ($property->getName() === 'og:image') {
                    $this->renderAdditionalTags($out, $element, $property);
                }
            }
        }

        return implode(LF, $out);
    }

    protected function renderAdditionalTags(&$out, MetaDataElement $element, MetaDataProperty $property)
    {
        $additionalInformation = $element->getDetails();
        $propertyOrName = $property->isUsePropertyInsteadOfName() ? 'property' : 'name';

        if (isset($additionalInformation['width'], $additionalInformation['height']) && $additionalInformation['width'] > 0 && $additionalInformation['height'] > 0) {
            foreach (['width', 'height'] as $propertyName) {
                $tagBuilder = $this->getTagBuilder($property->getTagName());
                $tagBuilder->addAttribute($propertyOrName, 'og:image:' . $propertyName);
                $tagBuilder->addAttribute('content', $additionalInformation[$propertyName]);

                $out[] = $tagBuilder->render();
            }
        }
        if (isset($additionalInformation['alt']) && !empty($additionalInformation['alt'])) {
            $tagBuilder = $this->getTagBuilder($property->getTagName());
            $tagBuilder->addAttribute($propertyOrName, 'og:image:alternative');
            $tagBuilder->addAttribute('content', $additionalInformation['alt']);
            $out[] = $tagBuilder->render();
        }
    }

    private function getTagBuilder(string $name): TagBuilder
    {
        return new TagBuilder($name);
    }

}
