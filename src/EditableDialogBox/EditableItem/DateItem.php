<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class DateItem extends EditableItem
{
    public function __construct(string $name)
    {
        parent::__construct('date', $name);
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
    public function setFormat(string $value): static
    {
        return $this->addConfig('format', $value);
    }

    /**
     * @return $this
     */
    public function setOutputIsoFormat(string $value): static
    {
        return $this->addConfig('outputIsoFormat', $value);
    }

    /**
     * @return $this
     */
    public function setWidth(int $width): static
    {
        return $this->addConfig('width', $width);
    }
}
