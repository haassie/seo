<?php
declare(strict_types=1);
namespace TYPO3\CMS\Seo\ViewHelpers;

use TYPO3\CMS\Seo\Manager\OpenGraphManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;


class OpenGraphMediaViewHelper extends AbstractViewHelper implements CompilableInterface
{
    use CompileWithRenderStatic;

    /**
     */
    public function initializeArguments()
    {
        $this->registerArgument('key', 'string', 'Key', false, 'og:image');
        $this->registerArgument('file', 'string', 'File', true);
        $this->registerArgument('width', 'int', 'Width', false, 0);
        $this->registerArgument('height', 'int', 'Height', false, 0);
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
        if ($arguments['width'] === 0 && $arguments['height'] === 0 && StringUtility::endsWith($arguments['file'], $GLOBALS['TSFE']->lastImageInfo[3])) {
            $arguments['width'] = (int)$GLOBALS['TSFE']->lastImageInfo[0];
            $arguments['height'] = (int)$GLOBALS['TSFE']->lastImageInfo[1];
        }
        $openGraphManager = GeneralUtility::makeInstance(OpenGraphManager::class);
        $openGraphManager->addMediaTag($arguments['key'], $arguments['file'], $arguments['width'], $arguments['height']);
    }
}
