<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class CheckboxItem extends EditableItem
{
    public const TYPE = 'checkbox';

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function setDefaultChecked(): static
    {
        return $this->addConfig(static::ITEM_DEFAULT_VALUE, true);
    }

    public function setDefaultUnchecked(): static
    {
        return $this->addConfig(static::ITEM_DEFAULT_VALUE, false);
    }
}
