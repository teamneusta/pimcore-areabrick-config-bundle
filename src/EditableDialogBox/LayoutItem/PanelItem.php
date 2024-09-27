<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\DialogBoxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

class PanelItem extends LayoutItem
{
    private string $title;

    /**
     * @param list<DialogBoxItem> $items
     */
    public function __construct(string $title, array $items)
    {
        parent::__construct('panel', $items);
        $this->title = $title;
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
