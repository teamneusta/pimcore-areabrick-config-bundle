<?php
declare(strict_types=1);

namespace Neusta\Pimcore\EditorConfigBundle\Document\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\EditorConfigBundle\Document\EditableDialogBox\LayoutItem;

class TabPanelItem extends LayoutItem
{
    /**
     * @param list<PanelItem> $items
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
