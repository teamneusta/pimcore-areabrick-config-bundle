<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Controller\Admin;

use Neusta\ConverterBundle\Converter;
use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Brick;
use Pimcore\Extension\Document\Areabrick\AreabrickInterface;
use Pimcore\Extension\Document\Areabrick\AreabrickManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class AreabrickOverviewController
{
    /**
     * @param Converter<AreabrickInterface, Brick, GenericContext|null> $brickConverter
     */
    public function __construct(
        private AreabrickManagerInterface $areabrickManager,
        private Converter $brickConverter,
        private Environment $twig,
    ) {
    }

    #[Route('/areabricks/list', name: 'areabrick_overview', methods: ['GET'])]
    public function defaultAction(): Response
    {
        $bricks = array_map($this->brickConverter->convert(...), $this->areabrickManager->getBricks());
        $hasAdditionalProperties = [] !== array_filter($bricks, fn ($brick) => !empty($brick->additionalProperties));

        return new Response($this->twig->render('@NeustaPimcoreAreabrickConfig/bricks/default.html.twig', [
            'bricks' => $bricks,
            'hasAdditionalProperties' => $hasAdditionalProperties,
        ]));
    }
}
