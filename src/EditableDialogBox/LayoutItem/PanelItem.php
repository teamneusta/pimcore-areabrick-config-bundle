<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\DialogBoxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

/**
 * @extends LayoutItem<DialogBoxItem>
 */
class PanelItem extends LayoutItem
{
    /**
     * @param list<DialogBoxItem> $items
     */
    public function __construct(
        public readonly string $title,
        array $items,
    ) {
        parent::__construct('panel', $items);
    }

    public function addItem(DialogBoxItem $item): static
    {
        return parent::addItem($item);
    }

    protected function getAttributes(): array
    {
        return ['title' => $this->title] + parent::getAttributes();
    }
}
