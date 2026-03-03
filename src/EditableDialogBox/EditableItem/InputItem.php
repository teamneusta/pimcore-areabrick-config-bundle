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

    /**
     * @return $this
     */
    public function setDefaultValue(string $value): static
    {
        return $this->addConfig('defaultValue', $value);
    }

    /**
     * @return $this
     */
    public function setPlaceholder(string $value): static
    {
        return $this->addConfig('placeholder', $value);
    }

    /**
     * @return $this
     */
    public function setWidth(int $width): static
    {
        return $this->addConfig('width', $width);
    }
}
