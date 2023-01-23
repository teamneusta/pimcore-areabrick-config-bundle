<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Document\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\Document\EditableDialogBox\DialogBoxItem;
use Neusta\Pimcore\AreabrickConfigBundle\Document\EditableDialogBox\LayoutItem;

class PanelItem extends LayoutItem
{
    private string $title;

    /**
     * @param DialogBoxItem $items
     */
    public function __construct(string $title, array $items)
    {
        parent::__construct('panel', $items);
        $this->title = $title;
    }

    protected function getAttributes(): array
    {
        return ['title' => $this->title] + parent::getAttributes();
    }
}
