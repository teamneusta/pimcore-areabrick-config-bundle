<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class NumericItem extends EditableItem
{
    private int|float $min;
    private int|float $max;
    private int|float $default;

    public function __construct(string $name, int|float $min, int|float $max)
    {
        parent::__construct('numeric', $name);
        $this->min = $this->default = $min;
        $this->max = $max;
    }

    /**
     * @return $this
     */
    public function setMin(int|float $min): static
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
    public function setMax(int|float $max): static
    {
        $this->max = $max;

        if ($this->default > $max) {
            $this->default = $max;
        }

        return $this;
    }

    /**
     * Sets the default value.
     *
     * Note: if you want to set `float`s, use `addConfig('defaultValue', $value)` instead until the next major release.
     *
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

    /**
     * @return $this
     */
    public function setWidth(int $width): static
    {
        return $this->addConfig('width', $width);
    }

    protected function defaultConfig(): array
    {
        return [
            'minValue' => $this->min,
            'maxValue' => $this->max,
            'defaultValue' => (string) $this->default,
        ];
    }
}
