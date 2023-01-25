<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

class TabPanelItem extends LayoutItem
{
    public const TYPE = 'tabpanel';
    /**
     * @param list<PanelItem> $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    public function addTab(PanelItem $tab): static
    {
        return $this->addItem($tab);
    }
}
