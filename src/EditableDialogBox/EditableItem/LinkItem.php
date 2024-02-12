<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class LinkItem extends EditableItem
{
    public function __construct(string $name)
    {
        parent::__construct('link', $name);
    }
}
