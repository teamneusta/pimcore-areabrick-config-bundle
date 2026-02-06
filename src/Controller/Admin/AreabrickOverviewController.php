<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Controller\Admin;

use Neusta\ConverterBundle\Converter;
use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Brick;
use Pimcore\Extension\Document\Areabrick\AreabrickInterface;
use Pimcore\Extension\Document\Areabrick\AreabrickManagerInterface;
use Pimcore\Security\User\TokenStorageUserResolver;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route('/areabricks/list', name: 'areabrick_overview', methods: ['GET'])]
final class AreabrickOverviewController
{
    /**
     * @param Converter<AreabrickInterface, Brick, GenericContext|null> $brickConverter
     */
    public function __construct(
        private TokenStorageUserResolver $tokenResolver,
        private AreabrickManagerInterface $areabrickManager,
        private Converter $brickConverter,
        private Environment $twig,
    ) {
    }

    public function __invoke(): Response
    {
        if (!$this->tokenResolver->getUser()?->isAllowed('neusta_areabrick_config.areabrick_overview')) {
            throw new AccessDeniedHttpException('Access Denied.');
        }

        $bricks = array_map($this->brickConverter->convert(...), $this->areabrickManager->getBricks());
        usort($bricks, static fn ($a, $b) => strcmp($a->name, $b->name));

        return new Response($this->twig->render('@NeustaPimcoreAreabrickConfig/bricks/overview.html.twig', [
            'bricks' => $bricks,
        ]));
    }
}
