<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Controller\Admin;

use Neusta\ConverterBundle\Converter;
use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Brick;
use Pimcore\Controller\FrontendController;
use Pimcore\Extension\Document\Areabrick\AreabrickInterface;
use Pimcore\Extension\Document\Areabrick\AreabrickManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AreabrickOverviewController extends FrontendController // UserAwareController
{
    /**
     * @param Converter<AreabrickInterface, Brick, GenericContext|null> $brickConverter
     */
    public function __construct(
        private AreabrickManagerInterface $areabrickManager,
        private Converter $brickConverter,
    ) {
    }

    #[Route('/admin/areabricks/list', name: 'areabrick_overview', methods: ['GET'])]
    public function defaultAction(Request $request): Response
    {
        $ctx = null;

        $bricks = array_map(
            fn ($item) => $this->brickConverter->convert($item, $ctx),
            $this->areabrickManager->getBricks(),
        );

        return $this->render(
            '@NeustaPimcoreAreabrickConfig/bricks/default.html.twig',
            [
                'bricks' => $bricks,
                'showAdditionalPropertiesColumn' => !empty(array_filter($bricks, fn ($brick) => !empty($brick->additionalProperties))),
            ]
        );
    }
}
