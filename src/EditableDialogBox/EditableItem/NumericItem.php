<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

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

    /**
     * @return $this
     */
    public function setDefaultValue(int $value): static
    {
        if ($this->min > $value || $value > $this->max) {
            throw new \InvalidArgumentException(\sprintf('Default value "%d" is out of bounds: [%d,%d]', $value, $this->min, $this->max));
        }

        return $this->addConfig('defaultValue', (string) $value);
    }

    protected function getConfig(): array
    {
        return [
            'minValue' => (string) $this->min,
            'maxValue' => (string) $this->max,
        ];
    }
}
