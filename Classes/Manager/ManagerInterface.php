<?php

namespace Haassie\CoreSeo\Manager;

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

/**
 * interface for meta tag managers
 */
interface ManagerInterface
{

    public function addTag(string $key, string $content);

    public function getTag(string $key);

    public function getRenderedTags(): array;

    public function validateKey(string $key): bool;

}
