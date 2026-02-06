<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class NumericItem extends EditableItem
{
    private int $min;
    private int $max;
    private int $default;

    public function __construct(string $name, int $min, int $max)
    {
        parent::__construct('numeric', $name);
        $this->min = $min;
        $this->max = $max;
        $this->default = $min;
    }

    /**
     * @return $this
     */
    public function setMin(int $min): static
    {
        $this->min = $min;

        if ($this->default < $min) {
            $this->default = $min;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setMax(int $max): static
    {
        $this->max = $max;

        if ($this->default > $max) {
            $this->default = $max;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setDefaultValue(int $value): static
    {
        if ($this->min > $value || $value > $this->max) {
            throw new \InvalidArgumentException(\sprintf('Default value "%d" is out of bounds: [%d,%d]', $value, $this->min, $this->max));
        }

        $this->default = $value;

        return $this;
    }

    protected function getConfig(): array
    {
        return [
            'minValue' => $this->min,
            'maxValue' => $this->max,
            'defaultValue' => (string) $this->default,
        ];
    }
}
