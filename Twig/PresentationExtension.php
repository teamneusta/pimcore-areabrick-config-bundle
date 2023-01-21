<?php

namespace Neusta\Pimcore\EditorConfigBundle\Twig;

use Pimcore\Model\Document;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PresentationExtension extends AbstractExtension
{
    public function __construct(Environment $twig, string $revealJsPublicPath)
    {
        $twig->addGlobal('revealJsPublicPath', $revealJsPublicPath);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'presentation_theme',
                [$this, 'getThemeFile'],
                ['needs_context' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    public function getThemeFile(array $context): string
    {
        /** @var Document\PageSnippet $document */
        $document = $context['document'];

        if (!$document instanceof Document\PageSnippet) {
            return '';
        }

        $themeEditable = $this->findRecursive('theme', $document);
        if (null === $themeEditable) {
            return '';
        }

        return $themeEditable->getValue();
    }

    private function findRecursive(string $editableName, Document\PageSnippet $document): ?Document\Editable
    {
        if ($document->hasEditable($editableName)) {
            return $document->getEditable($editableName);
        }

        $parent = $document->getParent();
        if ($parent instanceof Document\PageSnippet) {
            return $this->findRecursive($editableName, $parent);
        }

        return null;
    }
}
