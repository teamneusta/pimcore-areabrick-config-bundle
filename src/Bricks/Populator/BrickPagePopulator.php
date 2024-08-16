<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Populator;

use Neusta\ConverterBundle\Converter;
use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\ConverterBundle\Populator;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Brick;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Page as PageView;
use Pimcore\Db;
use Pimcore\Extension\Document\Areabrick\AbstractAreabrick;
use Pimcore\Model\Document\Page;

/**
 * @implements Populator<AbstractAreabrick, Brick, GenericContext>
 */
class BrickPagePopulator implements Populator
{
    public const SQL_ALL_DOCUMENTS_BY_EDITABLE = "SELECT DISTINCT documentId FROM documents_editables WHERE data LIKE '%%%s%%'";

    /**
     * @param Converter<Page, PageView, GenericContext|null> $pageConverter
     */
    public function __construct(
        private Converter $pageConverter,
    ) {
    }

    public function populate(object $target, object $source, ?object $ctx = null): void
    {
        $editableUsages = Db::get()->fetchAllAssociative(\sprintf(self::SQL_ALL_DOCUMENTS_BY_EDITABLE, $source->getId()));
        $target->pages = [];
        foreach (array_values($editableUsages) as $docId) {
            $page = Page::getById($docId['documentId']);
            if ($page) {
                $target->pages[] = $this->pageConverter->convert($page);
            }
        }
    }
}
