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
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * Class to register managers
 */
class ManagerRegistry implements SingletonInterface
{
    /**
     * @var ManagerInterface[]
     */
    protected $registry = [];

    protected $handledKeys = [];

    /**
     * Returns a class instance
     *
     * @return ManagerRegistry
     */
    public static function getInstance()
    {
        return GeneralUtility::makeInstance(__CLASS__);
    }

    public function add(string $class)
    {
        /** @var ManagerInterface $manager */
        $manager = GeneralUtility::makeInstance($class);
        $handledKeys = $manager->getAllNames();
        foreach ($handledKeys as $key) {
            $this->handledKeys[$key] = $manager;
        }
        $this->registry[$class] = $manager;
    }

    /**
     * @return ManagerInterface[]
     */
    public function getAllManagers(): array
    {
        return $this->registry;
    }

    public function getManagerForKey(string $key): ManagerInterface
    {
        if (isset($this->handledKeys[$key])) {
            return $this->handledKeys[$key];
        }
        throw new \UnexpectedValueException(sprintf('No manager for key "%s" found', $key));
    }

}
