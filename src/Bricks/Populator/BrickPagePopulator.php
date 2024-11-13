<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Populator;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Neusta\ConverterBundle\Converter;
use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\ConverterBundle\Populator;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Brick;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Page as PageView;
use Pimcore\Extension\Document\Areabrick\AbstractAreabrick;
use Pimcore\Model\Document\Page;

/**
 * @implements Populator<AbstractAreabrick, Brick, GenericContext>
 */
final class BrickPagePopulator implements Populator
{
    /**
     * @param Converter<Page, PageView, GenericContext|null> $pageConverter
     */
    public function __construct(
        private Connection $connection,
        private Converter $pageConverter,
    ) {
    }

    public function populate(object $target, object $source, ?object $ctx = null): void
    {
        $areabrickName = $source->getId();
        $documentIds = $this->connection->createQueryBuilder()
            ->select('documentId')
            ->distinct()
            ->from('documents_editables')
            ->where('type IN ("area", "areablock")')
            ->andWhere('data LIKE :data')
            ->setParameter('data', \sprintf('%%"type";s:%d:"%s";%%', \strlen($areabrickName), $areabrickName))
            ->execute();

        // Todo: remove after upgrade to doctrine/dbal >=3.9
        \assert($documentIds instanceof Result);

        $target->pages = [];
        foreach ($documentIds->fetchFirstColumn() as $id) {
            if ($page = Page::getById($id)) {
                $target->pages[] = $this->pageConverter->convert($page);
            }
        }
    }
}
