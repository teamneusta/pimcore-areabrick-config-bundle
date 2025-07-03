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
    public readonly string $title;

    /**
     * @param list<DialogBoxItem> $items
     */
    public function __construct(string $title, array $items = [])
    {
        parent::__construct('panel', $items);
        $this->title = $title;
    }

    public function addItem(DialogBoxItem ...$items): static
    {
        foreach ($items as $item) {
            parent::addItem($item);
        }

        return $this;
    }

    protected function getAttributes(): array
    {
        return ['title' => $this->title] + parent::getAttributes();
    }
}
