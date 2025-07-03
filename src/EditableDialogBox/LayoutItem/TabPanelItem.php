<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

/**
 * @extends LayoutItem<PanelItem>
 */
class TabPanelItem extends LayoutItem
{
    /**
     * @param list<PanelItem> $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct('tabpanel', $items);
    }

    /**
     * @return $this
     */
    public function addTab(PanelItem $tab): static
    {
        return $this->addItem($tab);
    }

    public function findTab(string $title): ?PanelItem
    {
        foreach ($this->items as $item) {
            if ($item->title === $title) {
                return $item;
            }
        }

        return null;
    }
}
