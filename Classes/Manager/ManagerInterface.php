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

/**
 * interface for meta tag managers
 */
interface ManagerInterface
{

    public function addTag(string $name, string $content, array $additionalInformation = [], bool $replace = true);

    public function isValidName(string $name): bool;

    public function getAllNames(): array;

}
