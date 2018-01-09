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

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * Class to register managers
 */
class ManagerRegistry implements SingletonInterface
{
    /**
     * @var array
     */
    protected $registry = [];

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
        $this->registry[$class] = GeneralUtility::makeInstance($class);
    }

    public function getAllManagers()
    {
        return $this->registry;
    }

    public function getRenderedTags(array &$params)
    {
        foreach ($this->registry as $manager) {
            /** @var ManagerInterface $manager */
            $tags = $manager->getRenderedTags();
            foreach ($tags as $tag) {
                $params['metaTags'][] = $tag;
            }
        }
    }

}
