<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

/**
 * @extends LayoutItem<PanelItem>
 */
class TabPanelItem extends LayoutItem
{
    /** @var array<string, PanelItem> */
    private array $items;

    /**
     * @param list<PanelItem> $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct('tabpanel', $items);
        $this->items = array_column($items, null, 'title');
    }

    /**
     * @return $this
     */
    public function addTab(PanelItem $tab): static
    {
        $this->items[$tab->title] = $tab;

        return $this->addItem($tab);
    }

    public function getOrCreateTab(string $title): PanelItem
    {
        return $this->items[$title] ?? $this->addTab(new PanelItem($title));
    }
}
