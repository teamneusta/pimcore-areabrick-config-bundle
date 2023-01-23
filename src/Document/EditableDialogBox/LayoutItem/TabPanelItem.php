<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\src\Document\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\src\Document\EditableDialogBox\LayoutItem;

class TabPanelItem extends LayoutItem
{
    /**
     * @param PanelItem $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct('tabpanel', $items);
    }

    public function addTab(PanelItem $tab): static
    {
        return $this->addItem($tab);
    }
}
