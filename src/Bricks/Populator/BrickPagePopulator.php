<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Populator;

use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\ConverterBundle\Populator;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\BrickView;
use Pimcore\Db;
use Pimcore\Extension\Document\Areabrick\AbstractAreabrick;
use Pimcore\Model\Document\Page;

/**
 * @implements Populator<AbstractAreabrick, BrickView, GenericContext>
 */
class BrickPagePopulator implements Populator
{
    public function populate(object $target, object $source, ?object $ctx = null): void
    {
        $editableUsages = Db::get()->fetchAllAssociative("SELECT DISTINCT documentId FROM documents_editables WHERE data LIKE '%" . $source->getId() . "%'");
        $target->pageFullPaths = [];
        foreach (array_values($editableUsages) as $docId) {
            $page = Page::getById($docId['documentId']);
            $target->pageFullPaths[] = [
                $page?->isPublished(),
                $page?->getFullPath(),
            ];
        }
    }
}
