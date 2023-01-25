<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class NumericItem extends EditableItem
{
    public const ITEM_MIN_VALUE = 'minValue';
    public const ITEM_MAX_VALUE = 'maxValue';
    private int $min = 0;
    private int $max = 0;

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
            return $this->addConfig(static::ITEM_DEFAULT_VALUE, $value);
        }

        return $this;
    }

    /**
     * @param array<array-key, string> $data
     *
     * @return list<array{array-key, string}>
     */
    protected static function pack(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $result[] = [$key, $value];
        }

        return $result;
    }

    protected function getConfig(): array
    {
        return [
            self::ITEM_MIN_VALUE => $this->min,
            self::ITEM_MAX_VALUE => $this->max,
        ];
    }
}
