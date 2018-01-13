<?php
declare(strict_types=1);

namespace TYPO3\CMS\Seo\ViewHelpers;

use TYPO3\CMS\Seo\Manager\ManagerRegistry;
use TYPO3\CMS\Seo\Manager\OpenGraphManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;


class MetaTagViewHelper extends AbstractViewHelper implements CompilableInterface
{
    use CompileWithRenderStatic;

    /**
     */
    public function initializeArguments()
    {
        $this->registerArgument('key', 'string', 'Key', true);
        $this->registerArgument('content', 'string', 'Content', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    )
    {
        $registry = ManagerRegistry::getInstance();

        try {
            $handler = $registry->getManagerForKey($arguments['key']);
            if ($handler) {
                $handler->addTag($arguments['key'], $arguments['content']);
            }
        } catch (\UnexpectedValueException $e) {
            // @todo custom ex!
        }
    }
}
