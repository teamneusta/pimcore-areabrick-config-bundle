<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Neusta\Pimcore\AreabrickConfigBundle\Exception\OutOfBoundsException;

class NumericItem extends EditableItem
{
    private int $min;
    private int $max;

    public function __construct(string $name, int $min, int $max)
    {
        parent::__construct('numeric', $name);
        $this->min = $min;
        $this->max = $max;
        $this->setDefaultValue($this->min);
    }

    public function setDefaultValue(int $value): static
    {
        if ($value >= $this->min && $value <= $this->max) {
            return $this->addConfig('defaultValue', $value);
        }

        throw new OutOfBoundsException($value, $this->min, $this->max);
    }

    protected function getConfig(): array
    {
        return [
            'minValue' => $this->min,
            'maxValue' => $this->max,
        ];
    }
}
