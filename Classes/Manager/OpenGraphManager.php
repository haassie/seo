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
    static protected $VALID_KEYS = ['og:title', 'og:type', 'og:url', 'og:image', 'og:description', 'og:site_name'];

    protected $tags = [];

    public function addTag(string $key, string $content)
    {
        if (!$this->isValidKey($key)) {
            throw new \UnexpectedValueException(sprintf('Key "%s" is not allowed by %s.', $key, __CLASS__), 1515499561);
        }
        $tagBuilder = $this->getTagBuilder();
        $tagBuilder->addAttribute('property', $key);
        $tagBuilder->addAttribute('content', $content);

        $this->tags[] = $tagBuilder->render();
    }

    public function addMediaTag(string $key, string $path, int $width = 0, int $height = 0)
    {
        $tags = [];

        $tagBuilder = $this->getTagBuilder();
        $tagBuilder->addAttribute('property', $key);
        $tagBuilder->addAttribute('content', $path);
        $tags[] = $tagBuilder->render();

        if ($width > 0 && $height > 0) {
            foreach (['width', 'height'] as $propertyName) {
                $tagBuilder = $this->getTagBuilder();
                $tagBuilder->addAttribute('property', $key . ':' . $propertyName);
                $tagBuilder->addAttribute('content', $$propertyName);

                $tags[] = $tagBuilder->render();
            }
        }

        $this->tags[] = implode(LF, $tags);
    }

    public function getTag(string $key)
    {
        // TODO: Implement getTag() method.
    }

    public function getRenderedTags(): array
    {
        return $this->tags;
    }

    public function isValidKey(string $key): bool
    {
        return in_array($key, self::$VALID_KEYS, true);
    }


}
