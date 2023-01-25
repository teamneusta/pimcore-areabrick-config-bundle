<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\DialogBoxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

class PanelItem extends LayoutItem
{
    public const TYPE = 'panel';
    private string $title;

    /**
     * @param list<DialogBoxItem> $items
     */
    public function __construct(string $title, array $items)
    {
        parent::__construct($items);
        $this->title = $title;
    }

    protected function getAttributes(): array
    {
        return ['title' => $this->title] + parent::getAttributes();
    }
}
