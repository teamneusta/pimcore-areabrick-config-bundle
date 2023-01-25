<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class InputItem extends EditableItem
{
    public function __construct(string $name)
    {
        parent::__construct('input', $name);
    }

    public function setDefaultValue(string $value): static
    {
        return $this->addConfig('defaultValue', $value);
    }

    public function setPlaceholder(string $value): static
    {
        return $this->addConfig('placeholder', $value);
    }
}
