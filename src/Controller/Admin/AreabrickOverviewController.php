<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Controller\Admin;

use Neusta\ConverterBundle\Converter;
use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Brick;
use Pimcore\Controller\UserAwareController;
use Pimcore\Extension\Document\Areabrick\AreabrickInterface;
use Pimcore\Extension\Document\Areabrick\AreabrickManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Todo: check if this can't be accessed outside the admin context in Pimcore 11
final class AreabrickOverviewController extends UserAwareController
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
            function ($item) use ($ctx) {
                return $this->brickConverter->convert($item, $ctx);
            },
            $this->areabrickManager->getBricks()
        );

        return $this->render(
            'bricks/default.html.twig',
            [
                'bricks' => $bricks,
            ]
        );
    }
}
