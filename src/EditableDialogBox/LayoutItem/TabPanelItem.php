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

    public function getOrCreateTab(string $title): PanelItem
    {
        if (!isset($this->items[$title])) {
            $this->addItem($this->items[$title] = new PanelItem($title));
        }

        return $this->items[$title];
    }
}
