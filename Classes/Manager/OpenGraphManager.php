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
use TYPO3\CMS\Seo\Domain\Model\Dto\MetaDataElement;
use TYPO3\CMS\Seo\Domain\Model\Dto\MetaDataProperty;

class OpenGraphManager extends AbstractManager implements ManagerInterface, SingletonInterface
{
    protected $handledNames = ['og:title', 'og:type', 'og:url', 'og:image', 'og:description', 'og:site_name'];

    public function addTag(string $name, string $content, array $additionalInformation = [], bool $replace = true)
    {
        if (!$this->isValidName($name)) {
            throw new \UnexpectedValueException(sprintf('Key "%s" is not allowed by %s.', $name, __CLASS__), 1515499561);
        }

        $tagBuilder = $this->getTagBuilder();
        $tagBuilder->addAttributes([
            'property' => $name,
            'content' => $content
        ]);
        $additionalTags = $name === 'og:image' ? $this->renderAdditionalTags($additionalInformation) : [];

        $element = new MetaDataElement($tagBuilder, $additionalTags);

        $property = new MetaDataProperty($name);
        $property->add($element, $replace);

        $this->addProperty($property, $replace);
    }

    protected function renderAdditionalTags(array $additionalInformation): array
    {
        $additionalTags = [];

        if (isset($additionalInformation['width'], $additionalInformation['height']) && $additionalInformation['width'] > 0 && $additionalInformation['height'] > 0) {
            foreach (['width', 'height'] as $propertyName) {
                $tagBuilder = $this->getTagBuilder();
                $tagBuilder->addAttributes([
                    'property' => 'og:image:' . $propertyName,
                    'content' => $additionalInformation[$propertyName]
                ]);
                $additionalTags[] = $tagBuilder;
            }
        }
        if (isset($additionalInformation['alt']) && !empty($additionalInformation['alt'])) {
            $tagBuilder = $this->getTagBuilder();
            $tagBuilder->addAttributes([
                'property' => 'og:image:alternative',
                'content' => $additionalInformation['alt']
            ]);
            $additionalTags[] = $tagBuilder;
        }

        return $additionalTags;
    }
}
