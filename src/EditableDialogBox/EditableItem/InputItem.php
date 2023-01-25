<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class InputItem extends EditableItem
{
    public const TYPE = 'input';

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function setDefaultValue(string $value): static
    {
        return $this->addConfig(static::ITEM_DEFAULT_VALUE, $value);
    }

    public function setPlaceholder(string $value): static
    {
        return $this->addConfig('placeholder', $value);
    }
}
